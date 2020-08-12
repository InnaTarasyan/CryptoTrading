<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoindarUpgradedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coindar2_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('caption')->nullable();
            $table->string('source')->nullable();
            $table->integer('source_reliable')->nullable();
            $table->integer('important')->nullable();
            $table->dateTime('date_public')->nullable();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->integer('coin_id')->nullable();
            $table->double('coin_price_changes')->nullable();
            $table->integer('tags')->nullable();
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
        Schema::dropIfExists('coindar2_events');
    }
}
