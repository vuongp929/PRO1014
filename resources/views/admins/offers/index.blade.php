@extends('layouts.admin')

@section('content')
<h2>Danh sách mã khuyến mãi</h2>
<a href="{{ route('offers.create') }}" class="btn btn-success">Thêm mã</a>
<table class="table">
    <thead>
        <tr>
            <th>Mã</th>
            <th>Giảm giá (%)</th>
            <th>Hạn sử dụng</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($offers as $offer)
        <tr>
            <td>{{ $offer->code }}</td>
            <td>{{ $offer->discount }}%</td>
            <td>{{ $offer->expires_at ? $offer->expires_at->format('d/m/Y H:i') : 'Không giới hạn' }}</td>
            <td>
                <form action="{{ route('offers.update', $offer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="is_active" value="{{ $offer->is_active ? 0 : 1 }}">
                    <button type="submit" class="btn btn-{{ $offer->is_active ? 'success' : 'danger' }}">
                        {{ $offer->is_active ? 'ON' : 'OFF' }}
                    </button>
                </form>
            </td>
            <td>
                <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-warning">Sửa</a>
                <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
