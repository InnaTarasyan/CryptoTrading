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
        Schema::create('coingecko_exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('name');
            $table->integer('year_established')->nullable();
            $table->string('country')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->boolean('has_trading_incentive')->nullable();
            $table->integer('trust_score')->nullable();
            $table->integer('trust_score_rank')->nullable();
            $table->double('trade_volume_24h_btc')->nullable();
            $table->double('trade_volume_24h_btc_normalized')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coingecko_exchanges');
    }
};
