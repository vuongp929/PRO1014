<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Mặc định trong 1 file migration bắt buộc phải có hàm UP và hàm DOWN

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('san_phams', function (Blueprint $table) {
            // Nơi khai báo các trường dữ liệu của bảng
            $table->id();
            $table->string('ma_san_pham', 20)->unique(); // Không cho phép giá trị trùng nhau
            $table->string('ten_san_pham');
            $table->decimal('gia', 10, 2);
            $table->decimal('gia_khuyen_mai', 10, 2)->nullable(); // Cho phép trường có giá trị null
            $table->unsignedInteger('so_luong');
            $table->date('ngay_nhap');
            $table->text('mo_ta')->nullable();
            $table->boolean('trang_thai')->default(true); // Xét giá trị mặc định cho trường
            $table->timestamps(); // Tự sinh ra trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Công việc trong hàm DOWN luôn luôn phải có 
        // và ngược lại tất cả các công việc trên hàm UP
        Schema::dropIfExists('san_phams');
    }
};
