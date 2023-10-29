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
        Schema::create('trending_latests', function (Blueprint $table) {
            $table->id();

            $table->string('api_id');
            $table->string('name');
            $table->string('symbol');
            $table->string('slug');
            $table->integer('cmc_rank');
            $table->boolean('is_active');
            $table->boolean('is_fiat');
            $table->string('self_reported_circulating_supply')->nullable();
            $table->string('self_reported_market_cap')->nullable();
            $table->integer('num_market_pairs');
            $table->integer('circulating_supply');
            $table->integer('total_supply');
            $table->integer('max_supply');
            $table->dateTime('last_updated');
            $table->dateTime('date_added');
            $table->json('tags');
            $table->string('platform')->nullable();
            $table->json('quote');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trending_latests');
    }
};
