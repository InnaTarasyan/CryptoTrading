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
        Schema::create('facebook_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_id')->unique(); // Facebook group ID
            $table->string('name'); // Group name
            $table->text('description')->nullable(); // Group description
            $table->string('privacy')->default('open'); // open, closed, secret
            $table->integer('member_count')->default(0); // Number of members
            $table->string('category')->nullable(); // Group category
            $table->string('cover_photo_url')->nullable(); // Cover photo URL
            $table->string('icon_url')->nullable(); // Group icon URL
            $table->json('tags')->nullable(); // Related tags/topics
            $table->boolean('is_active')->default(true); // Whether the group is active
            $table->timestamp('last_updated')->nullable(); // Last time we fetched data
            $table->timestamps();
            
            $table->index('group_id');
            $table->index('privacy');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_groups');
    }
}; 