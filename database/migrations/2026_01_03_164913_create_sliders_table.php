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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Tiêu đề slider
            $table->string('subtitle')->nullable(); // Phụ đề
            $table->text('description')->nullable(); // Mô tả
            $table->string('image'); // Hình ảnh slider
            $table->string('link')->nullable(); // Link khi click vào slider
            $table->string('button_text')->nullable(); // Text nút CTA
            $table->integer('order')->default(0); // Thứ tự hiển thị
            $table->boolean('is_active')->default(true); // Trạng thái kích hoạt
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
