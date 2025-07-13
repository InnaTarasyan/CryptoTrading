<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('coingecko_exchanges_rates_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('user_email');
            $table->unsignedTinyInteger('rating');
            $table->string('review_title');
            $table->text('review_body');
            $table->string('exchange_symbol')->nullable();
            $table->string('exchange_name')->nullable();
            $table->string('country')->nullable();
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();
            $table->boolean('would_recommend')->default(false);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('coingecko_exchanges_rates_reviews');
    }
}; 