{{-- Để kế thừa lại master layout ta sử dụng extends --}}
@extends('layouts.admin')
{{-- Một file chỉ được kế thừa 1 master layout --}}

@section('title')
    Buổi học 5
@endsection

@section('CSS')
    {{-- Chứa tất cả các link CSS mà trang con muốn sử dụng --}}
    {{-- Nhúng trực tiếp --}}
    {{-- <style>
        .title-buoi5 {
            color: red;
        }
    </style> --}}

    {{-- Link đường dẫn tới 1 file nằm trong thư mục public --}}
    <link rel="stylesheet" href="{{ asset('assets/admins/css/buoi5.css') }}">
@endsection

{{-- @section: dùng để chị định phần nội dụng được hiển thị --}}
@section('content')
    <h1 class="title-buoi5">Thầy Định đẹp trai</h1>
    <button class="btn btn-success" onclick="clickMe()">Click</button>
@endsection

@section('JS')
    {{-- Chứa tất cả các script mà trang con muốn sử dụng --}}
    <script>
        function clickMe() {
            alert("Xin chào mọi người");
        }
    </script>
@endsection

