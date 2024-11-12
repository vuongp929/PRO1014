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
        Schema::table('san_phams', function (Blueprint $table) {
            $table->string('hinh_anh')->nullable()->after('trang_thai');
            $table->date('ngay_nhap')->default(date('Y-m-d'))->change(); 
            // Cập nhật trường bằng migration
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('san_phams', function (Blueprint $table) {
            $table->dropColumn('hinh_anh'); // Xóa trường hinh_anh
            $table->date('ngay_nhap')->change(); // Cập nhật ngược lại ngay_nhap
        });
    }
};
