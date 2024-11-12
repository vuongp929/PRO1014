<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use App\Http\Requests\StoreBaiVietRequest;
use App\Http\Requests\UpdateBaiVietRequest;
use App\Http\Resources\BaiVietResource;
use Illuminate\Support\Facades\Storage;

class BaiVietController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy ra danh sách toàn bộ bài voeets
        // Sử dụng Eloquent để truy xuất dữ liệu
        // Để sử dụng được Eloquent bắt buộc phải có model
        $baiViets = BaiViet::orderByDesc('id')->paginate(5);

        //dd($baiViets);
        
        // Trả về thông tin bài viết dưới dạng JSON
        return BaiVietResource::collection($baiViets);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBaiVietRequest $request)
    { 
            // Xử lý hình ảnh
            $filePath = null;
            if ($request->hasFile('hinh_anh')) {
                $filePath = $request->file('hinh_anh')->store('uploads/sanpham', 'public');
            }

            // Xử lý thêm dữ liệu
            $dataBaiViet = [
                'hinh_anh' => $filePath,
                'tieu_de'    => $request->input('tieu_de'),
                'noi_dung'   => $request->input('noi_dung'),
                'ngay_dang'  => $request->input('ngay_dang'),
                'trang_thai' => $request->input('trang_thai'),
            ];
            // Lưu dữ liệu vào database
            $newBaiViet = BaiViet::create($dataBaiViet);

            // trả ra dữ liệu bài viết dưới dạng json
            return response()->json([
                'message' => 'Thêm bài viết thành công',
                'data'    => new BaiVietResource($newBaiViet),
            ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BaiViet $baiviet)
    {
        if($baiviet){
            return new BaiVietResource($baiviet);
        }else{
            return response()->json([
                'message' => 'Bài viết không tồn tại'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBaiVietRequest $request, BaiViet $baiviet)
    {
        // lấy lại thông tin sản phẩm cần sửa

        // ktra sản phẩm đó có tồn tại hay không
        if(!$baiviet){
            return response()->json(['message' => 'không tìm thấy sản phẩm']);
        }

        // Xử lý hình ảnh
        $filePath = $baiviet->hinh_anh; // giữ nguyên hình ảnh cũ(nếu có)
        if ($request->hasFile('hinh_anh')) {
            $filePath = $request->file('hinh_anh')->store('uploads/baviet', 'public');
            
            // xóa hình ảnh cú nếu có hình ảnh mới đẩy lên
            if($baiviet->hinh_anh && Storage::disk('public')->exists($baiviet->hinh_anh)) {
                Storage::disk('public')->delete($baiviet->hinh_anh);
            }
        }

        // Xử lý cập nhật dữ liệu
        $dataBaiViet = [
            'hinh_anh' => $filePath,
            'tieu_de'    => $request->input('tieu_de'),
            'noi_dung'   => $request->input('noi_dung'),
            'ngay_dang'  => $request->input('ngay_dang'),
            'trang_thai' => $request->input('trang_thai'),
        ];
        $baiviet->update($dataBaiViet);

        // trả ra dữ liệu bài viết dưới dạng json
        return response()->json([
            'message' => 'Thêm bài viết thành công',
            'data'    => new BaiVietResource($baiviet),
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BaiViet $baiviet)
    {
        if(!$baiviet){
            return response()->json(['message' => 'không tìm thấy bài viết']);
        }

        $filePath = $baiviet->hinh_anh; // giữ nguyên hình ảnh cũ(nếu có)
        $deleteBaiViet = $baiviet->delete();
        if ($deleteBaiViet) {            
            // xóa hình ảnh 
            if(isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            return response()->json(['message' => 'Xóa bài viết thành công!']);
        }
        return response()->json(['message' => 'Xóa bài viết thất bại!']);
    }
}