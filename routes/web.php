<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Public Pages
Route::get('/', function () {
    return view('welcome');
});

Route::get('/aktivitas-anak', function () {
    return view('aktivitas-anak');
});

Route::get('/aktivitas-anak-dev', function () {
    return view('aktivitas-anak-dev');
});

Route::get('/faq', function () {
    return view('faq');
});

Route::get('/kontak', function () {
    return view('kontak');
});

Route::get('/syarat-ketentuan', function () {
    return view('syarat-ketentuan');
});

Route::get('/refund-policy', function () {
    return view('refund-policy');
});

// Checkout & Payment Callbacks
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('/checkout-dev', [PaymentController::class, 'checkoutDev'])->name('checkout.dev');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

// Admin Authenticated Dashboard & Orders
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $recentOrders = \App\Models\Order::latest()->take(5)->get();
        $totalOrders = \App\Models\Order::count();
        $totalSuccess = \App\Models\Order::where('status', 'success')->count();
        $totalPending = \App\Models\Order::where('status', 'pending')->count();
        $totalRevenue = \App\Models\Order::where('status', 'success')->sum('amount');

        return view('dashboard', compact(
            'recentOrders',
            'totalOrders',
            'totalSuccess',
            'totalPending',
            'totalRevenue'
        ));
    })->name('dashboard');

    // Orders Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{order}/sync', [OrderController::class, 'syncStatus'])->name('orders.syncStatus');
    Route::post('/orders/{order}/resend-email', [OrderController::class, 'resendEmail'])->name('orders.resendEmail');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
