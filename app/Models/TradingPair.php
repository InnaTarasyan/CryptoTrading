<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TradingPair extends Model
{
    protected $table = 'trading_pairs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'coin',
        'trading_pair'
    ];
}
