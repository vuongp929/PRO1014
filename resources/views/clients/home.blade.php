@extends('layouts.client')

@section('title', 'Danh Sách Sản Phẩm')

@section('CSS')
    <link rel="stylesheet" href="{{ asset('assets/user/css/shop-index.css') }}">
    {{-- <style>
        .featured-products h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: transparent;
            transition: transform 0.3s ease;
            margin-bottom: 30px;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-img-top {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
        }

        .card-body {
            padding: 15px;
            text-align: center;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #8357ae;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #8357ae;
        }

        /* Nút chọn size */
        .size-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .size-button {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 15px;
            background-color: white;
            font-size: 1rem;
            cursor: pointer;
            color: #555;
            transition: all 0.3s ease;
        }

        .size-button.selected {
            background-color: #8357ae;
            color: white;
            border-color: #8357ae;
        }

        .btn-primary {
            background-color: #8357ae;
            border-color: #8357ae;
            border-radius: 15px;
            padding: 12px;
            font-size: 1.1rem;
            color: white;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #723e8a;
        }

        /* Responsive cho sản phẩm */
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .col-md-3 {
            flex: 0 0 23%;
            box-sizing: border-box;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .col-md-3 {
                flex: 0 0 23%;
            }
        }

        @media (max-width: 576px) {
            .col-md-3 {
                flex: 0 0 50%;
            }
        }
    </style> --}}
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <div class="banner mb-5">
        <img src="https://via.placeholder.com/1200x400" alt="Banner" class="img-fluid rounded">
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
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('JS')
<script>
    // Hàm chọn size và cập nhật giao diện

    document.addEventListener('DOMContentLoaded', function () {
    // Lấy tất cả các form trong trang có class 'ajax-form'
    const ajaxForms = document.querySelectorAll('form.ajax-form');
    
    ajaxForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Thu thập dữ liệu từ form
            const formData = new FormData(form);
            const actionUrl = form.action;

            // Gửi AJAX request
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
                    // Tải lại trang hoặc cập nhật giỏ hàng nếu cần
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
