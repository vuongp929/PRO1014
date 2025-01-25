@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Danh sách đơn hàng</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">Xem</a>
                        <form action="{{ route('orders.update', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy</option>
                            </select>
                        </form>                        
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Không có đơn hàng nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
