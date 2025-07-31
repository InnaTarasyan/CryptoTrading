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
        Schema::create('twitter_meta', function (Blueprint $table) {
            $table->id();
            $table->integer('result_count');
            $table->string('newest_id')->nullable();
            $table->string('oldest_id')->nullable();

            $table->foreign('newest_id')
                ->references('tweet_id') // Referenced column
                ->on('twitter_messages') // Referenced table
                ->onDelete('cascade');

            $table->foreign('oldest_id')
                ->references('tweet_id') // Referenced column
                ->on('twitter_messages') // Referenced table
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('twitter_meta', function (Blueprint $table) {
            $table->dropForeign(['newest_id', 'oldest_id']);
        });

        Schema::dropIfExists('twitter_meta');
    }
};
