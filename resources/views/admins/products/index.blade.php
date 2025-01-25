@extends('layouts.admin')

@section('title')
    Quản lý sản phẩm
@endsection

@section('CSS')
    {{-- Thêm CSS riêng nếu cần --}}
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Quản lý sản phẩm</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li> --}}
                            <li class="breadcrumb-item active">Sản phẩm</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- End page title -->

        <!-- Content -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Danh sách sản phẩm</h4>
                        <a href="{{ route('products.create') }}" class="btn btn-soft-success">
                            <i class="ri-add-circle-line align-middle me-1"></i> Thêm sản phẩm
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {{-- Hiển thị thông báo --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session('success') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ session('error') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            {{-- Bảng hiển thị danh sách --}}
                            <table class="table table-striped table-nowrap align-middle">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã sản phẩm</th>
                                        <th>Hình ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Danh Mục</th>
                                        <th>Size và Giá</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $index => $product)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $product->code }}</td>
                                            <td>
                                                <img src="{{ Storage::url($product->image) }}" class="img-thumbnail" width="100px" alt="Hình ảnh">
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                @foreach ($product->categories as $category)
                                                    <span class="badge bg-primary">{{ $category->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($product->variants as $variant)
                                                    <div>
                                                        <strong>Size:</strong> {{ $variant->size }} <br>
                                                        <strong>Giá:</strong> {{ number_format($variant->price, 0, '', '.') }} VNĐ
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary">Xem</a>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Phân trang --}}
                            <div class="mt-3">
                                {{ $products->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('JS')
    {{-- Thêm JS riêng nếu cần --}}
@endsection
