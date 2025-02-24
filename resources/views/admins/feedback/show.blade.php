@extends('layouts.admin')

@section('title')
    Chi tiết phản hồi
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Chi tiết phản hồi #{{ $feedback->id }}</h4>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>Tên:</strong></label>
                        <p>{{ $feedback->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>Email:</strong></label>
                        <p>{{ $feedback->email }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>Số điện thoại:</strong></label>
                        <p>{{ $feedback->phone ?? 'Không có' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><strong>Trạng thái:</strong></label>
                        <form action="{{ route('feedback.update-status', $feedback) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="pending" {{ $feedback->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="replied" {{ $feedback->status === 'replied' ? 'selected' : '' }}>Đã trả lời</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Nội dung phản hồi:</strong></label>
                <p>{{ $feedback->message }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Thời gian gửi:</strong></label>
                <p>{{ $feedback->created_at->format('d/m/Y H:i:s') }}</p>
            </div>

            <div class="mt-4">
                <a href="/feedback" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>

</div>
@endsection