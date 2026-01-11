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
        Schema::table('carts', function (Blueprint $table) {
            if (!Schema::hasColumn('carts', 'sizes')) {
                $table->text('sizes')->nullable();
            }
            if (!Schema::hasColumn('carts', 'colors')) {
                $table->text('colors')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn('carts', 'sizes')) {
                $table->dropColumn('sizes');
            }
            if (Schema::hasColumn('carts', 'colors')) {
                $table->dropColumn('colors');
            }
        });
    }
};
