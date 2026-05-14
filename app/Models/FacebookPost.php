<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'group_id',
        'author_id',
        'message',
        'story',
        'type',
        'attachments',
        'likes_count',
        'comments_count',
        'shares_count',
        'reactions',
        'posted_at',
        'updated_at',
        'metadata',
        'is_visible'
    ];

    protected $casts = [
        'attachments' => 'array',
        'reactions' => 'array',
        'metadata' => 'array',
        'posted_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_visible' => 'boolean'
    ];

    /**
     * Get the group this post belongs to
     */
    public function group()
    {
        return $this->belongsTo(FacebookGroup::class, 'group_id', 'group_id');
    }

    /**
     * Get the author of this post
     */
    public function author()
    {
        return $this->belongsTo(FacebookUser::class, 'author_id', 'user_id');
    }

    /**
     * Get the comments on this post
     */
    public function comments()
    {
        return $this->hasMany(FacebookComment::class, 'post_id', 'post_id');
    }

    /**
     * Get the top-level comments (not replies)
     */
    public function topLevelComments()
    {
        return $this->comments()->whereNull('parent_comment_id');
    }

    /**
     * Scope to get only visible posts
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope to get posts by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to search posts by content
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('message', 'like', "%{$search}%")
              ->orWhere('story', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to get posts from specific groups
     */
    public function scopeFromGroups($query, $groupIds)
    {
        return $query->whereIn('group_id', $groupIds);
    }

    /**
     * Scope to get posts by specific authors
     */
    public function scopeByAuthors($query, $authorIds)
    {
        return $query->whereIn('author_id', $authorIds);
    }

    /**
     * Scope to get posts within a date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('posted_at', [$startDate, $endDate]);
    }

    /**
     * Get the total engagement (likes + comments + shares)
     */
    public function getTotalEngagementAttribute()
    {
        return $this->likes_count + $this->comments_count + $this->shares_count;
    }

    /**
     * Check if post has attachments
     */
    public function hasAttachments()
    {
        return !empty($this->attachments);
    }

    /**
     * Get the first attachment URL
     */
    public function getFirstAttachmentUrlAttribute()
    {
        if ($this->hasAttachments() && isset($this->attachments[0]['url'])) {
            return $this->attachments[0]['url'];
        }
        return null;
    }
} 