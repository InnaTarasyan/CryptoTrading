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
        Schema::create('live_coin_fiats_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('fiat_code');
            $table->string('name');
            $table->string('email');
            $table->tinyInteger('rating')->unsigned(); // 1-5
            $table->string('title');
            $table->text('comment');
            $table->string('country')->nullable();
            $table->string('experience_level')->nullable();
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();
            $table->boolean('recommend')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_coin_fiats_reviews');
    }
}; 