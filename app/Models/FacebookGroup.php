<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'description',
        'privacy',
        'member_count',
        'category',
        'cover_photo_url',
        'icon_url',
        'tags',
        'is_active',
        'last_updated'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'last_updated' => 'datetime'
    ];

    /**
     * Get the posts for this group
     */
    public function posts()
    {
        return $this->hasMany(FacebookPost::class, 'group_id', 'group_id');
    }

    /**
     * Get the active posts for this group
     */
    public function activePosts()
    {
        return $this->posts()->where('is_visible', true);
    }

    /**
     * Scope to get only open groups
     */
    public function scopeOpen($query)
    {
        return $query->where('privacy', 'open');
    }

    /**
     * Scope to get only active groups
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to search groups by name or description
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhereJsonContains('tags', $search);
        });
    }
} 