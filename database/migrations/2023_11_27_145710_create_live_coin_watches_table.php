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
        Schema::create('live_coin_watches', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->float('rate')->nullable();
            $table->bigInteger('volume')->nullable();
            $table->bigInteger('cap')->nullable();
            $table->json('delta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_coin_watches');
    }
};
