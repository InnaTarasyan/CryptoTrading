<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendingTopic extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'trending_topic';
}
