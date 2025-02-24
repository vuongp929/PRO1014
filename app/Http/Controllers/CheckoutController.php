<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\Offer;


class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('client.home')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $cart = session()->get('cart', []);

        // Tính tổng tiền từ giỏ hàng
        $total_price = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        // Áp dụng mã giảm giá (nếu có)
        $discount = session('discount', 0);
        $discountAmount = ($total_price * $discount) / 100;
        $total_price -= $discountAmount;

        $order = Order::where('user_id', auth()->id())->where('payment_status', 'unpaid')->first();
        $user = auth()->user();

        // Truyền biến sang view
        return view('clients.checkout.index', compact('order', 'cart', 'user', 'total_price', 'discount'));
    }


public function store(Request $request)
{
    $data = $request->validate([
        'name'    => 'required|string|max:255',
        'phone'   => 'required|string|max:20',
        'email'   => 'required|email|max:255',
        'shipping_address' => 'required|string|max:255',
        'payment_method' => 'required|in:vnpay,cod'
    ]);

    if (Auth::check()) {
        $user = Auth::user();
        if (!$user instanceof \App\Models\User) {
            return redirect()->back()->with('error', 'Lỗi xác thực người dùng.');
        }
        $user->fill([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['shipping_address'],
        ])->save();
    }

    $cart = session()->get('cart', []);

    // Tính tổng tiền giỏ hàng
    $totalAmount = array_reduce($cart, function ($sum, $item) {
        return $sum + ($item['price'] * $item['quantity']);
    }, 0);

    // ✅ Áp dụng mã giảm giá nếu có
    $discount = session('discount', 0);
    $discountAmount = ($totalAmount * $discount) / 100;
    $totalAmount -= $discountAmount;

    // Tạo đơn hàng
    $order = new Order();
    $order->user_id = Auth::id();
    $order->total_price = $totalAmount; // ✅ Đã cập nhật với giá sau khi giảm
    $order->status = 'pending';
    $order->payment_status = 'unpaid';
    $order->cart = json_encode($cart);
    $order->payment_method = $data['payment_method'];
    $order->save();

    // Xóa mã giảm giá sau khi áp dụng
    session()->forget('discount');
    session()->forget('cart');


    if ($data['payment_method'] == 'vnpay') {
        return redirect()->route('payment.vnpay.qr', ['orderId' => $order->id]);
    } else {
        $order->payment_status = 'cod';
        $order->status = 'processing';
        $order->save();
        return redirect()->route('client.home')->with('success', 'Đơn hàng đã được đặt và bạn sẽ thanh toán khi nhận hàng.');
    }
}

    public function applyDiscount(Request $request)
{
    $request->validate(['code' => 'required|string']);
    $offer = Offer::where('code', $request->code)
                  ->where('is_active', true)
                  ->where(function($query) {
                      $query->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                  })
                  ->first();

        if (!$offer) {
        return back()->with('error', 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.');
    }


    session()->put('discount', $offer->discount);
    return back()->with('success', "Áp dụng mã thành công! Giảm giá {$offer->discount}%.");
}
}
