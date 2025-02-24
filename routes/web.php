<?php

use App\Http\Controllers\{
    ProfileController, DashBoardController, ProductController, OrderController,
    MyOrderController, UserController, PaymentController, ClientController,
    CartController, CheckoutController, CategoryController, ContactController, DiscountController, FeedbackController,
    OfferController
};
use App\Models\Category;
use Illuminate\Support\Facades\Route;

// Route cho trang chủ
Route::get('/', [ClientController::class, 'index'])->name('client.home');
Route::get('/search', [ProductController::class, 'search'])->name('client.search');

// Dashboard chỉ admin mới truy cập được
Route::get('/dashboard', [DashBoardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard');

// Group route admin với middleware bảo vệ
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
    Route::resource('feedback', FeedbackController::class);
    Route::resource('offers', OfferController::class);
    Route::resource('category', CategoryController::class);
    Route::get('/add-to-cart/{productId}', [ProductController::class, 'addToCart'])->name('products.add-to-cart');
});

// Group route cho người dùng đã đăng nhập (customer)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/logout', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('clients')->group(function () {
        Route::get('/orders', [MyOrderController::class, 'index'])->name('client.orders.index');
        Route::get('/orders/{order}', [MyOrderController::class, 'show'])->name('client.orders.show');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    });

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'viewCart'])->name('cart.view');
        Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
        Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    });
});

// Checkout (không cần đăng nhập nhưng vẫn yêu cầu thông tin khách hàng)
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/cart/apply-discount', [DiscountController::class, 'applyDiscount'])->name('cart.apply-discount');
});

// Payment VNPay
Route::prefix('payment/vnpay')->group(function () {
    Route::get('/order/{orderId}', [PaymentController::class, 'createQRPayment'])->name('payment.vnpay.qr');
    Route::get('/return', [PaymentController::class, 'vnpayReturn'])->name('payment.vnpay.return');
    Route::post('/ipn', [PaymentController::class, 'vnpayIpn'])->name('payment.vnpay.ipn');
});

// Xem chi tiết đơn hàng, hủy đơn hàng
Route::get('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('client.orders.cancel');

// Trang danh mục sản phẩm
Route::get('/category/{slug}', [CategoryController::class, 'showCategory'])->name('client.category');

// Trang liên hệ
Route::get('/contact', [ContactController::class, 'index'])->name('client.contact');

// Chi tiết sản phẩm
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

require __DIR__.'/auth.php';
