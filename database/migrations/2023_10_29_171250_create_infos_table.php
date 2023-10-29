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
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->json('urls');
            $table->string('logo');
            $table->integer('api_id');
            $table->string('name');
            $table->string('symbol');
            $table->string('slug');
            $table->string('description');
            $table->dateTime('date_added');
            $table->dateTime('date_launched');
            $table->json('tags');
            $table->string('platform')->nullable();
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
