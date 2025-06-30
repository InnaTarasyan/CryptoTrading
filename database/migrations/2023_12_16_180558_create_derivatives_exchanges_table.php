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
        Schema::create('derivatives_exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('api_id');
            $table->double('open_interest_btc')->nullable();
            $table->double('trade_volume_24h_btc')->nullable();
            $table->integer('number_of_perpetual_pairs')->nullable();
            $table->integer('number_of_futures_pairs')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('year_established')->nullable();
            $table->string('country')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('derivatives_exchanges');
    }
};
