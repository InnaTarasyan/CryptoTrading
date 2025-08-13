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
            // Change volume_24h_usd from decimal to bigInteger
            $table->bigInteger('volume_24h_usd')->nullable()->change();
            
            // Change market_cap_usd from decimal to bigInteger
            $table->bigInteger('market_cap_usd')->nullable()->change();
            
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
            // Revert volume_24h_usd back to decimal
            $table->decimal('volume_24h_usd', 20, 8)->nullable()->change();
            
            // Revert market_cap_usd back to decimal
            $table->decimal('market_cap_usd', 20, 8)->nullable()->change();
            
            // Revert supply back to decimal
            $table->decimal('supply', 20, 8)->nullable()->change();
        });
    }
};
