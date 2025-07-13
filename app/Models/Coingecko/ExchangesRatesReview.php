<?php
namespace App\Models\Coingecko;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangesRatesReview extends Model
{
    use HasFactory;
    protected $table = 'coingecko_exchanges_rates_reviews';
    protected $fillable = [
        'user_name',
        'user_email',
        'rating',
        'review_title',
        'review_body',
        'exchange_symbol',
        'exchange_name',
        'country',
        'pros',
        'cons',
        'would_recommend',
    ];
} 