<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'username',
        'profile_picture_url',
        'bio',
        'location',
        'is_verified',
        'followers_count',
        'following_count',
        'interests',
        'last_active'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'interests' => 'array',
        'last_active' => 'datetime'
    ];

    /**
     * Get the posts by this user
     */
    public function posts()
    {
        return $this->hasMany(FacebookPost::class, 'author_id', 'user_id');
    }

    /**
     * Get the comments by this user
     */
    public function comments()
    {
        return $this->hasMany(FacebookComment::class, 'author_id', 'user_id');
    }

    /**
     * Get the active posts by this user
     */
    public function activePosts()
    {
        return $this->posts()->where('is_visible', true);
    }

    /**
     * Scope to get only verified users
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope to search users by name or username
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('username', 'like', "%{$search}%")
              ->orWhere('bio', 'like', "%{$search}%");
        });
    }

    /**
     * Get the user's display name
     */
    public function getDisplayNameAttribute()
    {
        return $this->username ? "@{$this->username}" : $this->name;
    }
} 