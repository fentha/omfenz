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

        if ($status == 'berhasil') {
            $order->update([
                'status' => 'success',
                'ipaymu_trx_id' => $trx_id,
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
        return view('payment-success');
    }
}
