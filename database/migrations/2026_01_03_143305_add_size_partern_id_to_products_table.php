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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'size_partern_id')) {
                $table->unsignedBigInteger('size_partern_id')->nullable()->after('Amounts');
                $table->foreign('size_partern_id')->references('id')->on('size_parterns')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'size_partern_id')) {
                // Drop foreign key first
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'products' 
                    AND COLUMN_NAME = 'size_partern_id' 
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");
                
                if (!empty($foreignKeys)) {
                    try {
                        DB::statement("ALTER TABLE `products` DROP FOREIGN KEY `{$foreignKeys[0]->CONSTRAINT_NAME}`");
                    } catch (\Exception $e) {
                        $table->dropForeign(['size_partern_id']);
                    }
                }
                
                $table->dropColumn('size_partern_id');
            }
        });
    }
};
