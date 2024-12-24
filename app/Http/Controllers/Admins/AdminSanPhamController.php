<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSanPhamRequest;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class AdminSanPhamController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Lấy ra toàn bộ dữ liệu
        // $listSanPham = DB::table('san_phams')->orderByDesc('id')->paginate(5);

        // Sử dụng Eloquent khi muốn sử dụng xóa mềm
        $listSanPham = SanPham::orderByDesc('id')->paginate(5);

        // Kết quả trả ra là một mảng các đối tượng
        // dd($listSanPham);

        return view('admins.sanphams.index', compact('listSanPham'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admins.sanphams.create');

        //

    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(AdminSanPhamRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            // Xử lý hình ảnh
            $filePath = null;
            if ($request->hasFile('hinh_anh')) {
                $filePath = $request->file('hinh_anh')->store('uploads/sanpham', 'public');
            }

            // Xử lý thêm dữ liệu
            $dataSanPham = [
                'ma_san_pham' => $request->input('ma_san_pham'),
                'ten_san_pham' => $request->input('ten_san_pham'),
                'gia' => $request->input('gia'),
                'gia_khuyen_mai' => $request->input('gia_khuyen_mai'),
                'so_luong' => $request->input('so_luong'),
                'ngay_nhap' => $request->input('ngay_nhap'),
                'mo_ta' => $request->input('mo_ta'),
                'hinh_anh' => $filePath,
                'trang_thai' => $request->input('trang_thai'),
                'created_at' => now(),
                'updated_at' => null,
            ];
            // Kiểm tra xem đã lấy được đủ dữ liệu lên chưa
            // dd($dataSanPham);

            // Lưu dữ liệu vào database
            DB::table('san_phams')->insert($dataSanPham);

            DB::commit();

            // Chuyển hướng về trang danh sách và hiển thị thông báo
            return redirect()->route('sanphams.index')
                ->with('success', 'Thêm sản phẩm thành công!');
        } catch (\PDOException $e) {
            DB::rollBack();

            return redirect()->route('sanphams.index')
                ->with('error', 'Có lỗi xảy ra khi thêm sản phẩm. Vui lòng thử lại sau!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        // Lấy ra dữ liệu của sản phẩm cần sửa
        $sanPham = DB::table('san_phams')->find($id);

        // Kiểm tra sản phẩm đó có tồn tại hay không
        if (!$sanPham) {
            return redirect()->route('sanphams.index')
                ->with('error', 'Sản phẩm không tồn tại');
        }

        // Hiển thị giao diện sửa dữ liệu
        return view('admins.sanphams.edit', compact('sanPham'));

        //

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(AdminSanPhamRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            // Lấy lại thông tin của sản phẩm cần sửa
            $sanPham = DB::table('san_phams')->find($id);

            // Kiểm tra sản phẩm đó có tồn tại hay không
            if (!$sanPham) {
                return redirect()->route('sanphams.index')
                    ->with('error', 'Sản phẩm không tồn tại');
            }

            // Xử lý hình ảnh
            $filePath = $sanPham->hinh_anh; // Giữ nguyên hình ảnh cũ nếu có
            if ($request->hasFile('hinh_anh')) {
                $filePath = $request->file('hinh_anh')->store('uploads/sanpham', 'public');

                // Xóa hình cũ nếu có hình ảnh mới đẩy lên
                if ($sanPham->hinh_anh && Storage::disk('public')->exists($sanPham->hinh_anh)) {
                    Storage::disk('public')->delete($sanPham->hinh_anh);
                }
            }

            // Xử lý cập nhật dữ liệu
            $dataSanPham = [
                'ten_san_pham' => $request->input('ten_san_pham'),
                'gia' => $request->input('gia'),
                'gia_khuyen_mai' => $request->input('gia_khuyen_mai'),
                'so_luong' => $request->input('so_luong'),
                'ngay_nhap' => $request->input('ngay_nhap'),
                'mo_ta' => $request->input('mo_ta'),
                'hinh_anh' => $filePath,
                'trang_thai' => $request->input('trang_thai'),
                'updated_at' => now(),
            ];
            // Kiểm tra xem đã lấy được đủ dữ liệu lên chưa
            // dd($dataSanPham);

            // Lưu dữ liệu vào database
            DB::table('san_phams')->where('id', $id)->update($dataSanPham);

            DB::commit();

            // Chuyển hướng về trang danh sách và hiển thị thông báo
            return redirect()->route('sanphams.index')
                ->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\PDOException $e) {
            DB::rollBack();

            return redirect()->route('sanphams.index')
                ->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm. Vui lòng thử lại sau!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // Lấy lại thông tin của sản phẩm cần xóa
        // Sử dụng query builder
        // $sanPham = DB::table('san_phams')->find($id);

        // Muốn xóa mềm phải sử dụng eloquent
        $sanPham = SanPham::find($id);

        // Kiểm tra sản phẩm đó có tồn tại hay không
        if (!$sanPham) {
            return redirect()->route('sanphams.index')
                ->with('error', 'Sản phẩm không tồn tại');
        }

        // Lưu trữ đường dẫn của hình ảnh vào đây
        $filePath = $sanPham->hinh_anh;

        // Sử dụng query builder
        // $deleteSanPham = DB::table('san_phams')->where('id', $id)->delete();

        // Sử dụng eloquent
        $deleteSanPham = $sanPham->delete();
        // dd($deleteSanPham);

        // Nếu xóa thành công thì tiến hành xóa ảnh
        if ($deleteSanPham) {
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            return redirect()->route('sanphams.index')
                ->with('success', 'Xóa sản phẩm thành công!');
        }

        return redirect()->route('sanphams.index')
            ->with('error', 'Có lỗi xảy ra khi xóa sản phẩm. Vui lòng thử lại sau!');
    }
}


       //
    


