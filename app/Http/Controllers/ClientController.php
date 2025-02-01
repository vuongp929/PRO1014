<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Product;

class ClientController extends Controller
{
    public function home()
    {
        // Lấy danh sách sản phẩm mới nhất hoặc nổi bật
        $products = Product::orderByDesc('id')->take(10)->get();

        // Trả về view trang chủ
        return view('clients.home', compact('products'));
    }
}
