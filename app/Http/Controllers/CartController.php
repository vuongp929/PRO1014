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
    $productId = $request->input('product_id');
    $sizeId = $request->input('size');
    $quantity = $request->input('quantity', 1); // Default to 1 if not provided

    // Logic to add the product to the cart
    $cart = session()->get('cart', []);

    // Check if the product is already in the cart
    if (isset($cart[$sizeId])) {
        // Update the quantity based on the input
        $cart[$sizeId]['quantity'] += $quantity; // Increment by the specified quantity
    } else {
        // Assuming you have a Product model to get product details
        $product = Product::find($productId);
        $productImage = $product->image ?? 'default-image.jpg'; // Use default image if not available

        $cart[$sizeId] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'image' => $productImage,
            'price' => $product->variants->find($sizeId)->price, // Get the price from the variant
            'quantity' => $quantity, // Set the quantity from the input
            'size' => $sizeId,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Product added to cart successfully!');
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
