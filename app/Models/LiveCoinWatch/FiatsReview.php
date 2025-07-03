<?php

namespace App\Models\LiveCoinWatch;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiatsReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'fiat_code',
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

    protected $table = 'live_coin_fiats_reviews';
} 