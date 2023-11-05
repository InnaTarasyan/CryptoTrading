<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeListingLatest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'exchange_listing_latest';
}