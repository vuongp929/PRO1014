<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = Order::with('customer')->orderBy('created_at', 'desc')->paginate(10);
        return view('admins.orders.index', compact('orders'));
    }

    // Xem chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'customer'])->findOrFail($id);
        return view('admins.orders.show', compact('order'));
    }

    // Cập nhật thông tin đơn hàng (trạng thái, trạng thái thanh toán, v.v.)
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Cập nhật trạng thái hoặc trạng thái thanh toán
        if ($request->has('status')) {
            $order->status = $request->status;
        }

        if ($request->has('payment_status')) {
            $order->payment_status = $request->payment_status; // Nếu có cột này
        }

        $order->save();

        return redirect()->route('orders.index')->with('success', 'Thông tin đơn hàng đã được cập nhật.');
    }
}
