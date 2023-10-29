<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coinmarketcap extends Model
{
    protected $table = 'coinmarketcap';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'native_id',
       'name',
       'symbol',
       'rank',
       'price_usd',
       'price_btc',
       '24h_volume_usd',
       'market_cap_usd',
       'available_supply',
       'total_supply',
       'max_supply',
       'percent_change_1h',
       'percent_change_24h',
       'percent_change_7d',
       'last_updated'
    ];
}
