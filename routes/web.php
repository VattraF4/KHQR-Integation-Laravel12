<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::get('/verify', [PaymentController::class, 'verifyForm'])->name('verify.form');
Route::post('/verify', [PaymentController::class, 'verifyTransaction'])->name('verify.transaction');
Route::get('/payments/result', [PaymentController::class, 'paymentResult'])->name('payments.result');