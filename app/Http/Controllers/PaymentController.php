<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessMail;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $amount = 49000; // Harga produk

        // Cek apakah ada order pending yang sudah punya payment_url untuk email ini
        $existingOrder = Order::where('email', $request->email)
            ->where('status', 'pending')
            ->whereNotNull('payment_url')
            ->where('created_at', '>=', now()->subHours(24)) // hanya order 24 jam terakhir
            ->latest()
            ->first();

        if ($existingOrder) {
            // Redirect ke payment URL yang sudah ada, tidak perlu buat order baru
            return redirect($existingOrder->payment_url);
        }

        $order = Order::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // Siapkan parameter untuk iPaymu
        $va = env('IPAYMU_VA');
        $apiKey = env('IPAYMU_KEY');
        $url = env('IPAYMU_ENV') == 'sandbox' 
            ? 'https://sandbox.ipaymu.com/api/v2/payment' 
            : 'https://my.ipaymu.com/api/v2/payment';

        $body = [
            'product' => ['Paket 99.000++ Aktivitas Anak'],
            'qty' => ['1'],
            'price' => [$amount],
            'returnUrl' => url('/payment/success?order_id=' . $order->id),
            'cancelUrl' => url('/'),
            'notifyUrl' => url('/payment/callback'),
            'buyerName' => $request->name,
            'buyerEmail' => $request->email,
            'buyerPhone' => $request->phone,
            'referenceId' => (string) $order->id,
        ];

        // Generate signature iPaymu
        $bodyEncrypt = hash('sha256', json_encode($body, JSON_UNESCAPED_SLASHES));
        $stringToSign = "POST:" . $va . ":" . $bodyEncrypt . ":" . $apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $apiKey);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'va' => $va,
                'signature' => $signature,
                // 'timestamp' => date('YmdHis'), // Optional on v2 if signature uses it differently, but iPaymu v2 signature only needs POST:va:bodyEncrypt:apikey
            ])->post($url, $body);

            $result = $response->json();

            if ($response->successful() && isset($result['Data']['Url'])) {
                $order->update([
                    'ipaymu_session_id' => $result['Data']['SessionId'] ?? null,
                    'ipaymu_trx_id' => $result['Data']['TransactionId'] ?? null,
                    'payment_url' => $result['Data']['Url'],
                ]);
                return redirect($result['Data']['Url']);
            }

            Log::error('iPaymu Checkout Failed:', $result ?? []);
            return back()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('iPaymu Exception: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    public function callback(Request $request)
    {
        Log::info('iPaymu Webhook Callback:', $request->all());

        $status = $request->status;
        $trx_id = $request->trx_id;
        $reference_id = $request->reference_id; // id order kita

        $order = Order::find($reference_id);
        
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($status == 'berhasil' || $request->status_code == 1) {
            $via = $request->via ? strtoupper($request->via) : '';
            $channel = $request->channel ? strtoupper($request->channel) : '';
            $paymentMethod = trim(($via ? $via . ' ' : '') . $channel);

            $fee = (float) ($request->fee ?? 0);
            $netAmount = isset($request->paid_off) ? (float) $request->paid_off : ($order->amount - $fee);
            $paidAt = $request->paid_at ? \Carbon\Carbon::parse($request->paid_at) : now();

            $order->update([
                'status' => 'success',
                'ipaymu_trx_id' => $trx_id,
                'payment_method' => $paymentMethod ?: ($order->payment_method ?? null),
                'fee' => $fee,
                'net_amount' => $netAmount,
                'paid_at' => $paidAt,
            ]);
            
            // Kirim email akses produk ke pembeli
            try {
                Mail::to($order->email)->send(new OrderSuccessMail($order));
                Log::info('Email sukses terkirim ke: ' . $order->email);
            } catch (\Exception $e) {
                Log::error('Gagal kirim email ke ' . $order->email . ': ' . $e->getMessage());
            }

        } elseif (in_array(strtolower($status), ['gagal', 'expired', 'batal'])) {
            $order->update([
                'status' => 'failed',
            ]);
        }

        return response()->json(['message' => 'OK']);
    }

    public function success(Request $request)
    {
        $order = Order::find($request->order_id);

        if (!$order) {
            return redirect('/')->with('error', 'Order tidak ditemukan.');
        }

        if ($order->status === 'success') {
            return view('payment-success');
        } elseif ($order->status === 'pending') {
            return view('payment-pending', compact('order'));
        } else {
            return redirect('/')->with('error', 'Pembayaran gagal atau dibatalkan.');
        }
    }

    public function checkoutDev(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $amount = 49000; // Harga produk

        // Cek apakah ada order pending yang sudah punya payment_url untuk email ini
        $existingOrder = Order::where('email', $request->email)
            ->where('status', 'pending')
            ->whereNotNull('payment_url')
            ->where('created_at', '>=', now()->subHours(24)) // hanya order 24 jam terakhir
            ->latest()
            ->first();

        if ($existingOrder) {
            // Redirect ke payment URL yang sudah ada, tidak perlu buat order baru
            return redirect($existingOrder->payment_url);
        }

        $order = Order::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // Sandbox iPaymu
        $va = '0000005643661105';
        $apiKey = 'SANDBOXD752AC4B-DF7F-4CE9-BB8B-89CEA6EEFAFD';
        $url = 'https://sandbox.ipaymu.com/api/v2/payment';

        $body = [
            'product' => ['Paket 99.000++ Aktivitas Anak'],
            'qty' => ['1'],
            'price' => [$amount],
            'returnUrl' => url('/payment/success?order_id=' . $order->id),
            'cancelUrl' => url('/'),
            'notifyUrl' => url('/payment/callback/dev'),
            'buyerName' => $request->name,
            'buyerEmail' => $request->email,
            'buyerPhone' => $request->phone,
            'referenceId' => (string) $order->id,
        ];

        // Generate signature iPaymu
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

            if ($response->successful() && isset($result['Data']['Url'])) {
                $order->update([
                    'ipaymu_session_id' => $result['Data']['SessionId'] ?? null,
                    'ipaymu_trx_id' => $result['Data']['TransactionId'] ?? null,
                    'payment_url' => $result['Data']['Url'],
                ]);
                return redirect($result['Data']['Url']);
            }

            Log::error('DEV iPaymu Checkout Failed:', $result ?? []);
            return back()->with('error', 'Gagal memproses pembayaran sandbox. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('DEV iPaymu Exception: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem sandbox. Silakan coba lagi.');
        }
    }

    public function callbackDev(Request $request)
    {
        Log::info('DEV iPaymu Webhook Callback:', $request->all());

        $status = $request->status;
        $trx_id = $request->trx_id;
        $reference_id = $request->reference_id; // id order kita

        $order = Order::find($reference_id);
        
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($status == 'berhasil' || $request->status_code == 1) {
            $via = $request->via ? strtoupper($request->via) : '';
            $channel = $request->channel ? strtoupper($request->channel) : '';
            $paymentMethod = trim(($via ? $via . ' ' : '') . $channel);

            $fee = (float) ($request->fee ?? 0);
            $netAmount = isset($request->paid_off) ? (float) $request->paid_off : ($order->amount - $fee);
            $paidAt = $request->paid_at ? \Carbon\Carbon::parse($request->paid_at) : now();

            $order->update([
                'status' => 'success',
                'ipaymu_trx_id' => $trx_id,
                'payment_method' => $paymentMethod ?: ($order->payment_method ?? null),
                'fee' => $fee,
                'net_amount' => $netAmount,
                'paid_at' => $paidAt,
            ]);
            
            // Kirim email akses produk ke pembeli
            try {
                Mail::to($order->email)->send(new OrderSuccessMail($order));
                Log::info('DEV Email sukses terkirim ke: ' . $order->email);
            } catch (\Exception $e) {
                Log::error('DEV Gagal kirim email ke ' . $order->email . ': ' . $e->getMessage());
            }

        } elseif (in_array(strtolower($status), ['gagal', 'expired', 'batal'])) {
            $order->update([
                'status' => 'failed',
            ]);
        }

        return response()->json(['message' => 'OK']);
    }
}
