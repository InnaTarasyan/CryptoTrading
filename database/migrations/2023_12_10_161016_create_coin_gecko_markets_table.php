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
        Schema::create('coin_gecko_markets', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->double('current_price')->nullable();
            $table->bigInteger('market_cap')->nullable();
            $table->integer('market_cap_rank')->nullable();
            $table->bigInteger('fully_diluted_valuation')->nullable();
            $table->bigInteger('total_volume')->nullable();
            $table->double('high_24h')->nullable();
            $table->double('low_24h')->nullable();
            $table->double('price_change_24h')->nullable();
            $table->double('price_change_percentage_24h')->nullable();
            $table->double('market_cap_change_24h')->nullable();
            $table->double('market_cap_change_percentage_24h')->nullable();
            $table->double('circulating_supply')->nullable();
            $table->double('total_supply')->nullable();
            $table->double('max_supply')->nullable();
            $table->double('ath')->nullable();
            $table->double('ath_change_percentage')->nullable();
            $table->dateTime('ath_date')->nullable();
            $table->double('atl')->nullable();
            $table->double('atl_change_percentage')->nullable();
            $table->json('roi')->nullable();
            $table->dateTime('last_updated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_gecko_markets');
    }
};
