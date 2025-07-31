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
        Schema::create('twitter_messages', function (Blueprint $table) {
            $table->id();
            $table->string('tweet_id');
            $table->json('edit_history_tweet_ids')->nullable();
            $table->text('text')->nullable();
            $table->string('author_id')->nullable();
            $table->foreign('author_id')
                ->references('user_id') // Referenced column
                ->on('twitter_users') // Referenced table
                ->onDelete('cascade');

            $table->index('tweet_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('twitter_messages', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
        });

        Schema::dropIfExists('twitter_messages');
    }
};
