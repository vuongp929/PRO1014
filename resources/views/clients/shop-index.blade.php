@extends('layouts.master')

@section('title', 'Danh Sách Sản Phẩm')

@section('CSS')
    <link rel="stylesheet" href="{{ asset('assets/user/css/shop-index.css') }}">
@endsection

@section('content')
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-danger">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('JS')
    <script src="{{ asset('assets/user/js/shop-index.js') }}"></script>
@endsection
