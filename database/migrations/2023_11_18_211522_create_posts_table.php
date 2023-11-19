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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_id');
            $table->string('comments_url');
            $table->json('owner');
            $table->string('text_content');
            $table->json('photos');
            $table->string('comment_count');
            $table->string('like_count');
            $table->string('post_time');
            $table->json('currencies');
            $table->string('language_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
