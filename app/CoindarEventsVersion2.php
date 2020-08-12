<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoindarEventsVersion2 extends Model
{
    protected $table = 'coindar2_events';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "caption",
        "source",
        "source_reliable",
        "important",
        "date_public",
        "date_start",
        "date_end",
        "coin_id",
        "coin_price_changes",
        "tags",
    ];
}
