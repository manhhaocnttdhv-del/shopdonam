<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add missing timestamps if not exist
            if (!Schema::hasColumn('orders', 'created_at') && !Schema::hasColumn('orders', 'updated_at')) {
                $table->timestamps();
            } elseif (!Schema::hasColumn('orders', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            } elseif (!Schema::hasColumn('orders', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }

            // Add order_number
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number', 50)->unique()->nullable()->after('id');
            }

            // Standardize status column name
            if (Schema::hasColumn('orders', 'Status') && !Schema::hasColumn('orders', 'status')) {
                DB::statement('ALTER TABLE orders CHANGE Status status INT DEFAULT 1');
            } elseif (!Schema::hasColumn('orders', 'status')) {
                $table->integer('status')->default(1)->after('total');
            }

            // Add payment fields
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method', 50)->default('cod')->after('status');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status', 50)->default('pending')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'payment_transaction_id')) {
                $table->unsignedBigInteger('payment_transaction_id')->nullable()->after('payment_status');
            }

            // Change total to decimal
            if (Schema::hasColumn('orders', 'total')) {
                DB::statement('ALTER TABLE orders MODIFY total DECIMAL(15,2) NULL');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_number')) {
                $table->dropColumn('order_number');
            }
            if (Schema::hasColumn('orders', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            if (Schema::hasColumn('orders', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
            if (Schema::hasColumn('orders', 'payment_transaction_id')) {
                $table->dropColumn('payment_transaction_id');
            }
        });
    }
};


