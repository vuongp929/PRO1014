<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SinhVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sinh_viens')->insert([
            [
                'ma_sinh_vien'=>'SV001',
                'ten_sinh_vien'=>'Vuong1',
                'hinh_anh'=>'',
                'ngay_sinh'=>'2002-12-29',
                'so_dien_thoai'=>'0858363388',
                'trang_thai'=> '1',
            ],
            [
                'ma_sinh_vien'=>'SV002',
                'ten_sinh_vien'=>'Vuong2',
                'hinh_anh'=>'',
                'ngay_sinh'=>'2002-12-29',
                'so_dien_thoai'=>'0858363388',
                'trang_thai'=> '1',
            ],
            [
                'ma_sinh_vien'=>'SV003',
                'ten_sinh_vien'=>'Vuong3',
                'hinh_anh'=>'',
                'ngay_sinh'=>'2002-12-29',
                'so_dien_thoai'=>'0858363388',
                'trang_thai'=> '1',
            ],
            [
                'ma_sinh_vien'=>'SV004',
                'ten_sinh_vien'=>'Vuong4',
                'hinh_anh'=>'',
                'ngay_sinh'=>'2002-12-29',
                'so_dien_thoai'=>'0858363388',
                'trang_thai'=> '1',
            ],
            [
                'ma_sinh_vien'=>'SV005',
                'ten_sinh_vien'=>'Vuong5',
                'hinh_anh'=>'',
                'ngay_sinh'=>'2002-12-29',
                'so_dien_thoai'=>'0858363388',
                'trang_thai'=> '1',
            ],
        ]);
    }
}
