<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Khóa ngoại tới bảng orders
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Khóa ngoại tới bảng products
            $table->foreignId('product_variant_id')->nullable()->constrained('product_variants')->onDelete('set null'); // Khóa ngoại tới product_variants
            $table->integer('quantity'); // Số lượng sản phẩm
            $table->string('size')->nullable(); // Lưu size của sản phẩm
            $table->decimal('price_at_order', 12, 2); // Giá tại thời điểm đặt hàng
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
