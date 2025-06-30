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
        Schema::create('coinmarketcals', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('name');
            $table->integer('rank');
            $table->integer('hot_index')->nullable();
            $table->integer('trending_index')->nullable();
            $table->integer('significant_index')->nullable();
            $table->integer('upcoming')->nullable();
            $table->string('symbol');
            $table->string('fullname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coinmarketcals');
    }
};
