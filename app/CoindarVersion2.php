<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoindarVersion2 extends Model
{
    protected $table = 'coindar2_coins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'symbol',
        'image_32',
        'image_64',
    ];
}
