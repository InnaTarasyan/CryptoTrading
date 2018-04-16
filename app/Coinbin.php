<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coinbin extends Model
{
    protected $table = 'coinbin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'btc',
        'name',
        'rank',
        'ticker',
        'usd'
    ];
}
