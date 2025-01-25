@extends('layouts.app')

@section('content')
    <h1>Chỉnh sửa thông tin người dùng</h1>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" class="form-control">
            <small class="text-muted">Để trống nếu không thay đổi mật khẩu</small>
        </div>

        <div class="form-group">
            <label for="role">Vai trò</label>
            <select id="role" name="role" class="form-control">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
@endsection
