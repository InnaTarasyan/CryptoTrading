<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterAccount extends Model
{
    use HasFactory;

    protected $table = 'twitter_account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coin',
        'rel_coins',
        'account'
    ];
}
