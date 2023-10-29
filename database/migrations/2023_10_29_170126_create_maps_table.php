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
        Schema::create('maps', function (Blueprint $table) {
            $table->id();
            $table->integer('api_id');
            $table->integer('rank');
            $table->string('name');
            $table->string('symbol');
            $table->string('slug');
            $table->boolean('is_active');
            $table->dateTime('first_historical_data');
            $table->dateTime('last_historical_data');
            $table->json('platform')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maps');
    }
};
