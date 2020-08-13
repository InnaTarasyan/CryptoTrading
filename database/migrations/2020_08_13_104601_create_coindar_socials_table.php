<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoindarSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coindar_socials', function (Blueprint $table) {
             $table->increments('id');
             $table->integer("coin_id")->nullable();
             $table->string("website")->nullable();
             $table->string("bitcointalk")->nullable();
             $table->string("twitter")->nullable();
             $table->string("reddit")->nullable();
             $table->string("telegram")->nullable();
             $table->string("facebook")->nullable();
             $table->string("github")->nullable();
             $table->string("explorer")->nullable();
             $table->string("youtube")->nullable();
             $table->integer("twitter_count")->nullable();
             $table->integer("reddit_count")->nullable();
             $table->integer("telegram_count")->nullable();
             $table->integer("facebook_count")->nullable();
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
        Schema::dropIfExists('coindar_socials');
    }
}
