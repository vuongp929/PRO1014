@extends('layouts.client')

@section('title', 'Danh Sách Sản Phẩm')

@section('CSS')
    <link rel="stylesheet" href="{{ asset('assets/user/css/shop-index.css') }}">
@endsection

@section('content')
    <h2>Quét mã QR để thanh toán đơn hàng</h2>
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($paymentUrl) }}" alt="QR Code Thanh Toán">
    <p>Số tiền đã được ghi nhận trong QR.</p>
    <a href="{{ route('dashboard') }}">Quay về trang chủ</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

@endsection


@section('JS')
    <script src="{{ asset('assets/user/js/shop-index.js') }}"></script>
@endsection
