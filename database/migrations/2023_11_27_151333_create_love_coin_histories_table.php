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
        Schema::create('live_coin_histories', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('symbol')->nullable();
            $table->integer('rank');
            $table->integer('age')->nullable();
            $table->string('color')->nullable();
            $table->string('png32')->nullable();
            $table->string('png64')->nullable();
            $table->string('webp32')->nullable();
            $table->string('webp64')->nullable();
            $table->integer('exchanges')->nullable();
            $table->integer('markets')->nullable();
            $table->integer('pairs')->nullable();
            $table->double('allTimeHighUSD')->nullable();
            $table->bigInteger('circulatingSupply')->nullable();
            $table->bigInteger('totalSupply')->nullable();
            $table->bigInteger('maxSupply')->nullable();
            $table->json('categories')->nullable();
            $table->json('history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_coin_histories');
    }
};
