@extends('layouts.admin')

@section('title', 'Chi tiết người dùng')

@section('content')
    <div class="container py-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chi tiết người dùng: {{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <strong>Tên:</strong> {{ $user->name }}
                </div>
                <div class="mb-4">
                    <strong>Email:</strong> {{ $user->email }}
                </div>
                <div class="mb-4">
                    <strong>Vai trò:</strong> {{ $user->role }}
                </div>

                <div class="mb-4">
                    <strong>Ngày tạo:</strong> {{ $user->created_at->format('d/m/Y H:i') }}
                </div>

                <div class="mb-4">
                    <strong>Cập nhật lần cuối:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
                </div>

                <div class="mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Sửa</a>

                    <!-- Form xóa người dùng -->
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('JS')
    {{-- Thêm JS riêng nếu cần --}}
@endsection