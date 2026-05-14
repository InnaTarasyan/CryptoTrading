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
        Schema::create('facebook_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique(); // Facebook user ID
            $table->string('name'); // User's display name
            $table->string('username')->nullable(); // Username if available
            $table->string('profile_picture_url')->nullable(); // Profile picture URL
            $table->text('bio')->nullable(); // User bio/description
            $table->string('location')->nullable(); // User location
            $table->boolean('is_verified')->default(false); // Whether user is verified
            $table->integer('followers_count')->default(0); // Number of followers
            $table->integer('following_count')->default(0); // Number of people following
            $table->json('interests')->nullable(); // User interests/topics
            $table->timestamp('last_active')->nullable(); // Last time user was active
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('username');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_users');
    }
}; 