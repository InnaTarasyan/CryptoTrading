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
        Schema::create('airdrops', function (Blueprint $table) {
            $table->string('api_id');
            $table->string('project_name');
            $table->string('description');
            $table->string('status');
            $table->json('coin');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->double('total_prize');
            $table->integer('winner_count');
            $table->string('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airdrops');
    }
};
