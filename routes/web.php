<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------------------------- 
| Web Routes 
|---------------------------------------------------------------------- 
| 
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider and all of them will be 
| assigned to the "web" middleware group. Make something great! 
|
*/

// Route cho trang chủ
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [ClientController::class, 'home'])->name('client.home');

Route::get('/dashboard', [DashBoardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/add-to-cart/{productId}', [ProductController::class, 'addToCart'])->name('products.add-to-cart');
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/logout', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [ProfileController::class, 'verify'])
        ->middleware(['auth', 'signed'])
        ->name('verification.verify');

    Route::post('/email/resend', [ProfileController::class, 'resendVerificationEmail'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.resend');
});

Route::get('/payment/vnpay-qr', [PaymentController::class, 'createQRPayment'])->name('payment.vnpay.qr');
Route::get('/payment/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('payment.vnpay.return');


require __DIR__.'/auth.php';
