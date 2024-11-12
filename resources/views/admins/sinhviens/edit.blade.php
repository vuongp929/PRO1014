{{-- Để kế thừa lại master layout ta sử dụng extends --}}
@extends('layouts.admin')
{{-- Một file chỉ được kế thừa 1 master layout --}}

@section('title')
    Cập nhật Sinh Viên
@endsection

@section('CSS')
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Quản lý Sinh Viên</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Cập nhật Sinh Viên</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col">

                <div class="h-100">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Cập nhật Sinh Viên</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <form action="{{ route('sinhviens.update', $sinhVien->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="mt-3">
                                                <label for="ma_sinh_vien" class="form-label">Mã Sinh Viên</label>
                                                <input type="text" name="ma_sinh_vien" id="ma_sinh_vien"
                                                    class="form-control" value="{{ $sinhVien->ma_sinh_vien }}" readonly>
                                            </div>

                                            <div class="mt-3">
                                                <label for="ten_sinh_vien" class="form-label">Tên Sinh Viên</label>
                                                <input type="text" name="ten_sinh_vien" id="ten_sinh_vien"
                                                    placeholder="Nhập tên sinh viên"
                                                    class="form-control @error('ten_sinh_vien') is-invalid @enderror"
                                                    value="{{ $sinhVien->ten_sinh_vien }}">
                                                @error('ten_sinh_vien')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mt-3">
                                                <label for="ngay_sinh" class="form-label">Ngày Sinh</label>
                                                <input type="date" name="ngay_sinh" id="ngay_sinh"
                                                    class="form-control @error('ngay_sinh') is-invalid @enderror"
                                                    value="{{ $sinhVien->ngay_sinh }}">
                                                @error('ngay_sinh')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mt-3">
                                                <label for="so_dien_thoai" class="form-label">Số Điện Thoại</label>
                                                <input type="text" name="so_dien_thoai" id="so_dien_thoai"
                                                    placeholder="Nhập số điện thoại"
                                                    class="form-control @error('so_dien_thoai') is-invalid @enderror"
                                                    value="{{ $sinhVien->so_dien_thoai }}">
                                                @error('so_dien_thoai')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mt-3">
                                                <label for="hinh_anh" class="form-label">Hình Ảnh</label>
                                                <input type="file" class="form-control @error('hinh_anh') is-invalid @enderror"
                                                    name="hinh_anh" id="hinh_anh">
                                                @error('hinh_anh')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                <img src="{{ Storage::url($sinhVien->hinh_anh) }}" alt="Hình ảnh"
                                                    width="100px" class="mt-3">
                                            </div>

                                            <div class="mt-3">
                                                <label for="trang_thai" class="form-label">Trạng Thái</label>
                                                <div>
                                                    <input type="radio" name="trang_thai" id="trang_thai_hoat_dong" value="1"
                                                        class="form-check-input @error('trang_thai') is-invalid @enderror"
                                                        {{ $sinhVien->trang_thai == 1 ? 'checked' : '' }}>
                                                    <label for="trang_thai_hoat_dong" class="form-check-label">Hoạt động</label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="trang_thai" id="trang_thai_ngung_hoat_dong" value="0"
                                                        class="form-check-input @error('trang_thai') is-invalid @enderror"
                                                        {{ $sinhVien->trang_thai == 0 ? 'checked' : '' }}>
                                                    <label for="trang_thai_ngung_hoat_dong" class="form-check-label">Ngừng hoạt động</label>
                                                </div>
                                                @error('trang_thai')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mt-3 text-center">
                                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>
    </div>
@endsection

@section('JS')
    <script src="https:////cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('mo_ta');
    </script>
@endsection
