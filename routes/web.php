<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeedbackController;
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

Route::get('/', [ClientController::class, 'index'])->name('client.home');
Route::get('/search', [ProductController::class, 'search'])->name('client.search');


Route::get('/dashboard', [DashBoardController::class, 'index'])
            ->middleware(['auth', 'verified'])
            ->name('dashboard');

Route::middleware(['auth', 'check.admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::resource('products', ProductController::class);
        Route::get('/add-to-cart/{productId}', [ProductController::class, 'addToCart'])->name('products.add-to-cart');
        Route::resource('orders', OrderController::class);
        Route::resource('users', UserController::class);


    });
});

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/add-to-cart/{productId}', [ProductController::class, 'addToCart'])->name('products.add-to-cart');
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
    Route::resource('category', CategoryController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/logout', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // route admin feedback
    Route::resource('feedback', FeedbackController::class);
    Route::get('feedback/{feedback}', [FeedbackController::class, 'show'])
        ->name('feedback.show');
    Route::delete('feedback/{feedback}', [FeedbackController::class, 'destroy'])
        ->name('feedback.destroy');
    Route::patch('feedback/{feedback}/update-status', [FeedbackController::class, 'updateStatus'])->name('feedback.update-status');
});

Route::middleware('auth')->prefix('clients')->group(function () {
    Route::get('/orders', [MyOrderController::class, 'index'])->name('client.orders.index');
    Route::get('/orders/{order}', [MyOrderController::class, 'show'])->name('client.orders.show');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

});

Route::get('/category/{slug}', [CategoryController::class, 'showCategory'])->name('client.category');

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

Route::middleware(['web', 'auth'])->prefix('clients')->group(function () {
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
});


Route::prefix('clients')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

Route::get('/payment/vnpay/order/{orderId}', [PaymentController::class, 'createQRPayment'])
    ->name('payment.vnpay.qr');
Route::get('/payment/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('payment.vnpay.return');
Route::post('payment/vnpay/ipn', [PaymentController::class, 'vnpayIpn'])->name('payment.vnpay.ipn');
Route::get('/checkout/success', [PaymentController::class, 'paymentVnpaySuccess'])->name('checkout.success');
Route::get('/checkout/failed', [PaymentController::class, 'paymentFailed'])->name('checkout.failed');
Route::get('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('client.orders.cancel');


Route::get('/contact', [ContactController::class, 'index'])->name('client.contact');



Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');



require __DIR__.'/auth.php';
