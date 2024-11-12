<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSanPhamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ma_san_pham'       => 'required|max:20|unique:san_phams,ma_san_pham,'. $this->sanpham,
            'ten_san_pham'      => 'required|max:255',
            'gia'               => 'required|numeric|min:0|max:99999999',
            'gia_khuyen_mai'    => 'nullable|numeric|min:0|max:99999999|lt:gia',
            'so_luong'          => 'required|integer|min:0',
            'ngay_nhap'         => 'required|date',
            'mo_ta'             => 'nullable|string',
            'trang_thai'        => 'required|in:0,1',
            'hinh_anh'          => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ];
    }

    public function messages(): array
    {
        return [
            'ma_san_pham.required'  => 'Mã sản phẩm bắt buộc điền.',
            'ma_san_pham.unique'    => 'Mã sản phẩm không được trùng.',
            'ma_san_pham.max'       => 'Mã sản phẩm quá dài.',

            'ten_san_pham.required' => 'Tên sản phẩm bắt buộc điền.',
            'ten_san_pham.max'      => 'Tên sản phẩm quá dài',

            'gia.required'          => 'Giá sản phẩm bắt buộc điền.',
            'gia.numeric'           => 'Giá sản phẩm phải là một số.',
            'gia.min'               => 'Giá sản phẩm không hợp lệ.',
            'gia.max'               => 'Giá sản phẩm không hợp lệ.',

            'gia_khuyen_mai.numeric'=> 'Giá khuyến mãi phải là một số.',
            'gia_khuyen_mai.min'    => 'Giá khuyến mãi không hợp lệ.',
            'gia_khuyen_mai.max'    => 'Giá khuyến mãi không hợp lệ.',
            'gia_khuyen_mai.lt'     => 'Giá khuyến mãi phải nhỏ hơn giá sản phẩm.',

            'so_luong.required'     => 'Số lượng bắt buộc điền.',
            'so_luong.integer'     => 'Số lượng phải là một số.',
            'so_luong.min'          => 'Số lượng không hợp lệ.',

            'ngay_nhap.required'    => 'Ngày nhập bắt buộc điền.',
            'ngay_nhap.date'        => 'Ngày nhập không hợp lệ.',

            'trang_thai.required'   => 'Trạng thái bắt buộc điền.',
            
            'hinh_anh.image'        => 'Hình ảnh không hợp lệ.'
        ];
    }
}