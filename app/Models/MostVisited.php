<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MostVisited extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'most_visiteds';
}
