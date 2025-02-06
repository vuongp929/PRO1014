@extends('layouts.client')

@section('content')
    <div class="container">
        <h1>Thanh toán không thành công</h1>
        <p>Rất tiếc, giao dịch của bạn đã thất bại. Vui lòng thử lại hoặc liên hệ với chúng tôi để được hỗ trợ.</p>
        <a href="{{ route('client.home') }}" class="btn btn-primary">Quay lại trang chủ</a>
    </div>
@endsection
