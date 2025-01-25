<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy một vài users có trong database
        $users = User::all();

        // Lấy một vài products có trong database (nếu có bảng sản phẩm)
        $products = Product::all();

        // Tạo đơn hàng cho từng user
        foreach ($users as $user) {
            // Tạo một đơn hàng mẫu
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending', // Trạng thái đơn hàng (pending, completed, cancelled...)
                'payment_status' => 'unpaid', // Trạng thái thanh toán (unpaid, paid...)
                'total_price' => rand(100, 1000), // Tổng giá trị đơn hàng ngẫu nhiên
                'shipping_address' => 'Address for user ' . $user->name, // Địa chỉ giao hàng mẫu
            ]);

            // Tạo một số order items (sản phẩm trong đơn hàng)
            for ($i = 0; $i < rand(1, 5); $i++) { // Số lượng sản phẩm trong mỗi đơn hàng
                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $products->random()->id, // Chọn ngẫu nhiên một sản phẩm
                    'quantity' => rand(1, 3), // Số lượng ngẫu nhiên
                    'price' => rand(100, 500), // Giá sản phẩm ngẫu nhiên
                ]);
            }
        }
    }
}
