<?php

namespace App\Models\CoinGecko;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DerivativesExchangesReview extends Model
{
    use HasFactory;
    protected $table = 'coingecko_derivatives_exchanges_reviews';
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
} 