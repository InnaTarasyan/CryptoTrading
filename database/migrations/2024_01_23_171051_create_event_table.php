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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->json('title');
            $table->json('coins');
            $table->dateTime('date_event');
            $table->string('displayed_date');
            $table->boolean('can_occur_before')->default(false);
            $table->dateTime('created_date');
            $table->json('categories');
            $table->string('proof');
            $table->string('source');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
