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
        Schema::create('sinh_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ma_sinh_vien', 20)->unique();
            $table->string('ten_sinh_vien');
            $table->string('hinh_anh')->nullable();
            $table->date('ngay_sinh');
            $table->string('so_dien_thoai');
            $table->boolean('trang_thai');
            $table->timestamps();
        });
    }

    /**
     * 
     */
    public function down(): void
    {
        Schema::dropIfExists('sinh_viens');
    }
};
