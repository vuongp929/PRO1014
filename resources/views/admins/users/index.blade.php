@extends('layouts.admin')

@section('title')
    Quản lý người dùng
@endsection

@section('CSS')
    {{-- Thêm CSS riêng nếu cần --}}
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="my-4">Danh sách người dùng</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Danh sách người dùng</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td class="d-flex justify-content-start">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm mr-2">Xem chi tiết</a>

                                    <!-- Form cập nhật role người dùng -->
                                    <form action="{{ route('users.update', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('JS')
    {{-- Thêm JS riêng nếu cần --}}
@endsection
