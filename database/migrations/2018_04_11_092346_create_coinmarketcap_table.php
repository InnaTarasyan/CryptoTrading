<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinmarketcapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coinmarketcap', function (Blueprint $table) {
            $table->increments('id');
            $table->string('native_id');
            $table->string('name');
            $table->string('symbol');
            $table->integer('rank');
            $table->double('price_usd')->nullable();
            $table->double('price_btc')->nullable();
            $table->double('24h_volume_usd')->nullable();
            $table->double('market_cap_usd')->nullable();
            $table->double('available_supply')->nullable();
            $table->double('total_supply')->nullable();
            $table->double('max_supply')->nullable();
            $table->float('percent_change_1h')->nullable();
            $table->float('percent_change_24h')->nullable();
            $table->float('percent_change_7d')->nullable();
            $table->string('last_updated')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coinmarketcap');
    }
}
