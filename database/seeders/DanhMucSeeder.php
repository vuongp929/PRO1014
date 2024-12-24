<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) { 
            DB::table('danh_mucs')->insert([
                'ten_danh_muc' => "Danh mục $i",
                'trang_thai' => true
            ]);
        }
    }
}
