<!-- resources/views/client/posts/index.blade.php -->
@extends('layouts.client')

@section('title', 'Danh Sách Bài Viết')

@section('content')
<div class="container">
    <h2 class="my-4">Danh Sách Bài Viết</h2>
    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="{{ $post->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->excerpt }}</p>
                    <a href="{{ route('client.posts.show', $post->id) }}" class="btn btn-primary">Xem Chi Tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
