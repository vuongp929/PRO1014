@extends('layouts.admin')


@section('content')
<h2>Thêm Mã Khuyến Mãi</h2>
<form action="{{ route('offers.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="code" class="form-label">Mã Giảm Giá</label>
        <input type="text" name="code" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="discount" class="form-label">Giảm Giá (%)</label>
        <input type="number" name="discount" class="form-control" min="1" max="100" required>
    </div>
    <div class="mb-3">
        <label for="expires_at" class="form-label">Ngày Hết Hạn</label>
        <input type="datetime-local" name="expires_at" class="form-control">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="is_active" class="form-check-input" checked>
        <label class="form-check-label">Hoạt động</label>
    </div>
    <button type="submit" class="btn btn-primary">Tạo Mã</button>
</form>
@endsection


