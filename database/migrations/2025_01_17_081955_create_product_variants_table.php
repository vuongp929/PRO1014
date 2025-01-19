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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id(); // ID của variant
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Liên kết với sản phẩm (foreign key)
            $table->string('size')->nullable(); // Kích thước của variant
            $table->string('color')->nullable(); // Màu sắc của variant
            $table->decimal('price', 10, 2)->nullable(); // Giá của variant
            $table->integer('stock')->default(0); // Số lượng trong kho
            $table->timestamps(); // Created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
