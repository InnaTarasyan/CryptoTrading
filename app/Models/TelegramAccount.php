<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramAccount extends Model
{
    protected $table = 'telegram_account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'coin',
            'rel_coins',
            'account',
            'processed',
    ];

    protected $casts = [
        'rel_coins' => 'array',
    ];
}
