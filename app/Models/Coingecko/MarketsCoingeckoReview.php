<?php

namespace App\Models\Coingecko;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketsCoingeckoReview extends Model
{
    use HasFactory;

    protected $fillable = [
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

    protected $table = 'markets_coingecko_reviews';
} 