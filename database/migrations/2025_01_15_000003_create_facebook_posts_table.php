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
        Schema::create('facebook_posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_id')->unique(); // Facebook post ID
            $table->string('group_id'); // Reference to facebook_groups table
            $table->string('author_id'); // Reference to facebook_users table
            $table->text('message')->nullable(); // Post content/message
            $table->text('story')->nullable(); // Story text if different from message
            $table->string('type')->default('post'); // post, photo, video, link, etc.
            $table->json('attachments')->nullable(); // Photos, videos, links, etc.
            $table->integer('likes_count')->default(0); // Number of likes
            $table->integer('comments_count')->default(0); // Number of comments
            $table->integer('shares_count')->default(0); // Number of shares
            $table->json('reactions')->nullable(); // Detailed reaction counts
            $table->timestamp('posted_at'); // When the post was created
            $table->json('metadata')->nullable(); // Additional metadata
            $table->boolean('is_visible')->default(true); // Whether post is visible
            $table->timestamps();
            
            $table->index('post_id');
            $table->index('group_id');
            $table->index('author_id');
            $table->index('type');
            $table->index('posted_at');
            $table->index('is_visible');
            
            $table->foreign('group_id')->references('group_id')->on('facebook_groups')->onDelete('cascade');
            $table->foreign('author_id')->references('user_id')->on('facebook_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facebook_posts', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['author_id']);
        });

        Schema::dropIfExists('facebook_posts');
    }
}; 