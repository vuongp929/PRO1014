<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSinhVienRequest extends FormRequest
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
            'ma_sv'        => 'required|max:20|unique:sinh_viens,ma_sv,' . $this->sinhvien,
            'ten'          => 'required|max:255|regex:/^[^\d!@#$%^&*(),.?":{}|<>]*$/',
            'email'        => 'required|email|ends_with:@fe.edu.vn|unique:sinh_viens,email,' . $this->sinhvien,
            'nam_hoc'      => 'required|integer|min:1990|max:' . date('Y'),
            'gioi_tinh'    => 'required|in:0,1',
            'trang_thai'   => 'required|in:0,1',
            'hinh_anh'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mo_ta'        => 'nullable|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'ma_sv.required'       => 'Mã sinh viên bắt buộc điền.',
            'ma_sv.unique'         => 'Mã sinh viên không được trùng.',
            'ma_sv.max'            => 'Mã sinh viên quá dài.',

            'ten.required'         => 'Tên sinh viên bắt buộc điền.',
            'ten.max'              => 'Tên sinh viên quá dài.',
            'ten.regex'            => 'Tên sinh viên không được chứa số hoặc ký tự đặc biệt.',

            'email.required'       => 'Email bắt buộc điền.',
            'email.email'          => 'Email không hợp lệ.',
            'email.ends_with'      => 'Email phải kết thúc bằng @fe.edu.vn.',
            'email.unique'         => 'Email không được trùng.',

            'nam_hoc.required'     => 'Năm học bắt buộc điền.',
            'nam_hoc.integer'      => 'Năm học phải là số nguyên.',
            'nam_hoc.min'          => 'Năm học phải lớn hơn 1990.',
            'nam_hoc.max'          => 'Năm học không hợp lệ.',

            'gioi_tinh.required'   => 'Giới tính bắt buộc chọn.',
            'gioi_tinh.in'         => 'Giới tính không hợp lệ.',

            'trang_thai.required'  => 'Trạng thái bắt buộc chọn.',
            'trang_thai.in'        => 'Trạng thái không hợp lệ.',

            'hinh_anh.image'       => 'Hình ảnh không hợp lệ.',
            'hinh_anh.mimes'       => 'Hình ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'hinh_anh.max'         => 'Hình ảnh không được vượt quá 2MB.',

            'mo_ta.string'         => 'Mô tả phải là chuỗi ký tự.',
            'mo_ta.max'            => 'Mô tả không được vượt quá 1000 ký tự.',
        ];
    }
}
