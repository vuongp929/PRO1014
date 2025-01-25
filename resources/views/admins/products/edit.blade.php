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
                            <li class="breadcrumb-item active">Cập nhật sản phẩm</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Cập nhật sản phẩm</h4>
                        </div>

                        <div class="card-body">
                            <div class="live-preview">
                                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row gy-4">
                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <label for="code" class="form-label">Mã sản phẩm</label>
                                                <input type="text" class="form-control" name="code" id="code" 
                                                    value="{{ $product->code }}" readonly>
                                            </div>

                                            <div class="mt-3">
                                                <label for="name" class="form-label">Tên sản phẩm</label>
                                                <input type="text" name="name" id="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name', $product->name) }}">
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
                                                                {{ in_array($category->id, old('category_ids', $product->categories->pluck('id')->toArray())) ? 'checked' : '' }}
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
                                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                                    name="image" id="image">
                                                @error('image')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                                @if ($product->image)
                                                    <img src="{{ Storage::url($product->image) }}" alt="Hình ảnh sản phẩm" width="100px">
                                                @endif
                                            </div>

                                            <div class="mt-3">
                                                <label for="description" class="form-label">Mô tả</label>
                                                <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $product->description) }}</textarea>
                                            </div>

                                            <div class="mt-3">
                                                <label for="variants" class="form-label">Biến thể sản phẩm</label>
                                                <div id="categories">
                                                    @foreach ($product->categories as $index => $category)
                                                        <div class="category-row mt-2 row g-2">
                                                            <div class="col">
                                                                <input type="text" class="form-control" name="categories[{{ $index }}][name]" value="{{ $category->name }}" />
                                                            </div>
                                                            <div class="col-auto">
                                                                <button type="button" class="btn btn-danger remove-category">Xóa</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" id="add-category" class="btn btn-primary mt-3">Thêm danh mục</button>
                                                
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
            </div> <!-- end .h-100-->
        </div> <!-- end col -->
    </div>
@endsection

@section('JS')
<script src="https://cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    let categoryIndex = {{ isset($product->categories) ? $product->categories->count() : 0 }}; // Số lượng danh mục hiện tại

    // Thêm danh mục
    document.getElementById('add-category').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('categories').insertAdjacentHTML('beforeend', `
            <div class="category-row mt-2 row g-2">
                <div class="col">
                    <input type="text" class="form-control" name="categories[${categoryIndex}][name]" placeholder="Tên danh mục" />
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-category">Xóa</button>
                </div>
            </div>
        `);
        categoryIndex++;
    });

    // Xóa danh mục
    document.getElementById('categories').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-category')) {
            e.target.closest('.category-row').remove();
        }
    });
});

</script>
@endsection
