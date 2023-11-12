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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('name');
            $table->string('title');
            $table->string('description');
            $table->integer('num_tokens');
            $table->double('avg_price_change');
            $table->double('market_cap');
            $table->double('market_cap_change');
            $table->double('volume');
            $table->double('volume_change');
            $table->integer('last_updated');
            $table->json('coins')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
