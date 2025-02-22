@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Thêm danh mục</h2>
        <form action="{{ route('category.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tên danh mục</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Danh mục cha (nếu có)</label>
                <select name="parent_id" class="form-control">
                    <option value="">-- Không có (Danh mục gốc) --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
            <a href="{{ route('category.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
