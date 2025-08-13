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
        Schema::create('crypto_compare_top_pairs', function (Blueprint $table) {
            $table->id();
            $table->string('exchange');
            $table->string('from_symbol');
            $table->string('to_symbol');
            $table->decimal('volume_24h', 20, 8)->nullable();
            $table->decimal('volume_24h_to', 20, 8)->nullable();
            $table->decimal('open_24h', 20, 8)->nullable();
            $table->decimal('high_24h', 20, 8)->nullable();
            $table->decimal('low_24h', 20, 8)->nullable();
            $table->decimal('change_24h', 20, 8)->nullable();
            $table->decimal('change_pct_24h', 10, 4)->nullable();
            $table->string('from_display_name')->nullable();
            $table->string('to_display_name')->nullable();
            $table->string('flags')->nullable();
            $table->dateTime('last_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_compare_top_pairs');
    }
}; 