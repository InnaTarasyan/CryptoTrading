<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'username', 'phone', 'bio',
        'email_notifications', 'country', 'timezone', 'twitter', 'linkedin', 'github', 'website',
        'profile_public', 'show_email', 'show_location', 'show_social', 'password_changed_at',
        'notification_preferences'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_changed_at' => 'datetime',
        'last_login_at' => 'datetime',
        'profile_public' => 'boolean',
        'show_email' => 'boolean',
        'show_location' => 'boolean',
        'show_social' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'notification_preferences' => 'array',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if ($this->first_name && $this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        }
        
        return $this->name;
    }

    /**
     * Get the user's display name.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->username ?: $this->full_name;
    }

    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }

    /**
     * Get the user's notifications.
     */
    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    /**
     * Get the user's unread notifications count.
     */
    public function getUnreadNotificationsCountAttribute()
    {
        return $this->notifications()->unread()->count();
    }
}
