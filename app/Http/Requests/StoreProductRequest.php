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

    public function rules()
{
    return [
        'code' => 'required|unique:products,code',
        'name' => 'required|string|max:255',
        // các rules khác
    ];
}

public function messages()
{
    return [
        'code.required' => 'Mã sản phẩm là bắt buộc.',
        'name.required' => 'Tên sản phẩm là bắt buộc.',
        // các thông báo lỗi khác
    ];
}

}

