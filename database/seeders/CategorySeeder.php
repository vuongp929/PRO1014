<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'blind box', 'slug' => Str::slug('blind box')],
            ['name' => 'BST Rắn Bông Chào 2025', 'slug' => Str::slug('BST Rắn Bông Chào 2025')],
            ['name' => 'BST Hoa Gấu Bông', 'slug' => Str::slug('BST Hoa Gấu Bông')],
            ['name' => 'Gấu Bông Tặng Nàng', 'slug' => Str::slug('Gấu Bông Tặng Nàng')],
            ['name' => 'Gấu Bông Teddy Cao Cấp', 'slug' => Str::slug('Gấu Bông Teddy Cao Cấp')],
        ];

        DB::table('categories')->insert($categories);
    }
}
