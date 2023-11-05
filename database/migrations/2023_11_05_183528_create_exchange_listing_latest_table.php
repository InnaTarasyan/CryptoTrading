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
        Schema::create('exchange_listing_latest', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('name');
            $table->string('slug');
            $table->json('fiats');
            $table->integer('traffic_score');
            $table->integer('rank');
            $table->double('exchange_score');
            $table->double('liquidity_score');
            $table->dateTime('last_updated');
            $table->json('quote');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_listing_latest');
    }
};
