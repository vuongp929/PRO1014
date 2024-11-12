@extends('layouts.admin')

@section('title')
    Chi tiết sản phẩm
@endsection

@section('CSS')
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Chi tiết sản phẩm</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <!-- Hình ảnh sản phẩm -->
            <div class="col-lg-4 col-md-5">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ Storage::url($sanPham->hinh_anh) }}" class="img-fluid img-thumbnail mb-3" 
                            alt="Hình ảnh sản phẩm" style="max-height: 250px; object-fit: cover;">
                        <h5 class="card-title">{{ $sanPham->ten_san_pham }}</h5>
                        <p class="text-muted mb-0">Mã sản phẩm: <strong>{{ $sanPham->ma_san_pham }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-primary mb-3">Thông tin chi tiết</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Giá sản phẩm:
                                <span class="badge bg-success fs-6">{{ number_format($sanPham->gia, 0, '', '.') }} VNĐ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Giá khuyến mãi:
                                <span class="badge bg-warning fs-6">{{ number_format($sanPham->gia_khuyen_mai, 0, '', '.') }} VNĐ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Số lượng:
                                <span>{{ $sanPham->so_luong }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Ngày nhập:
                                <span>{{ $sanPham->ngay_nhap }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Trạng thái:
                                @if ($sanPham->trang_thai == 1)
                                    <span class="badge bg-success text-uppercase">Active</span>
                                @else
                                    <span class="badge bg-danger text-uppercase">Unactive</span>
                                @endif
                            </li>
                        </ul>
                        <div class="mt-3">
                            <h6 class="text-secondary">Mô tả:</h6>
                            <p class="text-muted">{!! $sanPham->mo_ta !!}</p>
                        </div>
                        <a href="{{ route('sanphams.index') }}" class="btn btn-soft-primary">
                            <i class="ri-arrow-left-line"></i> Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('JS')
@endsection
