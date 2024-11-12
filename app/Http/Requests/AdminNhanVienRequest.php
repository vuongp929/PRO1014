<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminNhanVienRequest extends FormRequest
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
            'ma_nhan_vien' => 'required|unique:nhan_viens|max:255'. $this->nhanvien,
            'ten_nhan_vien' => 'required|max:255',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ngay_vao_lam' => 'required|date',
            'luong' => 'required|numeric|min:0',
            'trang_thai' => 'required|boolean',
        ];
    }
    public function messages()
{
    return [
        'ma_nhan_vien.required'      => 'Mã nhân viên bắt buộc điền.',
        'ma_nhan_vien.unique'        => 'Mã nhân viên không được trùng.',
        'ma_nhan_vien.max'           => 'Mã nhân viên quá dài.',

        'ten_nhan_vien.required'     => 'Tên nhân viên bắt buộc điền.',
        'ten_nhan_vien.max'          => 'Tên nhân viên quá dài.',

        'ngay_vao_lam.required'      => 'Ngày vào làm bắt buộc điền.',
        'ngay_vao_lam.date'          => 'Ngày vào làm không hợp lệ.',

        'luong.required'             => 'Lương nhân viên bắt buộc điền.',
        'luong.numeric'              => 'Lương nhân viên phải là một số.',
        'luong.min'                  => 'Lương nhân viên không hợp lệ.',

        'trang_thai.required'        => 'Trạng thái bắt buộc điền.',
        'trang_thai.boolean'         => 'Trạng thái không hợp lệ.',

        'hinh_anh.image'             => 'Hình ảnh không hợp lệ.',
        'hinh_anh.mimes'             => 'Hình ảnh phải có định dạng jpg, jpeg hoặc png.',
        'hinh_anh.max'               => 'Kích thước hình ảnh không được vượt quá 2MB.'
    ];
}

}
