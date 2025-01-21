<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm.
     */
    public function index()
    {
        // Lấy danh sách sản phẩm, sắp xếp theo ID giảm dần, phân trang
        $products = Product::with('categories')->orderByDesc('id')->paginate(5);
        return view('admins.products.index', compact('products'));
    }

    /**
     * Hiển thị form tạo sản phẩm mới.
     */
    public function create()
    {
        $categories = Category::all();  // Lấy tất cả danh mục
        return view('admins.products.create', compact('categories'));  // Truyền danh mục vào view
    }

    /**
     * Lưu thông tin sản phẩm mới vào cơ sở dữ liệu.
     */
    public function store(StoreProductRequest $request)
{
    DB::beginTransaction();

    try {
        $code = $request->input('code', strtoupper(Str::random(4)));
        // Xử lý ảnh
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = Storage::put('uploads/products', $request->file('image'));
        }

        // Thêm sản phẩm mới
        $product = Product::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $imagePath,
        ]);

        // Lưu danh mục sản phẩm
        if ($request->has('category_ids')) {
            $product->categories()->sync($request->input('category_ids'));
        }

        // Lưu các biến thể
        if ($request->has('variants')) {
            foreach ($request->input('variants') as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $variant['size'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'] ?? 0,  // Sử dụng stock từ form, nếu không có, gán giá trị mặc định 0
                ]);
            }
        }
        

        DB::commit();
        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    } catch (\Exception $e) {
        DB::rollBack();
        // In chi tiết lỗi để dễ dàng debug
        dd($e->getMessage(), $e->getTraceAsString());

        return redirect()->route('products.index')->with('error', 'Có lỗi xảy ra khi thêm sản phẩm.');
    }
}



    /**
     * Hiển thị form chỉnh sửa sản phẩm.
     */
    public function edit($id)
    {
        $product = Product::with('variants')->find($id);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại.');
        }

        return view('admins.products.edit', compact('product'));
    }

    /**
     * Cập nhật thông tin sản phẩm.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $product = Product::find($id);

            if (!$product) {
                return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại.');
            }

            // Xử lý ảnh
            $imagePath = $product->image;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads/products', 'public');
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
            }

            // Cập nhật sản phẩm
            $product->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'description' => $request->input('description'),
                'stock' => $request->input('stock'),
                'image' => $imagePath,
            ]);

            // Cập nhật danh mục
            if ($request->has('category_ids')) {
                $product->categories()->sync($request->input('category_ids'));
            }

            // Cập nhật biến thể
            $product->variants()->delete(); // Xóa tất cả biến thể cũ
            if ($request->has('variants')) {
                foreach ($request->input('variants') as $variant) {
                    $product->variants()->create([
                        'size' => $variant['size'],
                        'color' => $variant['color'],
                        'price' => $variant['price'],
                        'stock' => $variant['stock'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm.');
        }
    }


    /**
     * Xóa sản phẩm.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $product = Product::find($id);

            if (!$product) {
                return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại.');
            }

            // Xóa ảnh
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Xóa sản phẩm và các biến thể
            $product->variants()->delete();
            $product->delete();

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')->with('error', 'Có lỗi xảy ra khi xóa sản phẩm.');
        }
    }
}
