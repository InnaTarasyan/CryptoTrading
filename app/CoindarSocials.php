<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoindarSocials extends Model
{
    protected $table = 'coindar_socials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "coin_id",
        "website",
        "bitcointalk",
        "twitter",
        "reddit",
        "telegram",
        "facebook",
        "github",
        "explorer",
        "youtube",
        "twitter_count",
        "reddit_count",
        "telegram_count",
        "facebook_count",
    ];
}
