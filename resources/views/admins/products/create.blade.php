@extends('layouts.admin')

@section('title')
    Quản lý sản phẩm
@endsection

@section('CSS')
<style>
    .category-item {
        display: inline-block;
        margin: 10px;
        padding: 5px;
        cursor: pointer;
    }

    .category-item input[type="checkbox"] {
        display: none; /* Ẩn checkbox */
    }
    .category-item .category-label {
        padding: 8px 15px;
        border-radius: 5px;
        background-color: #f0f0f0;
        transition: background-color 0.3s;
    }

    .category-item input[type="checkbox"]:checked + .category-label {
        background-color: #007bff;
        color: #fff;
    }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Quản lý sản phẩm</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Thêm mới sản phẩm</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Thêm mới sản phẩm</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row gy-4">
                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <label for="code" class="form-label">Mã sản phẩm</label>
                                                <input type="text"
                                                    class="form-control @error('code') is-invalid @enderror"
                                                    name="code" id="code"
                                                    value="{{ strtoupper(Str::random(4)) }}" readonly>
                                                @error('code')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>



                                            <div class="mt-3">
                                                <label for="name" class="form-label">Tên sản phẩm</label>
                                                <input type="text" name="name" id="name"
                                                    placeholder="Nhập tên sản phẩm"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mt-3">
                                                <label for="category_ids" class="form-label">Danh mục</label>
                                                <div class="category-selection">
                                                    @foreach($categories as $category)
                                                        <div class="category-item">
                                                            <input type="checkbox"
                                                                id="category_{{ $category->id }}"
                                                                name="category_ids[]"
                                                                value="{{ $category->id }}"
                                                                class="category-checkbox"
                                                                {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}
                                                            />
                                                            <label for="category_{{ $category->id }}" class="category-label">{{ $category->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>

                                            <div class="col-md-8">
                                                <div class="mt-3">
                                                    <label for="image" class="form-label">Hình ảnh</label>
                                                    <input type="file"
                                                        class="form-control @error('image') is-invalid @enderror"
                                                        name="image" id="image">
                                                    @error('image')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div class="mt-3">
                                                    <label for="description" class="form-label">Mô tả</label>
                                                    <textarea class="form-control" name="description" id="description" rows="4">{{ old('description') }}</textarea>
                                                </div>


                                                <div class="mt-3">
                                                    <label for="variants" class="form-label">Biến thể sản phẩm</label>
                                                    <div id="variants">
                                                        <div class="variant-row row g-2">
                                                            <div class="col">
                                                                <input type="text" class="form-control" name="variants[${variantIndex}][size]" placeholder="Kích thước" />
                                                            </div>
                                                            <div class="col">
                                                                <input type="number" class="form-control" name="variants[${variantIndex}][price]" placeholder="Giá" />
                                                            </div>
                                                            <div class="col">
                                                                <input type="number" class="form-control" name="variants[${variantIndex}][stock]" placeholder="Số lượng" />
                                                            </div>
                                                        </div>
                                                        <button type="button" id="add-variant">Thêm biến thể</button>
                                                    </div>
                                                </div>

                                            <div class="mt-3 text-center">
                                                <button class="btn btn-primary" type="submit">Thêm mới</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div> <!-- end .h-100-->
        </div> <!-- end col -->
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection

@section('JS')
    <script src="https://cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    let variantIndex = 1;

    document.getElementById('add-variant').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('variants').insertAdjacentHTML('beforeend', `
            <div class="variant-row mt-2 row g-2">
                <div class="col">
                    <input type="text" class="form-control" name="variants[${variantIndex}][size]" placeholder="Kích thước" />
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="variants[${variantIndex}][price]" placeholder="Giá" />
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="variants[${variantIndex}][stock]" placeholder="Số lượng" />
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-variant">Xóa</button>
                </div>
            </div>
        `);
        variantIndex++;
    });

    document.getElementById('variants').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-variant')) {
            e.target.closest('.variant-row').remove();
        }
    });
});


    </script>
@endsection
