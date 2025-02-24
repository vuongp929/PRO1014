<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('discount')->unsigned(); // Giảm giá theo %
            $table->dateTime('expires_at')->nullable(); // Ngày hết hạn
            $table->boolean('is_active')->default(true); // Trạng thái ON/OFF
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
