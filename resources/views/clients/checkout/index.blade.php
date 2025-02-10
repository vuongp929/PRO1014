@extends('layouts.client')

@section('content')
<div class="container mt-5">
    <h2>Thanh toán</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


        <h3>Thông tin giỏ hàng</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>
                            @if (isset($item['image']))
                                <img src="{{ Storage::url($item['image']) }}" alt="Hình ảnh sản phẩm" width="100px">
                            @else
                                <img src="{{ asset('images/default-product.jpg') }}" alt="Hình ảnh mặc định" width="100px">
                            @endif
                        </td>

                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="mt-4">Thông tin khách hàng</h3>
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Tên khách hàng -->
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', optional($user)->name) }}" required>
                </div>

                <!-- Số điện thoại -->
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                        value="{{ old('phone', optional($user)->phone) }}" required>
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', optional($user)->email) }}" required>
                </div>

                <!-- Địa chỉ -->
                <div class="col-md-6 mb-3">
                    <label for="shipping_address" class="form-label">Địa chỉ</label>
                    <input type="text" name="shipping_address" id="shipping_address" class="form-control"
                        value="{{ old('shipping_address', optional($user)->shipping_address) }}" required>
                </div>
            </div>

            <h4 class="mt-4">Phương thức thanh toán</h4>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" value="vnpay" id="vnpay" required>
                <label class="form-check-label" for="vnpay">
                    Thanh toán qua VNPay
                </label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod" required>
                <label class="form-check-label" for="cod">
                    Thanh toán khi nhận hàng (COD)
                </label>
            </div>

            @if(optional($order)->payment_status == 'paid')
                <p>Đơn hàng của bạn đã được thanh toán và đang được xử lý.</p>
            @else
                <button type="submit" class="btn btn-primary mt-3">Đặt hàng</button>
            @endif
        </form>


</div>
@endsection
