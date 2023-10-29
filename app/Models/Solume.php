<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solume extends Model
{
    protected $table = 'solume';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                   'change_24h',
                   'is_shown_ico',
                   'name',
                   'rank',
                   'reddit_change_24h',
                   'reddit_volume_24h',
                   'sentiment_24h',
                   'sentiment_change_24h',
                   'symbol',
                   'timestamp',
                   'twitter_change_24h',
                   'twitter_volume_24h',
                   'volume_24h'
        ];

}
