@extends('layouts.admin')

@section('title')
    Chi tiết sinh viên
@endsection

@section('CSS')
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Chi tiết sinh viên</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Chi tiết sinh viên</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <!-- Hình ảnh sinh viên -->
            <div class="col-lg-4 col-md-5">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ Storage::url($sinhVien->hinh_anh) }}" class="img-fluid img-thumbnail mb-3" 
                            alt="Ảnh sinh viên" style="max-height: 250px; object-fit: cover;">
                        <h5 class="card-title">{{ $sinhVien->ten }}</h5>
                        <p class="text-muted mb-0">Mã sinh viên: <strong>{{ $sinhVien->ma_sv }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Thông tin sinh viên -->
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-primary mb-3">Thông tin chi tiết</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Email:
                                <span>{{ $sinhVien->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Năm học:
                                <span>{{ $sinhVien->nam_hoc }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Giới tính:
                                <span>{{ $sinhVien->gioi_tinh == 1 ? 'Nam' : 'Nữ' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Trạng thái:
                                @if ($sinhVien->trang_thai == 1)
                                    <span class="badge bg-success text-uppercase">Active</span>
                                @else
                                    <span class="badge bg-danger text-uppercase">Inactive</span>
                                @endif
                            </li>
                        </ul>
                        <div class="mt-3">
                            <h6 class="text-secondary">Mô tả:</h6>
                            <p class="text-muted">{!! $sinhVien->mo_ta !!}</p>
                        </div>
                        <a href="{{ route('sinhviens.index') }}" class="btn btn-soft-primary">
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
