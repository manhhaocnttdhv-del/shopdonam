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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 15, 2); // Giá trị giảm giá (% hoặc số tiền)
            $table->decimal('min_order_amount', 15, 2)->default(0); // Giá trị đơn hàng tối thiểu
            $table->decimal('max_discount', 15, 2)->nullable(); // Giảm giá tối đa (cho percentage)
            $table->integer('usage_limit')->nullable(); // Số lần sử dụng tối đa (null = không giới hạn)
            $table->integer('used_count')->default(0); // Số lần đã sử dụng
            $table->integer('usage_per_user')->default(1); // Số lần mỗi user có thể dùng
            $table->dateTime('start_date')->nullable(); // Ngày bắt đầu
            $table->dateTime('end_date')->nullable(); // Ngày kết thúc
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Bảng lưu lịch sử sử dụng coupon
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->decimal('discount_amount', 15, 2);
            $table->timestamps();
            
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
        Schema::dropIfExists('coupons');
    }
};
