@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Chỉnh sửa danh mục</h2>
        <form action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tên danh mục</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ $category->slug }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('category.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
