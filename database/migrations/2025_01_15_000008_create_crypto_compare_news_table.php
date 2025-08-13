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
        Schema::create('crypto_compare_news', function (Blueprint $table) {
            $table->id();
            $table->string('news_id');
            $table->string('guid')->nullable();
            $table->dateTime('published_on');
            $table->string('imageurl')->nullable();
            $table->string('title');
            $table->string('url');
            $table->string('source');
            $table->text('body');
            $table->string('tags')->nullable();
            $table->string('categories')->nullable();
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->string('lang')->default('EN');
            $table->json('source_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_compare_news');
    }
}; 