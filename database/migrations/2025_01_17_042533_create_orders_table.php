<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Tạo bảng orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Cột khóa chính
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Liên kết với người dùng
            // Trạng thái đơn hàng (pending, processing, completed, cancelled, shipping, delivered)
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'shipping', 'delivered'])->default('pending'); 
            // Trạng thái thanh toán (unpaid, paid, failed, cod)
            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'cod'])->default('unpaid');
            $table->decimal('total_price', 10, 2); // Tổng giá trị đơn hàng
            $table->string('shipping_address')->nullable(); // Địa chỉ giao hàng

            // Thêm cột để lưu thông tin giỏ hàng (JSON) và phương thức thanh toán
            $table->text('cart')->nullable();
            $table->string('payment_method')->nullable();

            $table->timestamps(); // created_at và updated_at
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
