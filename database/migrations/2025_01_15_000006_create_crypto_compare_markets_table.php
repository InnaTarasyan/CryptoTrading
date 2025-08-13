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
        Schema::create('crypto_compare_markets', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('name');
            $table->boolean('internal')->default(false);
            $table->string('image_url')->nullable();
            $table->string('url')->nullable();
            $table->string('algorithm')->nullable();
            $table->string('proof_type')->nullable();
            $table->string('net_hashes_per_second')->nullable();
            $table->bigInteger('block_number')->nullable();
            $table->integer('block_time')->nullable();
            $table->decimal('block_reward', 20, 8)->nullable();
            $table->dateTime('asset_launch_date')->nullable();
            $table->decimal('max_supply', 20, 8)->nullable();
            $table->integer('mkt_cap_penalty')->nullable();
            $table->boolean('is_trading')->default(false);
            $table->decimal('total_coin_supply', 20, 8)->nullable();
            $table->decimal('pre_mined_value', 20, 8)->nullable();
            $table->decimal('total_coins_free_float', 20, 8)->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('sponsored')->default(false);
            $table->decimal('price_usd', 20, 8)->nullable();
            $table->bigInteger('volume_24h_usd')->nullable();
            $table->bigInteger('market_cap_usd')->nullable();
            $table->decimal('change_24h_usd', 20, 8)->nullable();
            $table->decimal('change_pct_24h_usd', 10, 4)->nullable();
            $table->decimal('high_24h_usd', 20, 8)->nullable();
            $table->decimal('low_24h_usd', 20, 8)->nullable();
            $table->decimal('open_24h_usd', 20, 8)->nullable();
            $table->decimal('supply', 20, 8)->nullable();
            $table->dateTime('last_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_compare_markets');
    }
}; 