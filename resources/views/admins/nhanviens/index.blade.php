{{-- Để kế thừa lại master layout ta sử dụng extends --}}
@extends('layouts.admin')
{{-- Một file chỉ được kế thừa 1 master layout --}}

@section('title')
    Quản lý sản phẩm
@endsection

@section('CSS')
@endsection

{{-- @section: dùng để chị định phần nội dụng được hiển thị --}}
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Quản lý nhân viên</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Danh sách nhân viên</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Danh sách nhân viên</h4>
                            <a href="{{ route('nhanviens.create') }}" class="btn btn-soft-success material-shadow-none">
                                <i class="ri-add-circle-line align-middle me-1"></i>
                                Thêm nhân viên
                            </a>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive">
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong> {{ session('success') }} </strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> {{ session('error') }} </strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif


                                    <table class="table table-striped table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Mã nhân viên</th>
                                                <th scope="col">Hình ảnh</th>
                                                <th scope="col">Tên nhân viên</th>
                                                <th scope="col">Ngày vào làm</th>
                                                <th scope="col">Lương</th>
                                                <th scope="col">Trạng thái</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listNhanVien as $index => $NhanVien)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $NhanVien->ma_nhan_vien }}</td>
                                                    <td>
                                                        <img src="{{ Storage::url($NhanVien->hinh_anh) }}" 
                                                            class="img-thumbnail" alt="Hình ảnh" width="100px">
                                                    </td>
                                                    <td>{{ $NhanVien->ten_nhan_vien }}</td>
                                                    <td>{{ $NhanVien->ngay_vao_lam }}</td>
                                                    <td>{{ $NhanVien->luong }}</td>
                                                    <td>
                                                        {{-- {{ $NhanVien->trang_thai }} --}}
                                                        @if ($NhanVien->trang_thai == 1)
                                                            <span
                                                                class="badge bg-success-subtle text-success text-uppercase">Active
                                                            </span>
                                                        @else
                                                            <span
                                                                class="badge bg-danger-subtle text-danger text-uppercase">Unactive
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('nhanviens.show', $NhanVien->id) }}" class="btn btn-sm btn-primary">Xem</a>
                                                        <a href="{{ route('nhanviens.edit', $NhanVien->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                                        <form action="{{ route('nhanviens.destroy', $NhanVien->id) }}" method="POST"
                                                            onsubmit="return confirm('Xác nhận xóa dữ liệu nhân viên này??')" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                                        </form>                                                       
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        {{ $listNhanVien->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>

                        </div><!-- end card-body -->
                    </div><!-- end card -->

                </div> <!-- end .h-100-->

            </div> <!-- end col -->
        </div>

    </div>
@endsection

@section('JS')
@endsection