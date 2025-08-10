<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'is_read',
        'metadata',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'metadata' => 'array',
        'read_at' => 'datetime'
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Mark the notification as unread.
     */
    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null
        ]);
    }

    /**
     * Scope to get unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope to get notifications by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get the notification icon based on type.
     */
    public function getIconAttribute(): string
    {
        return match($this->type) {
            'price' => 'fas fa-chart-line',
            'portfolio' => 'fas fa-wallet',
            'security' => 'fas fa-shield-alt',
            'system' => 'fas fa-cog',
            default => 'fas fa-bell'
        };
    }

    /**
     * Get the notification color based on type.
     */
    public function getColorAttribute(): string
    {
        return match($this->type) {
            'price' => '#667eea',
            'portfolio' => '#28a745',
            'security' => '#dc3545',
            'system' => '#6c757d',
            default => '#007bff'
        };
    }
}
