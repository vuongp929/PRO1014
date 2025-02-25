@extends('layouts.client')

@section('title', 'Chi Tiết Sản Phẩm')

@section('CSS')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div id="content" class="site-content">
            <!-- Breadcrumb -->
            <ul id="breadcrumb" class="breadcrumb flex items-center space-x-2 text-gray-500 text-sm mb-6">
                <li class="breadcrumb-item home">
                    <a href="/" class="hover:text-blue-600 transition-colors duration-200">Trang chủ</a>
                </li>
                <li class="text-gray-400">/</li>
                @if ($product->categories->isNotEmpty())
                    <li class="breadcrumb-item">
                        <a href="{{ route('client.category', ['slug' => $product->categories->first()->slug]) }}" class="hover:text-blue-600 transition-colors duration-200">
                            {{ $product->categories->first()->name }}
                        </a>
                    </li>
                    <li class="text-gray-400">/</li>
                @endif

                <li class="breadcrumb-item font-medium text-gray-800">{{ $product->name }}</li>
            </ul>

            <!-- Services Section -->
            <section class="module module-home-services mb-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="p-2 transform transition duration-300 hover:scale-105">
                        <a class="home-service flex flex-col items-center" href="#" rel="nofollow">
                            <img class="w-16 h-16 md:w-20 md:h-20 object-contain" src="https://teddy.vn/wp-content/uploads/2017/07/Artboard-16-1-e1661254198715.png" alt="Giao Hàng Tận Nhà" />
                            <strong class="title mt-3 text-center text-sm md:text-base font-semibold text-gray-700">Giao Hàng Tận Nhà</strong>
                        </a>
                    </div>
                    <div class="p-2 transform transition duration-300 hover:scale-105">
                        <a class="home-service flex flex-col items-center" href="#" rel="nofollow">
                            <img class="w-16 h-16 md:w-20 md:h-20 object-contain" src="https://teddy.vn/wp-content/uploads/2017/07/Artboard-16-copy-1.png" alt="Gói Quà Siêu Đẹp" />
                            <strong class="title mt-3 text-center text-sm md:text-base font-semibold text-gray-700">Gói Quà Siêu Đẹp</strong>
                        </a>
                    </div>
                    <div class="p-2 transform transition duration-300 hover:scale-105">
                        <a class="home-service flex flex-col items-center" href="#" rel="nofollow">
                            <img class="w-16 h-16 md:w-20 md:h-20 object-contain" src="https://teddy.vn/wp-content/uploads/2017/07/Artboard-16-copy-2-1.png" alt="Cách Giặt Gấu Bông" />
                            <strong class="title mt-3 text-center text-sm md:text-base font-semibold text-gray-700">Cách Giặt Gấu Bông</strong>
                        </a>
                    </div>
                    <div class="p-2 transform transition duration-300 hover:scale-105">
                        <a class="home-service flex flex-col items-center" href="#" rel="nofollow">
                            <img class="w-16 h-16 md:w-20 md:h-20 object-contain" src="https://teddy.vn/wp-content/uploads/2018/04/Artboard-16-copy-3-1.png" alt="Bảo Hành Gấu Bông" />
                            <strong class="title mt-3 text-center text-sm md:text-base font-semibold text-gray-700">Bảo Hành Gấu Bông</strong>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Product Details -->
            <div class="flex flex-wrap -mx-4 bg-white rounded-xl shadow-lg p-6">
                <!-- Product Image Column -->
                <div class="w-full md:w-1/2 p-4">
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                         class="w-full h-auto rounded-lg shadow-md object-cover transition-transform duration-300 hover:scale-105" />
                </div>

                <!-- Product Details Column -->
                <div class="w-full md:w-1/2 p-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-red-600 mb-4">{{ $product->name }}</h1>

                    <form action="{{ route('cart.add') }}" method="POST" onsubmit="return validateSizeSelection({{ $product->id }})">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="selected-size" name="size" value="{{ optional($product->variants->first())->id }}">
                        <input type="hidden" name="redirect_url" value="{{ url()->current() }}">

                        <!-- Size Variants -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            @foreach($product->variants as $variant)
                                <div class="flex items-center space-x-4">
                                    <input type="radio" id="variant-{{ $variant->id }}" name="variant"
                                           class="hidden peer"
                                           data-size-id="{{ $variant->id }}"
                                           data-price="{{ $variant->price }}"
                                           data-remaining-stock="{{ $variant->stock }}"
                                           onclick="selectSize({{ $product->id }}, this)">
                                    <label for="variant-{{ $variant->id }}"
                                           class="flex-1 cursor-pointer bg-gray-100 text-gray-800 rounded-full py-2 px-4 text-center text-base font-medium transition-all duration-200 hover:bg-gray-200 peer-checked:bg-blue-600 peer-checked:text-white">
                                        {{ $variant->size }}
                                    </label>
                                    <div class="text-right">
                                        <span class="text-lg font-semibold text-gray-700">{{ number_format($variant->price) }} VND</span>
                                        <span class="block text-sm text-gray-500">Còn: {{ $variant->stock }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price -->
                        <p class="text-xl font-bold text-gray-800 mb-4">
                            Giá: <span id="product-price" class="text-red-600 text-2xl">{{ number_format(optional($product->variants->first())->price ?? 0) }} VND</span>
                        </p>

                        <!-- Quantity -->
                        <div class="mb-6">
                            <label for="quantity" class="block text-gray-700 font-medium mb-2">Số lượng:</label>
                            <input type="number" id="quantity" name="quantity" min="1" value="1"
                                   class="w-24 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200" required>
                        </div>

                        <!-- Add to Cart Button -->
                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition-all duration-300 shadow-md hover:shadow-lg">
                            Đặt hàng
                        </button>
                    </form>

                    <!-- Description -->
                    <p class="mt-6 text-gray-600 leading-relaxed bg-gray-50 p-4 rounded-lg">{{ $product->description }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('JS')
    <script>
        function selectSize(productId, element) {
            const selectedSizeId = element.getAttribute('data-size-id');
            const selectedPrice = element.getAttribute('data-price');

            // Cập nhật giá trị hidden input
            document.getElementById('selected-size').value = selectedSizeId;

            // Cập nhật giá hiển thị
            document.getElementById('product-price').innerText = new Intl.NumberFormat().format(selectedPrice) + ' VND';
        }

        function validateSizeSelection(productId) {
            const selectedSizeId = document.getElementById('selected-size').value;
            const quantity = parseInt(document.getElementById('quantity').value);

            if (!selectedSizeId) {
                alert('Vui lòng chọn kích thước trước khi đặt hàng!');
                return false;
            }

            const selectedVariant = document.querySelector(`input[data-size-id="${selectedSizeId}"]`);
            const remainingStock = parseInt(selectedVariant.getAttribute('data-remaining-stock'));

            if (isNaN(quantity) || quantity < 1) {
                alert('Số lượng không hợp lệ! Vui lòng nhập số lượng lớn hơn 0.');
                return false;
            }

            if (quantity > remainingStock) {
                alert(`Số lượng bạn chọn (${quantity}) vượt quá số lượng còn lại (${remainingStock}). Vui lòng chọn lại.`);
                return false;
            }

            return true;
        }
    </script>
@endsection
