<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\CoinGeckoApiController;
use App\Http\Controllers\Api\CoinMarketCalApiController;
use App\Http\Controllers\Api\LiveCoinWatchApiController;
use App\Http\Controllers\Api\TelegramApiController;
use App\Http\Controllers\Api\TwitterApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// CoinGecko API Routes
Route::prefix('coingecko')->group(function () {
    Route::get('/exchanges', [CoinGeckoApiController::class, 'exchanges'])->middleware('api.key:coingecko_exchanges');
    Route::get('/coins', [CoinGeckoApiController::class, 'coins'])->middleware('api.key:coin_gecko_coins');
    Route::get('/exchange-rates', [CoinGeckoApiController::class, 'exchangeRates'])->middleware('api.key:coin_gecko_exchange_rates');
    Route::get('/markets', [CoinGeckoApiController::class, 'markets'])->middleware('api.key:coin_gecko_markets');
    Route::get('/trendings', [CoinGeckoApiController::class, 'trendings'])->middleware('api.key:coin_gecko_trendings');
    Route::get('/derivatives', [CoinGeckoApiController::class, 'derivatives'])->middleware('api.key:derivatives');
    Route::get('/derivatives-exchanges', [CoinGeckoApiController::class, 'derivativesExchanges'])->middleware('api.key:derivatives_exchanges');
    Route::get('/nfts', [CoinGeckoApiController::class, 'nfts'])->middleware('api.key:nfts');
});

// CoinMarketCal API Routes
Route::prefix('coinmarketcal')->group(function () {
    Route::get('/coinmarketcals', [CoinMarketCalApiController::class, 'coinmarketcals'])->middleware('api.key:coinmarketcals');
    Route::get('/events', [CoinMarketCalApiController::class, 'events'])->middleware('api.key:events');
});

// LiveCoinWatch API Routes
Route::prefix('livecoinwatch')->group(function () {
    Route::get('/fiats', [LiveCoinWatchApiController::class, 'fiats'])->middleware('api.key:fiats');
    Route::get('/live-coin-histories', [LiveCoinWatchApiController::class, 'liveCoinHistories'])->middleware('api.key:live_coin_histories');
    Route::get('/live-coin-watches', [LiveCoinWatchApiController::class, 'liveCoinWatches'])->middleware('api.key:live_coin_watches');
});

// Telegram API Routes
Route::prefix('telegram')->group(function () {
    Route::get('/messages', [TelegramApiController::class, 'telegramMessages'])->middleware('api.key:telegram_messages');
});

// Twitter API Routes
Route::prefix('twitter')->group(function () {
    Route::get('/messages', [TwitterApiController::class, 'twitterMessages'])->middleware('api.key:twitter_messages');
});
