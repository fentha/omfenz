<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/aktivitas-anak', 'aktivitas-anak');
Route::redirect('/worksheet-anak', '/aktivitas-anak');

Route::post('/checkout', [\App\Http\Controllers\PaymentController::class, 'checkout']);
Route::post('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback']);
Route::get('/payment/success', [\App\Http\Controllers\PaymentController::class, 'success']);

// Halaman Verifikasi iPaymu
Route::view('/faq', 'faq');
Route::view('/syarat-ketentuan', 'syarat-ketentuan');
Route::view('/refund-policy', 'refund-policy');
Route::view('/kontak', 'kontak');

// Dev Routes untuk iPaymu Sandbox
Route::view('/aktivitas-anak/dev', 'aktivitas-anak-dev');
Route::post('/checkout/dev', [\App\Http\Controllers\PaymentController::class, 'checkoutDev']);
Route::post('/payment/callback/dev', [\App\Http\Controllers\PaymentController::class, 'callbackDev']);
