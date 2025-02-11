<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $categories = Category::all(); // Lấy tất cả danh mục

    return view('admins.category.index', compact('categories'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.category.create');
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'slug' => 'required|string|max:255|unique:categories,slug',
        'parent_id' => 'nullable|exists:categories,id',
    ]);

    Category::create([
        'name' => $request->name,
        'slug' => $request->slug,
        'parent_id' => $request->parent_id, // Lưu danh mục cha nếu có
    ]);

    return redirect()->route('category.index')->with('success', 'Thêm danh mục thành công!');
}


public function add()
{
    $categories = Category::whereNull('parent_id')->get(); // Lấy danh mục cha
    return view('admins.category.Add', compact('categories'));
}



    /**
     * Display the specified resource.
     */
    public function showCategory(Category $category, $slug)
    {
        // Lấy danh mục theo slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Lấy sản phẩm theo danh mục và hiển thị
        // $products = Product::where('category_id', $category->id)->get();
        $products = $category->products()->paginate(10);

        return view('clients.categories_search', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admins.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
    ]);

    $category->update([
        'name' => $request->name,
        'slug' => $request->slug,
    ]);

    return redirect()->route('category.index')->with('success', 'Cập nhật danh mục thành công!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
{
    $category->delete();
    return redirect()->route('category.index')->with('success', 'Xóa danh mục thành công!');
}

    public function showHeaderCategories()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get(); // Lấy tất cả các danh mục cha và các danh mục con của nó
        return view('layouts.client', compact('categories'));
    }

}
