@extends('layouts.client')

@section('content')
    <div class="container">
        <p>Đơn hàng của bạn đã được thanh toán thành công và đang được vận chuyển!</p>
        <p>Thông tin đơn hàng:</p>
        <ul>
            <li>Mã đơn hàng: {{ $order->id }}</li>
            <li>Tổng giá trị: {{ $order->total_price }}</li>
            <li>Trạng thái: {{ $order->status }}</li>
            <li>Trạng thái thanh toán: {{ $order->payment_status }}</li>
        </ul>
        <a href="{{ route('client.home') }}" class="btn btn-primary">Quay lại trang chủ</a>
    </div>
@endsection
