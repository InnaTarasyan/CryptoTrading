<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'post_id',
        'author_id',
        'message',
        'parent_comment_id',
        'likes_count',
        'reactions',
        'commented_at',
        'updated_at',
        'metadata',
        'is_visible'
    ];

    protected $casts = [
        'reactions' => 'array',
        'metadata' => 'array',
        'commented_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_visible' => 'boolean'
    ];

    /**
     * Get the post this comment belongs to
     */
    public function post()
    {
        return $this->belongsTo(FacebookPost::class, 'post_id', 'post_id');
    }

    /**
     * Get the author of this comment
     */
    public function author()
    {
        return $this->belongsTo(FacebookUser::class, 'author_id', 'user_id');
    }

    /**
     * Get the parent comment (for replies)
     */
    public function parentComment()
    {
        return $this->belongsTo(FacebookComment::class, 'parent_comment_id', 'comment_id');
    }

    /**
     * Get the replies to this comment
     */
    public function replies()
    {
        return $this->hasMany(FacebookComment::class, 'parent_comment_id', 'comment_id');
    }

    /**
     * Scope to get only visible comments
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope to get only top-level comments (not replies)
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_comment_id');
    }

    /**
     * Scope to get only reply comments
     */
    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_comment_id');
    }

    /**
     * Scope to search comments by content
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('message', 'like', "%{$search}%");
    }

    /**
     * Scope to get comments by specific authors
     */
    public function scopeByAuthors($query, $authorIds)
    {
        return $query->whereIn('author_id', $authorIds);
    }

    /**
     * Scope to get comments within a date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('commented_at', [$startDate, $endDate]);
    }

    /**
     * Check if this comment is a reply
     */
    public function isReply()
    {
        return !is_null($this->parent_comment_id);
    }

    /**
     * Check if this comment has replies
     */
    public function hasReplies()
    {
        return $this->replies()->count() > 0;
    }

    /**
     * Get the comment depth (how many levels deep it is)
     */
    public function getDepthAttribute()
    {
        $depth = 0;
        $comment = $this;
        
        while ($comment->parentComment) {
            $depth++;
            $comment = $comment->parentComment;
        }
        
        return $depth;
    }
} 