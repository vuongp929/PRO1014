@extends('layouts.client')

@section('title', 'Danh Sách Sản Phẩm')

@section('CSS')
    <link rel="stylesheet" href="{{ asset('assets/user/css/shop-index.css') }}">
    <style>
        .banner {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 15px;
        }

        .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }

        .banner-content h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .banner-content p {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .banner-content .btn {
            margin-top: 15px;
            background-color: #ff7f50;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 1.2rem;
            color: white;
            text-decoration: none;
        }

        .banner-content .btn:hover {
            background-color: #e67340;
        }
    </style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <div class="banner mb-5">
        <img src="https://teddy.vn/wp-content/uploads/2024/01/banner-thuong_DC.jpg" alt="Banner">
        {{-- <div class="banner-content">
            <h1>Chào mừng đến với cửa hàng gấu bông!</h1>
            <p>Khám phá bộ sưu tập gấu bông dễ thương với giá tốt nhất.</p>
            <a href="#" class="btn">Mua sắm ngay</a>
        </div> --}}
    </div>

    <div class="featured-products">
        <h2>Sản phẩm nổi bật</h2>
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3">
                <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none">
                    <div class="card">
                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                            </a>
                            <form action="{{ route('cart.add') }}" method="POST" onsubmit="return validateSizeSelection({{ $product->id }})">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" id="selected-size-{{ $product->id }}" name="size" value="{{ optional($product->variants->first())->id }}">
                                <input type="hidden" name="redirect_url" value="{{ url()->current() }}">
                                <!-- Nút chọn size -->

                                <div class="size-buttons">
                                    @foreach ($product->variants as $variant)
                                        <button type="button" class="size-button"
                                            data-size-id="{{ $variant->id }}"
                                            data-price="{{ $variant->price }}"
                                            onclick="selectSize({{ $product->id }}, this)">
                                            {{ $variant->size }}
                                        </button>
                                    @endforeach
                                </div>
                                <!-- Giá sản phẩm -->
                                <p class="price mt-2">
                                    Giá: <span id="product-price-{{ $product->id }}">{{ number_format(optional($product->variants->first())->price ?? 0) }} VND</span>
                                </p>
                                <button type="submit" class="btn btn-add btn-block mt-3">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('JS')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ajaxForms = document.querySelectorAll('form.ajax-form');

        ajaxForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(form);
                const actionUrl = form.action;
                fetch(actionUrl, {
                    method: form.method || 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Thao tác thành công!');
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    } else {
                        alert(data.message || 'Có lỗi xảy ra.');
                    }
                }).catch(error => console.error('Lỗi AJAX:', error));
            });
        });
    });
</script>
@endsection
