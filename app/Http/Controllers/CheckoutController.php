<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!auth()->check()) {
            return redirect()->route('client.home')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }
        // Kiểm tra giỏ hàng từ session
        $cart = session()->get('cart', []);
        // dd($cart);

        // Kiểm tra đơn hàng đang chờ thanh toán
        $order = Order::where('user_id', auth()->id())->where('payment_status', 'unpaid')->first();

        $user = auth()->user();
        return view('clients.checkout.index', compact('order', 'cart', 'user'));
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

        $totalAmount = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        if ($totalAmount < 5000 || $totalAmount >= 1000000000) {
            return redirect()->route('cart.view')->with('error', 'Số tiền thanh toán không hợp lệ.');
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->total_price = $totalAmount;
        $order->save();

        if ($data['payment_method'] == 'vnpay') {
            return redirect()->route('payment.vnpay.qr', ['orderId' => $order->id]);
        } else {
            $order->payment_status = 'cod';
            $order->status = 'processing';
            $order->save();
            return redirect()->route('client.home')->with('success', 'Đơn hàng đã được đặt và bạn sẽ thanh toán khi nhận hàng.');
        }
    }
}
