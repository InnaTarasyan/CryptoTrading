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
        Schema::create('derivatives', function (Blueprint $table) {
            $table->id();
            $table->string('market');
            $table->string('symbol');
            $table->string('index_id');
            $table->double('price')->nullable();
            $table->double('price_percentage_change_24h')->nullable();
            $table->string('contract_type')->nullable();
            $table->double('index')->nullable();
            $table->double('basis')->nullable();
            $table->double('spread')->nullable();
            $table->double('funding_rate')->nullable();
            $table->double('open_interest')->nullable();
            $table->double('volume_24h')->nullable();
            $table->dateTime('last_traded_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('derivatives');
    }
};
