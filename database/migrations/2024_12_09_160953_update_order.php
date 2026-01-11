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
            if (!Schema::hasColumn('orders', 'address_id')) {
                $table->unsignedBigInteger('address_id')->nullable(); // ID công ty (nếu áp dụng)
            }
        
            // Liên kết khóa ngoại tới bảng addresses (chỉ thêm nếu chưa có)
            if (Schema::hasColumn('orders', 'address_id')) {
                // Kiểm tra xem foreign key đã tồn tại chưa
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'orders' 
                    AND COLUMN_NAME = 'address_id' 
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");
                
                if (empty($foreignKeys)) {
                    $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key first - try multiple possible constraint names
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'orders' 
                AND COLUMN_NAME = 'address_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            
            if (!empty($foreignKeys)) {
                $constraintName = $foreignKeys[0]->CONSTRAINT_NAME;
                try {
                    // Try dropping by constraint name
                    DB::statement("ALTER TABLE `orders` DROP FOREIGN KEY `{$constraintName}`");
                } catch (\Exception $e) {
                    // If that fails, try dropping by column name (Laravel's default naming)
                    try {
                        $table->dropForeign(['address_id']);
                    } catch (\Exception $e2) {
                        // If both fail, just continue - foreign key might not exist
                    }
                }
            }
            
            // Drop column if exists
            if (Schema::hasColumn('orders', 'address_id')) {
                $table->dropColumn('address_id');
            }
        });
    }
};
