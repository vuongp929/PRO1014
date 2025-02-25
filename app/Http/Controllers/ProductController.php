<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->orderByDesc('id')->paginate(5);
        return view('admins.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admins.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $code = $request->input('code', strtoupper(Str::random(4)));
            $imagePath = $request->file('image') ? Storage::put('uploads/products', $request->file('image')) : null;

            $product = Product::create([
                'code' => $code,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'image' => $imagePath,
            ]);

            if ($request->has('category_ids')) {
                $product->categories()->sync($request->input('category_ids'));
            }

            if ($request->has('variants')) {
                foreach ($request->input('variants') as $variant) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $variant['size'],
                        'price' => $variant['price'],
                        'stock' => $variant['stock'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors('Lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::with('categories', 'variants')->findOrFail($id);
        $categories = Category::all();
        return view('admins.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            $imagePath = $product->image;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads/products', 'public');
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
            }

            $product->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'image' => $imagePath,
            ]);

            if ($request->has('category_ids')) {
                $product->categories()->sync($request->input('category_ids'));
            }

            $product->variants()->delete();
            if ($request->has('variants')) {
                foreach ($request->input('variants') as $variant) {
                    $product->variants()->create([
                        'size' => $variant['size'],
                        'price' => $variant['price'],
                        'stock' => $variant['stock'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors('Lỗi xảy ra khi cập nhật sản phẩm: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->variants()->delete();
            $product->delete();

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors('Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::with('categories')
            ->when($query, function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%")
                             ->orWhere('description', 'like', "%$query%")
                             ->orderBy('name');
            })
            ->paginate(10);

        return view('clients.search_results', compact('products'));
    }
    public function show($id)
    {
        // Lấy sản phẩm cùng với danh mục và các biến thể
        $product = Product::with(['categories', 'variants'])->findOrFail($id);

        // Kiểm tra sản phẩm có tồn tại không
        if (!$product) {
            return redirect()->route('client.home')->with('error', 'Sản phẩm không tồn tại.');
        }

        // Chọn biến thể đầu tiên (nếu có)
        $variant = $product->variants->first();

        return view('clients.product_detail', compact('product', 'variant'));
    }

}
