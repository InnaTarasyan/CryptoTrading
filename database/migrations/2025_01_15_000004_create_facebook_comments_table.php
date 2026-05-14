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
        Schema::create('facebook_comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment_id')->unique(); // Facebook comment ID
            $table->string('post_id'); // Reference to facebook_posts table
            $table->string('author_id'); // Reference to facebook_users table
            $table->text('message'); // Comment content
            $table->string('parent_comment_id')->nullable(); // For replies to comments
            $table->integer('likes_count')->default(0); // Number of likes on comment
            $table->json('reactions')->nullable(); // Detailed reaction counts
            $table->timestamp('commented_at'); // When the comment was created
            $table->json('metadata')->nullable(); // Additional metadata
            $table->boolean('is_visible')->default(true); // Whether comment is visible
            $table->timestamps();
            
            $table->index('comment_id');
            $table->index('post_id');
            $table->index('author_id');
            $table->index('parent_comment_id');
            $table->index('commented_at');
            $table->index('is_visible');
            
            $table->foreign('post_id')->references('post_id')->on('facebook_posts')->onDelete('cascade');
            $table->foreign('author_id')->references('user_id')->on('facebook_users')->onDelete('cascade');
            $table->foreign('parent_comment_id')->references('comment_id')->on('facebook_comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facebook_comments', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropForeign(['author_id']);
            $table->dropForeign(['parent_comment_id']);
        });

        Schema::dropIfExists('facebook_comments');
    }
}; 