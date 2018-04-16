<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoindarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coindar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('caption');
            $table->string('proof');
            $table->string('caption_ru');
            $table->string('proof_ru');
            $table->string('public_date');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('coin_name');
            $table->string('coin_symbol');
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
        Schema::dropIfExists('coindar');
    }
}
