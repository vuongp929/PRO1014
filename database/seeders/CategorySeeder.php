<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Danh mục cha
        $parentCategories = [
            ['name' => 'Gấu Bông Hoạt Hình', 'slug' => Str::slug('Gấu Bông Hoạt Hình')],
            ['name' => 'Blind Box', 'slug' => Str::slug('Blind Box')],
        ];

        foreach ($parentCategories as $parent) {
            $parentId = DB::table('categories')->insertGetId($parent);

            // Gắn danh mục con vào mỗi danh mục cha
            $childCategories = $this->getChildCategories($parent['name']);

            foreach ($childCategories as $childName) {
                DB::table('categories')->insert([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parentId
                ]);
            }
        }
    }

    private function getChildCategories($parentName)
    {
        switch ($parentName) {
            case 'Gấu Bông Hoạt Hình':
                return [
                    'Gấu Bông Doremon',
                    'Gấu Bông Hello Kitty',
                    'Bộ Ba Gấu',
                    'Ngựa Bông Pony',
                    'Ô Tô Mc Queen',
                    'Shin Cậu Bé Bút Chì',
                    'Siêu Anh Hùng Bông Tròn',
                    'BST Pikachu Tinh Nghịch',
                    'Gấu Bông Hoạt Hình Hot Trend',
                    'BST Capybara',
                    'Hải Ly Loopy',
                    'Gấu Lotso',
                    'BST Kuromi – Melody – Cinnamoroll',
                    'Thú Bông Stitch',
                    'Mèo Hoàng Thượng Bông',
                    'Chó Bông Nô Tài',
                    'Thú Bông Cảm Xúc',
                    'Among Us',
                    'Gấu Brown và Thỏ Cony',
                    'Gấu Bông Totoro',
                    'Kì Lân Bông',
                    'Báo Hồng Áo Trắng',
                    'Gấu Bông Cỡ Lớn'
                ];
            case 'Blind Box':
                return [
                    'BST Rắn Bông Chào 2025',
                    'BST Hoa Gấu Bông',
                    'Gấu Bông Tặng Nàng',
                    'Gấu Bông Teddy Cao Cấp',
                ];
            default:
                return [];
        }
    }
}
