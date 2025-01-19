<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Nếu bạn muốn chỉ admin được phép, có thể thêm logic tại đây.
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'variants' => 'nullable|array',
            'variants.*.size' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'stock.required' => 'Tồn kho là bắt buộc.',
            'stock.min' => 'Tồn kho phải lớn hơn hoặc bằng 0.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'variants.*.size.required' => 'Kích thước của biến thể là bắt buộc.',
            'variants.*.price.required' => 'Giá của biến thể là bắt buộc.',
            'variants.*.price.min' => 'Giá của biến thể phải lớn hơn hoặc bằng 0.',
        ];
    }
}

