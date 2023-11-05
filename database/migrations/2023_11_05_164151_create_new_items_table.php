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
        Schema::create('new_items', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('name')->nullable();
            $table->string('symbol')->nullable();
            $table->string('slug')->nullable();
            $table->integer('cmc_rank')->nullable();
            $table->integer('num_market_pairs')->nullable();
            $table->integer('circulating_supply')->nullable();
            $table->integer('total_supply')->nullable();
            $table->integer('max_supply')->nullable();
            $table->dateTime('last_updated')->nullable();
            $table->dateTime('date_added')->nullable();
            $table->json('tags')->nullable();
            $table->string('platform')->nullable();
            $table->json('quote')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_items');
    }
};
