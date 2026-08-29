<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderSuccessMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
            'send_email' => 'nullable|boolean',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // If status changed to success and send_email is requested
        if ($request->status === 'success' && $request->boolean('send_email')) {
            try {
                Mail::to($order->email)->send(new OrderSuccessMail($order));
                Log::info("Manual email success sent to: {$order->email}");
            } catch (\Exception $e) {
                Log::error("Failed sending email to {$order->email}: " . $e->getMessage());
                return back()->with('warning', "Status pesanan diubah, namun gagal mengirim email: " . $e->getMessage());
            }
        }

        return back()->with('success', "Status pesanan #{$order->id} berhasil diubah menjadi " . strtoupper($order->status));
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
