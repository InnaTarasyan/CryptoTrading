<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coingecko_derivatives_exchanges_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('exchange_code');
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

    public function down(): void
    {
        Schema::dropIfExists('coingecko_derivatives_exchanges_reviews');
    }
}; 