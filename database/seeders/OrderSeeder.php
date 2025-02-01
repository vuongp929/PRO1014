<?php 

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\ProductVariant; // Sử dụng ProductVariant thay vì Product
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy danh sách người dùng
        $users = User::all();

        // Lấy danh sách product_variants
        $productVariants = ProductVariant::all();

        // Nếu không có product_variants, dừng việc seeding
        if ($productVariants->isEmpty()) {
            $this->command->error('Không có product_variants nào trong cơ sở dữ liệu. Hãy thêm dữ liệu trước khi chạy OrderSeeder.');
            return;
        }

        // Tạo đơn hàng cho từng user
        foreach ($users as $user) {
            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total_price' => 0, // Tạm thời đặt bằng 0
                'shipping_address' => 'Address for user ' . $user->name,
            ]);

            $totalPrice = 0;

            // Tạo sản phẩm trong đơn hàng
            for ($i = 0; $i < rand(1, 5); $i++) {
                $productVariant = $productVariants->random();

                $quantity = rand(1, 3); // Số lượng ngẫu nhiên
                $price = $productVariant->price; // Lấy giá từ bảng product_variants

                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_variant_id' => $productVariant->id,
                    'quantity' => $quantity,
                    'price_at_order' => $productVariant->price, // Giá tại thời điểm đặt hàng
                    'size' => $productVariant->size, // Size của sản phẩm
                    'product_id' => $productVariant->product_id, // Gán product_id từ product_variant
                ]);
                

                // Cộng dồn giá trị vào tổng giá đơn hàng
                $totalPrice += $quantity * $price;
            }

            // Cập nhật tổng giá trị đơn hàng
            $order->update(['total_price' => $totalPrice]);
        }
    }
}
