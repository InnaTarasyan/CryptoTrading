<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolumeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solume', function (Blueprint $table) {
            $table->increments('id');
            $table->double('change_24h');
            $table->boolean('is_shown_ico');
            $table->string('name');
            $table->integer('rank');
            $table->double('reddit_change_24h');
            $table->double('reddit_volume_24h');
            $table->double('sentiment_24h');
            $table->double('sentiment_change_24h');
            $table->string('symbol');
            $table->double('timestamp');
            $table->double('twitter_change_24h');
            $table->double('twitter_volume_24h');
            $table->double('volume_24h');
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
        Schema::dropIfExists('solume');
    }
}
