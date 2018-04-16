<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coindar extends Model
{
    protected $table = 'coindar';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'caption',
        'proof',
        'caption_ru',
        'proof_ru',
        'public_date',
        'start_date',
        'end_date',
        'coin_name',
        'coin_symbol'
    ];
}
