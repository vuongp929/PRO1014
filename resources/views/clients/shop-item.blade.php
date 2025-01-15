@extends('user.layouts.master')

@section('title', $product->name)

@section('CSS')
    <link rel="stylesheet" href="{{ asset('assets/user/css/shop-item.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <h4 class="text-danger">{{ number_format($product->price, 0, ',', '.') }} VND</h4>
            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="quantity" class="form-label">Số lượng</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control" style="width: 100px;">
                </div>
                <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
            </form>
        </div>
    </div>
@endsection

@section('JS')
    <script src="{{ asset('assets/user/js/shop-item.js') }}"></script>
@endsection
