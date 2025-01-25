<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Cột khóa chính
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Liên kết với người dùng (nullable nếu không có người dùng)
            $table->string('status')->default('pending'); // Trạng thái đơn hàng (pending, processing, completed, etc.)
            $table->string('payment_status')->default('unpaid'); // Trạng thái thanh toán (unpaid, paid, failed)
            $table->decimal('total_price', 10, 2); // Tổng giá trị đơn hàng
            $table->string('shipping_address')->nullable(); // Địa chỉ giao hàng
            $table->timestamps(); // Các cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders'); // Xóa bảng orders khi rollback migration
    }
}

