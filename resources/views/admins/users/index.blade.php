@extends('layouts.app')

@section('content')
    <h1>Danh sách người dùng</h1>
    <table>
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
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('users.show', $user) }}">Xem chi tiết</a>

                        <!-- Form cập nhật role người dùng -->
                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="role" onchange="this.form.submit()">
                                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
