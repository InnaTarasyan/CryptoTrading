<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterMessages extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function author()
    {
        return $this->belongsTo(TwitterUsers::class, 'author_id', 'user_id');
    }
}
