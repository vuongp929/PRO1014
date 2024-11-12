<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminNhanVienRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminsNhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listNhanVien = DB::table('nhan_viens')->orderByDesc('id')->paginate(5);

        return view('admins.nhanviens.index', compact('listNhanVien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.nhanviens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminNhanVienRequest $request)
    {
        DB::beginTransaction();

        try{
            $filePath = null;
            if($request->hasFile('hinh_anh')){
                $filePath = $request->file('hinh_anh')->store('uploads/nhanvien', 'public');

            }

            $dataNhanVien = [
                'ma_nhan_vien'  => $request->input('ma_nhan_vien'),
                'ten_nhan_vien' =>$request->input('ten_nhan_vien'),
                'hinh_anh'      => $filePath,
                'ngay_vao_lam'  =>$request->input('ngay_vao_lam'),
                'luong'         =>$request->input('luong'),
                'trang_thai'    =>$request->input('trang_thai'),
                'created_at' => now(),
                'updated_at' => null,
            ];

            DB::table('nhan_viens')->insert($dataNhanVien);

            DB::commit();

            return redirect()->route('nhanviens.index')
                                ->with('success','Thêm nhân viên thành công!!!');

        } catch(\PDOException $e){
            DB::rollBack();

            return redirect()->route('nhanviens.index')
                                ->with('error', 'Có lỗi khi thêm sinh viên@@');
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
        $nhanVien = DB::table('nhan_viens')->Find($id);

        if (!$nhanVien) {
            return redirect()->route('nhanviens.index')->with('error', 'Nhân viên không tồn tại!');
        }

        return view('admins.nhanviens.edit', compact('nhanVien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminNhanVienRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $nhanVien = DB::table('nhan_viens')->Find($id);

            if (!$nhanVien) {
                return redirect()->route('nhanviens.index')
                                    ->with('error', 'Nhân viên không tồn tại!');
            }

            $filePath = $nhanVien->hinh_anh;
            if ($request->hasFile('hinh_anh')) {
                $filePath = $request->file('hinh_anh')->store('uploads/nhanVien', 'public');
                
                // Xóa hình ảnh cũ nếu có
                if($nhanVien->hinh_anh && Storage::disk('public')->exists($nhanVien->hinh_anh)) {
                    Storage::disk('public')->delete($nhanVien->hinh_anh);
                }

                
            }

            $dataNhanVien = [
                'ten_nhan_vien' =>$request->input('ten_nhan_vien'),
                'hinh_anh'      => $filePath,
                'ngay_vao_lam'  =>$request->input('ngay_vao_lam'),
                'luong'         =>$request->input('luong'),
                'trang_thai'    =>$request->input('trang_thai'),
                'updated_at' => now(),
            ];

            

            DB::table('nhan_viens')->where('id', $id)->update($dataNhanVien);

            DB::commit();

            return redirect()->route('nhanviens.index')
                                ->with('success','Update nhân viên thành công!!!');

            } catch(\PDOException $e){
                DB::rollBack();

                return redirect()->route('nhanviens.index')
                                    ->with('error', 'Có lỗi khi update nhân viên@@');
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $nhanVien = DB::table('nhan_viens')->find($id);

            if (!$nhanVien) {
                return redirect()->route('nhanviens.index')->with('error', 'Nhân viên không tồn tại!');
            }

                // Xóa hình ảnh cũ nếu có
                if ($nhanVien->hinh_anh && file_exists(public_path('storage/' . $nhanVien->hinh_anh))) {
                    unlink(public_path('storage/' . $nhanVien->hinh_anh));
                }
            


            DB::table('nhan_viens')->where('id', $id)->delete();

            DB::commit();

            return redirect()->route('nhanviens.index')
                                ->with('success','Xóa nhân viên thành công!!!');

            } catch(\PDOException $e){
                DB::rollBack();

                return redirect()->route('nhanviens.index')
                                    ->with('error', 'Có lỗi khi xóa nhân viên@@');
            }
    }
}
