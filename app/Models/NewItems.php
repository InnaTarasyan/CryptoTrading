<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewItems extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'new_items';
}
