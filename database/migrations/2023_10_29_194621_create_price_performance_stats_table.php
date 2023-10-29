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
        Schema::create('price_performance_stats', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('name');
            $table->string('symbol');
            $table->string('slug');
            $table->dateTime('last_updated');
            $table->json('periods');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_performance_stats');
    }
};
