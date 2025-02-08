<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;


class ClientController extends Controller
{
    public function index(Request $request)
{
    $cart = session()->get('cart', []);
    session()->put('cart', $cart);

    $user = Auth::user();

    // Lấy danh mục cha và danh mục con
    $categories = Category::with('children')->whereNull('parent_id')->get();

    // Hiển thị danh sách sản phẩm hoặc logic khác
    $products = Product::latest()->take(10)->get();

    // Lấy sản phẩm với thông tin về product variants
    $products = Product::with('variants')->get();

    // Kiểm tra nếu có size được chọn từ người dùng
    $selectedVariant = null;
    if ($request->has('size')) {
        // Tìm variant tương ứng với size được chọn
        $selectedVariant = ProductVariant::find($request->size);
    }

    // Chuyển thông tin sản phẩm về view
    return view('clients.home', compact('user', 'cart', 'products', 'selectedVariant'));
}


}
