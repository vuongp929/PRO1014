@extends('layouts.client')

@section('title', 'Danh Sách Sản Phẩm')

@section('CSS')
    <link rel="stylesheet" href="{{ asset('assets/user/css/shop-index.css') }}">
@endsection

@section('content')
<div class="container">
    <!-- Banner hoặc slider -->
    <div class="banner">
        <img src="https://via.placeholder.com/1200x400" alt="Banner" class="img-fluid">
    </div>

    <!-- Danh sách sản phẩm nổi bật -->
    <div class="featured-products mt-5">
        <h2>Sản phẩm nổi bật</h2>
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                            <a href="{{ route('products.add-to-cart', $product->id) }}" class="btn btn-primary">Thêm vào giỏ</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Khuyến mãi hoặc bộ sưu tập -->
    <div class="promotions mt-5">
        <h2>Khuyến mãi đặc biệt</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="promotion-card">
                    <img src="https://via.placeholder.com/300x200" alt="Khuyến mãi" class="img-fluid">
                    <h5>Giảm giá đến 50%</h5>
                    <p>Nhận giảm giá đặc biệt khi mua sắm các sản phẩm yêu thích</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="promotion-card">
                    <img src="https://via.placeholder.com/300x200" alt="Khuyến mãi" class="img-fluid">
                    <h5>Miễn phí vận chuyển</h5>
                    <p>Miễn phí vận chuyển cho đơn hàng trên 500k</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="promotion-card">
                    <img src="https://via.placeholder.com/300x200" alt="Khuyến mãi" class="img-fluid">
                    <h5>Mua 1 tặng 1</h5>
                    <p>Nhận thêm một món quà hấp dẫn khi mua sản phẩm trong bộ sưu tập</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('JS')
    {{-- Thêm JS riêng nếu cần --}}
@endsection
