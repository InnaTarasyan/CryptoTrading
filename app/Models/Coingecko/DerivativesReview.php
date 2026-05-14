<?php

namespace App\Models\Coingecko;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DerivativesReview extends Model
{
    use HasFactory;
    protected $table = 'coingecko_derivatives_reviews';
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
} 