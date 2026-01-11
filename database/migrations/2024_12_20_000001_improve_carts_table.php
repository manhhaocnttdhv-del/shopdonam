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
        // Rename quanity to quantity
        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn('carts', 'quanity')) {
                DB::statement('ALTER TABLE carts CHANGE quanity quantity INT DEFAULT NULL');
            }
        });

        // Change price and subtotal to decimal
        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn('carts', 'price')) {
                DB::statement('ALTER TABLE carts MODIFY price DECIMAL(15,2) NOT NULL');
            }
            if (Schema::hasColumn('carts', 'subtotal')) {
                DB::statement('ALTER TABLE carts MODIFY subtotal DECIMAL(15,2) NOT NULL');
            }
        });

        // Remove redundant fields (thumb, nameProduct) - keep for now to preserve data
        // These can be accessed via product relationship
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn('carts', 'quantity')) {
                DB::statement('ALTER TABLE carts CHANGE quantity quanity INT DEFAULT NULL');
            }
        });
    }
};







