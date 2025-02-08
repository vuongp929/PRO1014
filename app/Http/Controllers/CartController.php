<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Product;
use App\Models\ProductVariant;

class CartController extends Controller
{
    public function viewCart()
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!auth()->check()) {
            return redirect()->route('client.home'); // Chuyển hướng nếu người dùng chưa đăng nhập
        }

        $cart = session('cart', []);
        // dd(session()->all());
        // Kiểm tra nếu giỏ hàng trống và không phải trang giỏ hàng
        if (empty($cart) && !request()->is('clients/cart')) {
            // Chuyển hướng về trang chủ nếu giỏ hàng trống
            return redirect()->route('client.home')->with('info', 'Giỏ hàng của bạn đang trống!');
        }

        // Xóa các sản phẩm không có trường 'image'
        foreach ($cart as $productId => $item) {
            if (!isset($item['image'])) {
                unset($cart[$productId]);
            }
        }

        $total = array_sum(array_map(fn ($item) => $item['price'] * $item['quantity'], $cart));

        return view('clients.cart.index', compact('cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        $variant = ProductVariant::find($request->size);
    
        if (!$product || !$variant) {
            return response()->json(['error' => 'Sản phẩm hoặc kích thước không hợp lệ!'], 400);
        }
    
        $cart = session()->get('cart', []);
    
        // Kiểm tra nếu sản phẩm đã có trong giỏ, nếu có thì cập nhật số lượng
        if (isset($cart[$variant->id])) {
            $cart[$variant->id]['quantity']++;
        } else {
            $productImage = $product->image ?? 'default-image.jpg'; // Dùng ảnh mặc định nếu không có
    
            $cart[$variant->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => $productImage,
                'price' => $variant->price,
                'quantity' => 1,
                'size' => $variant->size,
            ];
        }
    
        session()->put('cart', $cart);
    
        // return response()->json([
        //     'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
        //     'cartCount' => count($cart)
        // ]);
        $redirectUrl = $request->input('redirect_url', route('client.home'));
        return redirect($redirectUrl)->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
            session()->save();
        }

        return redirect()->route('cart.view')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->products as $productId => $quantity) {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
        }

        session()->put('cart', $cart);
        session()->save();

        return redirect()->route('cart.view')->with('success', 'Giỏ hàng đã được cập nhật!');
    }
}
