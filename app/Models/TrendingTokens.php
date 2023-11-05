<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendingTokens extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'trending_tokens';
}
