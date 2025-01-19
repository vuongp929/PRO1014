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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->string('name'); // Tên sản phẩm
            $table->string('code')->unique(); // Mã sản phẩm duy nhất
            $table->string('image')->nullable(); //
            $table->text('description')->nullable(); // Mô tả sản phẩm
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
