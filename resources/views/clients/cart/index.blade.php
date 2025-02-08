@extends('layouts.client')

@section('content')
<div class="container">
    <h2>Giỏ hàng</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(!empty($cart))
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng cộng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $productId => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td><img src="{{ asset('storage/' . $item['image']) }}" alt="Hình ảnh sản phẩm" width="100px"></td>


                    <td>{{ number_format($item['price']) }} VND</td>
                    <td>
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <input type="number" name="products[{{ $productId }}]" value="{{ $item['quantity'] }}" min="1">
                            <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                        </form>
                    </td>
                    <td>{{ number_format($item['price'] * $item['quantity']) }} VND</td>
                    <td>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $productId }}">
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h4>Tổng cộng: {{ number_format($total) }} VND</h4>
        <a href="{{ route('checkout.index') }}" class="btn btn-success">Thanh toán</a>
    @else
        <p>Giỏ hàng của bạn đang trống!</p>
    @endif
</div>
@endsection
