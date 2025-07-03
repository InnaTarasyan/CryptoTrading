<?php

namespace App\Models\LiveCoinWatch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangesReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'exchange_code',
        'name',
        'email',
        'rating',
        'title',
        'comment',
        'country',
        'experience_level',
        'pros',
        'cons',
        'recommend',
    ];

    protected $table = 'live_coin_exchanges_reviews';
} 