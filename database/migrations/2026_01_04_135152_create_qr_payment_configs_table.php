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
        Schema::create('qr_payment_configs', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name', 100)->comment('Tên ngân hàng');
            $table->string('account_number', 50)->comment('Số tài khoản');
            $table->string('account_name', 100)->comment('Tên chủ tài khoản');
            $table->string('qr_image')->nullable()->comment('Ảnh QR code');
            $table->text('note')->nullable()->comment('Ghi chú thêm');
            $table->boolean('is_active')->default(true)->comment('Trạng thái kích hoạt');
            $table->integer('sort_order')->default(0)->comment('Thứ tự hiển thị');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_payment_configs');
    }
};
