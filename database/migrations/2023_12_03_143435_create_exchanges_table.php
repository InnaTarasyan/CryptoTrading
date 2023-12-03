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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('png64');
            $table->string('png128');
            $table->string('webp64');
            $table->string('webp128');
            $table->boolean('centralized');
            $table->boolean('usCompliant')->nullable();
            $table->string('code');
            $table->integer('markets');
            $table->bigInteger('volume');
            $table->double('bidTotal')->nullable();
            $table->double('askTotal')->nullable();
            $table->double('depth');
            $table->integer('visitors');
            $table->double('volumePerVisitor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
