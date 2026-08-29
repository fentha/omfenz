<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderSuccessMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders with filtering and statistics.
     */
    public function index(Request $request)
    {
        $query = Order::query()->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhere('ipaymu_trx_id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        // Statistics
        $totalOrders = Order::count();
        $totalSuccess = Order::where('status', 'success')->count();
        $totalPending = Order::where('status', 'pending')->count();
        $totalFailed = Order::where('status', 'failed')->count();
        $totalRevenue = Order::where('status', 'success')->sum('amount');

        return view('orders.index', compact(
            'orders',
            'totalOrders',
            'totalSuccess',
            'totalPending',
            'totalFailed',
            'totalRevenue'
        ));
    }

    /**
     * Update order status manually.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,success,failed',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // If changed to success, send access email
        if ($request->status === 'success' && $oldStatus !== 'success') {
            try {
                Mail::to($order->email)->send(new OrderSuccessMail($order));
                Log::info("Manual email success sent to: {$order->email}");
            } catch (\Exception $e) {
                Log::error("Failed sending email to {$order->email}: " . $e->getMessage());
                return back()->with('warning', "Status pesanan diubah ke SUKSES, tetapi pengiriman email gagal: " . $e->getMessage());
            }
        }

        return back()->with('success', "Status pesanan #{$order->id} berhasil diubah menjadi " . strtoupper($order->status));
    }

    /**
     * Sync and check order status directly with iPaymu API.
     */
    public function syncStatus(Order $order)
    {
        $va = env('IPAYMU_VA');
        $apiKey = env('IPAYMU_KEY');
        $url = env('IPAYMU_ENV') == 'sandbox'
            ? 'https://sandbox.ipaymu.com/api/v2/transaction'
            : 'https://my.ipaymu.com/api/v2/transaction';

        if (!$order->ipaymu_trx_id && !$order->id) {
            return back()->with('error', "Order #{$order->id} belum memiliki ID Transaksi Gateway.");
        }

        // Siapkan request parameter untuk cek transaksi iPaymu
        $body = [
            'transactionId' => (int) ($order->ipaymu_trx_id ?? 0),
        ];

        // Jika tidak ada trx_id, coba cari berdasarkan session / reference
        if (!$order->ipaymu_trx_id) {
            $body = [
                'account' => $va,
            ];
        }

        $bodyEncrypt = hash('sha256', json_encode($body, JSON_UNESCAPED_SLASHES));
        $stringToSign = "POST:" . $va . ":" . $bodyEncrypt . ":" . $apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $apiKey);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'va' => $va,
                'signature' => $signature,
            ])->post($url, $body);

            $result = $response->json();
            Log::info("iPaymu Check Transaction Response for Order #{$order->id}:", $result ?? []);

            if ($response->successful() && isset($result['Data'])) {
                $data = $result['Data'];
                $statusVal = strtolower((string) ($data['Status'] ?? $data['StatusDescription'] ?? ''));
                $statusCode = $data['StatusCode'] ?? $data['Status'] ?? null;

                // Cek status dari response iPaymu
                if ($statusCode == 1 || in_array($statusVal, ['berhasil', 'success', 'paid', 'settlement', 'lunas', '1'])) {
                    $order->status = 'success';
                    if (isset($data['TransactionId'])) {
                        $order->ipaymu_trx_id = $data['TransactionId'];
                    }
                    if (isset($data['Via']) || isset($data['Channel']) || isset($data['PaymentMethod'])) {
                        $via = $data['Via'] ?? '';
                        $channel = $data['Channel'] ?? $data['PaymentMethod'] ?? '';
                        $order->payment_method = trim(($via ? strtoupper($via) . ' ' : '') . strtoupper($channel));
                    }
                    if (isset($data['Fee'])) {
                        $order->fee = (float) $data['Fee'];
                    }
                    if (isset($data['PaidOff'])) {
                        $order->net_amount = (float) $data['PaidOff'];
                    }
                    if (isset($data['PaidAt']) || isset($data['PaidDate'])) {
                        $order->paid_at = \Carbon\Carbon::parse($data['PaidAt'] ?? $data['PaidDate']);
                    }
                    $order->save();

                    // Kirim email akses jika belum terkirim
                    try {
                        Mail::to($order->email)->send(new OrderSuccessMail($order));
                    } catch (\Exception $e) {
                        Log::error("Sync email error: " . $e->getMessage());
                    }

                    return back()->with('success', "iPaymu API: Transaksi #{$order->id} SUKSES / LUNAS. Status berhasil disinkronkan!");
                } elseif ($statusCode == 0 || in_array($statusVal, ['pending', 'menunggu pembayaran', '0'])) {
                    $order->status = 'pending';
                    $order->save();
                    return back()->with('warning', "iPaymu API: Transaksi #{$order->id} masih PENDING (Menunggu Pembayaran).");
                } elseif (in_array($statusCode, [2, 3]) || in_array($statusVal, ['expired', 'batal', 'gagal', 'failed', 'cancel'])) {
                    $order->status = 'failed';
                    $order->save();
                    return back()->with('error', "iPaymu API: Transaksi #{$order->id} GAGAL / KEDALUWARSA (Status: {$statusVal}).");
                } else {
                    return back()->with('warning', "iPaymu Response: " . ($data['StatusDescription'] ?? json_encode($data)));
                }
            }

            $errorMsg = $result['Message'] ?? 'Tidak dapat memperoleh status dari server iPaymu.';
            return back()->with('error', "Gagal cek API iPaymu: {$errorMsg}");
        } catch (\Exception $e) {
            Log::error("iPaymu Sync Exception: " . $e->getMessage());
            return back()->with('error', "Koneksi ke iPaymu error: " . $e->getMessage());
        }
    }

    /**
     * Resend access email to customer.
     */
    public function resendEmail(Order $order)
    {
        try {
            Mail::to($order->email)->send(new OrderSuccessMail($order));
            return back()->with('success', "Email akses produk berhasil dikirim ulang ke {$order->email}");
        } catch (\Exception $e) {
            return back()->with('error', "Gagal mengirim email: " . $e->getMessage());
        }
    }

    /**
     * Delete an order.
     */
    public function destroy(Order $order)
    {
        $orderId = $order->id;
        $order->delete();

        return back()->with('success', "Pesanan #{$orderId} berhasil dihapus.");
    }
}
