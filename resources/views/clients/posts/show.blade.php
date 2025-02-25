<!-- resources/views/client/posts/show.blade.php -->
@extends('layouts.client')

@section('title', $post->title)

@section('content')
<div class="container">
    <h2 class="my-4">{{ $post->title }}</h2>
    <div class="content">
        {!! nl2br(e($post->content)) !!} <!-- Hiển thị nội dung bài viết, xử lý HTML nếu có -->
    </div>
    <a href="{{ route('client.posts.index') }}" class="btn btn-secondary mt-4">Quay lại danh sách bài viết</a>
</div>
@endsection
