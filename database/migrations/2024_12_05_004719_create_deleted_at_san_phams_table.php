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
            $table->softDeletes();// Thêm 1 cột deleted_at trong bảng sản phẩm
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('san_phams', function (Blueprint $table) {
            $table->dropSoftDeletes();// Xóa cột deleted_at trong bảng sản phẩm
            
        });
    }
};
