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
        Schema::create('coin_gecko_trendings', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->integer('coin_id');
            $table->string('name');
            $table->string('symbol');
            $table->integer('market_cap_rank')->nullable();
            $table->string('thumb')->nullable();
            $table->string('small')->nullable();
            $table->string('large')->nullable();
            $table->string('slug');
            $table->double('price_btc')->nullable();
            $table->double('score')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_gecko_trendings');
    }
};
