<style>
    body {
    font-family: 'VL BoosterNextFYBlack', sans-serif;
    color: #8357ae;
    
}
h1, h2, h3, h4, h5, h6 {
    font-weight: bold;
    color: #8357ae;
}
.header-top {
    background-color: #f8f9fa;
    padding: 10px 0;
}

.logo {
    font-size: 1.8rem;
    font-weight: bold;
    color: #8357ae;
    text-decoration: none;
    font-family: 'Pacifico', cursive;
}

.search-form {
    display: flex;
    width: 100%;
}

.search-input {
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 0;
    outline: none;
}

.search-btn {
    padding: 10px 20px;
    background-color: #8357ae;
    color: white;
    border: none;
    cursor: pointer;
}

.navbar {
    font-size: 20px;
}

/* Dropdown danh mục con */
.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    font-size: 15px;
}

.dropdown:hover > .dropdown-menu {
    display: block;
}

.btn-link {
    color: #8357ae;
    font-size: 14px;
}
.nav-link{
    color: #8357ae;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 14px;
    font-weight: 800;
    text-transform: uppercase;
    display: block;
    padding: 1rem .875rem .5rem;
    color: #8357ae;
    position: relative;
    font-family: 'Baloo 2', cursive;
}
.cart-icon-wrapper {
    position: relative;
    display: inline-block;
    margin-left: 15px;
}

.cart-link {
    text-decoration: none;
    color: #8357ae;
    font-size: 22px;
    position: relative;
}

.cart-count {
    background-color: #ff6b6b;
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 50%;
    position: absolute;
    top: -5px;
    right: -10px;
}
</style>
<header>
    <!-- Phần trên cùng -->
    <div class="header-top">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-md-3">
                    <a href="{{ route('client.home') }}" class="logo">CHillFriend</a>
                </div>

                <!-- Thanh tìm kiếm -->
                <div class="col-md-6">
                    <form action="{{ route('client.search') }}" method="GET" class="search-form">
                        <input type="text" name="query" placeholder="Tìm sản phẩm..." class="search-input" value="{{ request()->input('query') }}">
                        <button type="submit" class="search-btn">Tìm kiếm</button>
                    </form>
                </div>

                <!-- Nút đăng nhập/đăng ký và giỏ hàng -->
                <div class="header-right">
                    @if(auth()->check())
                        <a href="{{ route('logout') }}" class="btn btn-link">Đăng xuất</a>
                        <a href="{{ route('client.orders.index') }}" class="btn btn-link">
                            Đơn hàng
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-link">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="btn btn-link">Đăng ký</a>
                    @endif
                
                    <div class="cart-icon-wrapper">
                        <a href="{{ route('cart.view') }}" class="cart-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Menu danh mục -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @foreach($categories as $category)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $category->id }}"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $category->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $category->id }}">
                                @foreach($category->children as $child)
                                    <li><a class="dropdown-item" href="{{ route('client.category', $child->slug) }}">{{ $child->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.contact') }}">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
