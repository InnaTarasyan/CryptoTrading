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
        Schema::create('ohlcv_latests', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('name');
            $table->string('symbol');
            $table->dateTime('last_updated');
            $table->dateTime('time_open');
            $table->dateTime('time_close');
            $table->dateTime('time_high');
            $table->dateTime('time_low');
            $table->json('quote');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ohlcv_latests');
    }
};
