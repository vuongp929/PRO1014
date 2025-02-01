@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Chi tiết đơn hàng #{{ $order->id }}</h4>

    <div class="mb-4">
        <strong>Khách hàng:</strong> {{ $order->customer->name }} <br>
        <strong>Email:</strong> {{ $order->customer->email }} <br>
        <strong>Trạng thái:</strong> {{ $order->status }} <br>
        <strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VNĐ <br>
        <strong>Ngày tạo:</strong> {{ $order->created_at->format('d-m-Y H:i') }}
    </div>

    <h5>Sản phẩm trong đơn hàng</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Kích thước</th>
                <th>Màu sắc</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
        <tr>
            <td>{{ $item->productVariant->product->name }}</td>
            <td>{{ $item->size }}</td> <!-- Lấy size từ order_items -->
            <td>{{ $item->productVariant->color }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price_at_order, 0, ',', '.') }} VNĐ</td> <!-- Giá tại thời điểm đặt hàng -->
            <td>{{ number_format($item->quantity * $item->price_at_order, 0, ',', '.') }} VNĐ</td>
        </tr>
    @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
