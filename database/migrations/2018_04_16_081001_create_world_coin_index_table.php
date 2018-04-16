<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorldCoinIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('world_coin_index', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Label')->nullable();
            $table->string('Name')->nullable();
            $table->double('Price_btc')->nullable();
            $table->double('Price_usd')->nullable();
            $table->double('Price_cny')->nullable();
            $table->double('Price_eur')->nullable();
            $table->double('Price_gbp')->nullable();
            $table->double('Price_rur')->nullable();
            $table->double('Volume_24h')->nullable();
            $table->double('Timestamp')->nullable();
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
        Schema::dropIfExists('world_coin_index');
    }
}
