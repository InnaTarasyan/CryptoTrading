<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoindarVersion2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coindar2_coins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('symbol')->nullable();
            $table->string('image_32')->nullable();
            $table->string('image_64')->nullable();
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
        Schema::dropIfExists('coindar2_coins');
    }
}
