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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('transaction_code', 100)->unique();
            $table->string('payment_method', 50)->default('vnpay');
            $table->decimal('amount', 15, 2);
            $table->string('status', 50)->default('pending'); // pending, success, failed, cancelled
            $table->text('vnpay_response')->nullable();
            $table->string('bank_code', 50)->nullable();
            $table->string('card_type', 50)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->index('transaction_code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};







