<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class NhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nhan_viens')->insert([
            [
                'ma_nhan_vien'=>'NV001',
                'ten_nhan_vien'=>'Vuong1',
                'hinh_anh'=>'',
                'ngay_vao_lam'=>'2024-12-29',
                'luong'=>'29000000',
                'trang_thai'=> '1',
            ],
            [
                'ma_nhan_vien'=>'NV002',
                'ten_nhan_vien'=>'Vuong2',
                'hinh_anh'=>'',
                'ngay_vao_lam'=>'2024-12-29',
                'luong'=>'29000000',
                'trang_thai'=> '1',
            ],
            [
                'ma_nhan_vien'=>'NV003',
                'ten_nhan_vien'=>'Vuong3',
                'hinh_anh'=>'',
                'ngay_vao_lam'=>'2024-12-29',
                'luong'=>'29000000',
                'trang_thai'=> '1',
            ],
            [
                'ma_nhan_vien'=>'NV004',
                'ten_nhan_vien'=>'Vuong4',
                'hinh_anh'=>'',
                'ngay_vao_lam'=>'2024-12-29',
                'luong'=>'29000000',
                'trang_thai'=> '1',
            ],
            [
                'ma_nhan_vien'=>'NV005',
                'ten_nhan_vien'=>'Vuong5',
                'hinh_anh'=>'',
                'ngay_vao_lam'=>'2024-12-29',
                'luong'=>'29000000',
                'trang_thai'=> '1',
            ],
           
        ]);
    }
}
