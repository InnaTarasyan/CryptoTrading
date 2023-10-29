<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorldCoinIndex extends Model
{
    protected $table = 'world_coin_index';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'Label',
        'Name',
        'Price_btc',
        'Price_usd',
        'Price_cny',
        'Price_eur',
        'Price_gbp',
        'Price_rur',
        'Volume_24h',
        'Timestamp'
    ];
}
