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
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_cancelled')->default(false)->after('payment_status');
            $table->timestamp('cancelled_at')->nullable()->after('is_cancelled');
            $table->text('cancellation_reason')->nullable()->after('cancelled_at');
            $table->string('refund_method')->nullable()->after('cancellation_reason')->comment('qr_image hoặc bank_account');
            $table->string('refund_qr_image')->nullable()->after('refund_method')->comment('Ảnh QR để hoàn tiền');
            $table->string('refund_bank_account')->nullable()->after('refund_qr_image')->comment('STK để hoàn tiền');
            $table->string('refund_bank_name')->nullable()->after('refund_bank_account')->comment('Tên ngân hàng hoàn tiền');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'is_cancelled',
                'cancelled_at',
                'cancellation_reason',
                'refund_method',
                'refund_qr_image',
                'refund_bank_account',
                'refund_bank_name'
            ]);
        });
    }
};
