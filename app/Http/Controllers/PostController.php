<?php

namespace App\Http\Controllers;

use App\Models\Post; // Giả sử bạn có model Post
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Hiển thị danh sách bài viết
    public function index()
    {
        $posts = Post::all(); // Lấy tất cả bài viết
        return view('clients.posts.index', compact('posts'));
    }

    // Hiển thị chi tiết bài viết
    public function show($id)
    {
        $post = Post::findOrFail($id); // Tìm bài viết theo id
        return view('clients.posts.show', compact('post')); // Trả về view chi tiết bài viết
    }
}
