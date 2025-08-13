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
        Schema::create('crypto_compare_exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('internal_name');
            $table->string('url')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('affiliate_url')->nullable();
            $table->string('country')->nullable();
            $table->boolean('centralized')->default(false);
            $table->text('internal_note')->nullable();
            $table->string('item_type')->nullable();
            $table->string('grade')->nullable();
            $table->integer('grade_points')->nullable();
            $table->json('grade_points_split')->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('sponsored')->default(false);
            $table->boolean('recommended')->default(false);
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->string('collection')->nullable();
            $table->dateTime('data_start')->nullable();
            $table->dateTime('data_end')->nullable();
            $table->dateTime('data_quote_start')->nullable();
            $table->dateTime('data_quote_end')->nullable();
            $table->dateTime('data_orderbook_start')->nullable();
            $table->dateTime('data_orderbook_end')->nullable();
            $table->dateTime('data_trade_start')->nullable();
            $table->dateTime('data_trade_end')->nullable();
            $table->integer('data_symbols_count')->nullable();
            $table->decimal('volume_1hrs_usd', 20, 8)->nullable();
            $table->decimal('volume_1day_usd', 20, 8)->nullable();
            $table->decimal('volume_1mth_usd', 20, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_compare_exchanges');
    }
}; 