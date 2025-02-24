@extends('layouts.client')

@section('title', 'Liên hệ')

@section('CSS')
<style>
.contact-section {
    padding: 60px 0;
    background-color: #f8f9fa;
}

.contact-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    background: #fff;
    overflow: hidden;
}

.contact-info {
    padding: 30px;
    background: #8357ae;
    color: #fff;
}

.contact-info h3 {
    color: #fff;
    font-size: 24px;
    margin-bottom: 25px;
}

.contact-method {
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.contact-method i {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 18px;
}

.contact-method a {
    color: #fff;
    text-decoration: none;
    transition: all 0.3s;
}

.contact-method a:hover {
    color: #f0f0f0;
}

.contact-form {
    padding: 30px;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #e0e0e0;
    padding: 12px 15px;
    margin-bottom: 20px;
}

.form-control:focus {
    border-color: #8357ae;
    box-shadow: 0 0 0 0.2rem rgba(131, 87, 174, 0.25);
}

.btn-submit {
    background-color: #8357ae;
    border: none;
    padding: 12px 30px;
    border-radius: 10px;
    color: #fff;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-submit:hover {
    background-color: #6f4593;
    transform: translateY(-2px);
}

.social-links {
    margin-top: 30px;
}

.social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    margin-right: 10px;
    transition: all 0.3s;
}

.social-links a:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
}
</style>
@endsection

@section('content')
<div class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="contact-card">
                    <div class="row g-0">
                        <!-- Thông tin liên hệ -->
                        <div class="col-md-4">
                            <div class="contact-info">
                                <h3>Liên hệ với chúng tôi</h3>
                                
                                <div class="contact-method">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <p>388 Xã Đàn, Đống Đa, Hà Nội</p>
                                    </div>
                                </div>

                                <div class="contact-method">
                                    <i class="fas fa-phone"></i>
                                    <div>
                                        <a href="tel:0965555346">096.5555.346</a><br>
                                        <a href="tel:0962222346">096.2222.346</a>
                                    </div>
                                </div>

                                <div class="contact-method">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <a href="mailto:contact@chillfriend.com">contact@chillfriend.com</a>
                                    </div>
                                </div>

                                <div class="social-links">
                                    <a href="https://zalo.me/0965555346" target="_blank" title="Zalo">
                                        <i class="fas fa-comment"></i>
                                    </a>
                                    <a href="https://m.me/chillfriend" target="_blank" title="Messenger">
                                        <i class="fab fa-facebook-messenger"></i>
                                    </a>
                                    <a href="https://facebook.com/chillfriend" target="_blank" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Form liên hệ -->
                        <div class="col-md-8">
                            <div class="contact-form">
                                <h3 class="mb-4" style="color: #8357ae;">Gửi tin nhắn cho chúng tôi</h3>
                                
                                <form action="{{ route('feedback.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name" placeholder="Họ và tên" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="tel" class="form-control" name="phone" placeholder="Số điện thoại">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea class="form-control" name="message" rows="5" placeholder="Nội dung tin nhắn" required></textarea>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-submit">
                                            <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection