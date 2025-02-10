@extends('layouts.admin')

@section('title')
    Quản lý Phản hồi
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Danh sách phản hồi</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            Hiển thị {{ $feedbacks->firstItem() }} đến {{ $feedbacks->lastItem() }} 
                            trong tổng số {{ $feedbacks->total() }} phản hồi
                        </div>
                        <div>
                            {{ $feedbacks->links() }}
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Nội dung</th>
                                    <th>Ngày gửi</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedbacks as $feedback)
                                    <tr>
                                        <td>{{ $feedback->id }}</td>
                                        <td>{{ $feedback->name }}</td>
                                        <td>{{ $feedback->email }}</td>
                                        <td>{{ $feedback->phone }}</td>
                                        <td>
                                            <div class="text-wrap" style="max-width: 250px;">
                                                {{ Str::limit($feedback->message, 100) }}
                                            </div>
                                        </td>
                                        <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($feedback->status == 'replied')
                                                <span class="badge bg-success">Đã trả lời</span>
                                            @else
                                                <span class="badge bg-warning">Chờ xử lý</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('feedback.show', $feedback->id) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="ri-eye-line"></i>
                                                </a>

                                                <form action="{{ route('feedback.destroy', $feedback->id) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc muốn xóa phản hồi này?')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- Modal Chi tiết -->
                                            <div class="modal fade" id="viewModal{{ $feedback->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Chi tiết phản hồi</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <strong>Tên người gửi:</strong> {{ $feedback->name }}
                                                            </div>
                                                            <div class="mb-3">
                                                                <strong>Email:</strong> {{ $feedback->email }}
                                                            </div>
                                                            <div class="mb-3">
                                                                <strong>Số điện thoại:</strong> {{ $feedback->phone }}
                                                            </div>
                                                            <div class="mb-3">
                                                                <strong>Ngày gửi:</strong> {{ $feedback->created_at->format('d/m/Y H:i') }}
                                                            </div>
                                                            <div class="mb-3">
                                                                <strong>Nội dung:</strong>
                                                                <p class="mt-2">{{ $feedback->message }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có phản hồi nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mb-3 d-flex justify-content-end ">
                        <form action="{{ route('feedback.index') }}" method="GET" class="d-flex align-items-center gap-2">
                            <label for="per_page">Hiển thị:</label>
                            <select name="per_page" id="per_page" class="form-select" style="width: auto" onchange="this.form.submit()">
                                @foreach([10, 25, 50, 100] as $value)
                                    <option value="{{ $value }}" {{ request('per_page', 10) == $value ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            <span>mục mỗi trang</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('CSS')
<style>
    .pagination {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
        padding: 0.5rem 1rem;
        border: 1px solid #dee2e6;
        color: #8357ae;
        background-color: #fff;
        border-radius: 0.25rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #8357ae;
        border-color: #8357ae;
        color: #fff;
    }
    
    .pagination .page-link:hover {
        background-color: #f8f9fa;
        border-color: #8357ae;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
</style>
@endsection