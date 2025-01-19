<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo 10 sản phẩm
        for ($i = 1; $i <= 10; $i++) {
            // Tạo sản phẩm
            $product = Product::create([
                'name' => 'Sản phẩm ' . $i,
                'code' => 'SP' . str_pad($i, 4, pad_string: '0', pad_type: STR_PAD_LEFT),
                'image' => 'images/product_' . $i . '.jpg', // Đường dẫn giả
                // 'status' => rand(0, 1), // Random trạng thái
            ]);

            // Tạo 3 biến thể cho mỗi sản phẩm
            for ($j = 1; $j <= 3; $j++) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => 'Size ' . ['S', 'M', 'L'][$j - 1],
                    'price' => rand(100000, 500000), // Random giá từ 100,000 - 500,000
                ]);
            }
        }
    }
}
