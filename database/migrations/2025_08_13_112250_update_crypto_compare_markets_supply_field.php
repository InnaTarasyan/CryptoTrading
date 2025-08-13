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
        Schema::table('crypto_compare_markets', function (Blueprint $table) {
            // Change supply from decimal to bigInteger
            $table->bigInteger('supply')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crypto_compare_markets', function (Blueprint $table) {
            // Revert supply back to decimal
            $table->decimal('supply', 20, 8)->nullable()->change();
        });
    }
};
