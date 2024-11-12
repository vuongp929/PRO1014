<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSinhVienRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminsSinhVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSinhVien = DB::table('sinh_viens')->orderByDesc('id')->paginate(5);

        return view('admins.sinhviens.index', compact('listSinhVien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.sinhviens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminSinhVienRequest $request)
    {
        DB::beginTransaction();

        try{
            $filePath = null;
            if($request->hasFile('hinh_anh')){
                $filePath = $request->file('hinh_anh')->store('uploads/sinhvien', 'public');

            }

            $dataSinhVien = [
                'ma_sinh_vien' => $request->input('ma_sinh_vien'),
                'ten_sinh_vien' =>$request->input('ten_sinh_vien'),
                'hinh_anh' => $filePath,
                'ngay_sinh' =>$request->input('ngay_sinh'),
                'so_dien_thoai' =>$request->input('so_dien_thoai'),
                'trang_thai' =>$request->input('trang_thai'),
            ];

            DB::table('sinh_viens')->insert($dataSinhVien);

            DB::commit();

            return redirect()->route('sinhviens.index')
                                ->with('success','Thêm sinh viên thành công!!!');

        } catch(\PDOException $e){
            DB::rollBack();

            return redirect()->route('sinhviens.index')
                                ->with('error', 'Có lỗi khi thêm sinh viên@@');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sinhVien = DB::table('sinh_viens')->find($id);

        if (!$sinhVien) {
            return redirect()->route('sinhviens.index')->with('error', 'Sinh viên không tồn tại!');
        }

        return view('admins.sinhviens.show', compact('sinhVien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sinhVien = DB::table('sinh_viens')->find($id);

        if (!$sinhVien) {
            return redirect()->route('sinhviens.index')->with('error', 'Sinh viên không tồn tại!');
        }

        return view('admins.sinhviens.edit', compact('sinhVien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $sinhVien = DB::table('sinh_viens')->find($id);

            if (!$sinhVien) {
                return redirect()->route('sinhviens.index')->with('error', 'Sinh viên không tồn tại!');
            }

            $filePath = $sinhVien->hinh_anh;
            if ($request->hasFile('hinh_anh')) {
                // Xóa hình ảnh cũ nếu có
                if ($filePath && file_exists(public_path('storage/' . $filePath))) {
                    unlink(public_path('storage/' . $filePath));
                }

                $filePath = $request->file('hinh_anh')->store('uploads/sinhvien', 'public');
            }

            $dataSinhVien = [
                'ma_sinh_vien' => $request->input('ma_sinh_vien'),
                'ten_sinh_vien' => $request->input('ten_sinh_vien'),
                'hinh_anh' => $filePath,
                'ngay_sinh' => $request->input('ngay_sinh'),
                'so_dien_thoai' => $request->input('so_dien_thoai'),
                'trang_thai' => $request->input('trang_thai'),
            ];

            DB::table('sinh_viens')->where('id', $id)->update($dataSinhVien);

            DB::commit();

            return redirect()->route('sinhviens.index')
                ->with('success', 'Cập nhật sinh viên thành công!');
        } catch (\PDOException $e) {
            DB::rollBack();

            return redirect()->route('sinhviens.index')
                ->with('error', 'Có lỗi khi cập nhật sinh viên!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $sinhVien = DB::table('sinh_viens')->find($id);

            if (!$sinhVien) {
                return redirect()->route('sinhviens.index')->with('error', 'Sinh viên không tồn tại!');
            }

            // Xóa hình ảnh nếu có
            if ($sinhVien->hinh_anh && file_exists(public_path('storage/' . $sinhVien->hinh_anh))) {
                unlink(public_path('storage/' . $sinhVien->hinh_anh));
            }

            DB::table('sinh_viens')->where('id', $id)->delete();

            DB::commit();

            return redirect()->route('sinhviens.index')
                ->with('success', 'Xóa sinh viên thành công!');
        } catch (\PDOException $e) {
            DB::rollBack();

            return redirect()->route('sinhviens.index')
                ->with('error', 'Có lỗi khi xóa sinh viên!');
        }
    }
}
