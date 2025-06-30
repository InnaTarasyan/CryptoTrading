<?php

namespace App\Models\CoinMarketCal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinMarketCalEvents extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'events';
}
