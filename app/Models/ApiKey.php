<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'key',
        'permissions',
        'is_active',
        'last_used_at'
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
        'last_used_at' => 'datetime'
    ];

    protected $hidden = [
        'key'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateKey()
    {
        return hash('sha256', Str::random(40) . time());
    }

    public function hasPermission($permission)
    {
        if (!$this->is_active) {
            return false;
        }

        if (empty($this->permissions)) {
            return false;
        }

        return in_array($permission, $this->permissions);
    }

    public function updateLastUsed()
    {
        $this->update(['last_used_at' => now()]);
    }

    public static function getAvailablePermissions()
    {
        return [
            // CoinGecko
            'coingecko_exchanges',
            'coin_gecko_coins',
            'coin_gecko_exchange_rates',
            'coin_gecko_markets',
            'coin_gecko_trendings',
            'derivatives',
            'derivatives_exchanges',
            'nfts',
            
            // CoinMarketCal
            'coinmarketcals',
            'events',
            
            // LiveCoinWatch
            'fiats',
            'live_coin_histories',
            'live_coin_watches',
            
            // CryptoCompare
            'cryptocompare_markets',
            'cryptocompare_news',
            'cryptocompare_coins',
            'cryptocompare_exchanges',
            'cryptocompare_top_pairs',
            
            // Telegram
            'telegram_messages',
            
            // Twitter
            'twitter_messages'
        ];
    }
}
