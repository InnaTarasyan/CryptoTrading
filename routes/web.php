<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** ===== Live Coin Watch ====== */

// live coin watch history
Route::get('/','LiveCoinWatch\HistoryController@index')->name('home');
Route::get('/getlivecoinhistory',
    ['as' => 'datatable.livecoin.history',
        'uses' => 'LiveCoinWatch\HistoryController@getData']);

// live coin watch exchanges
Route::get('/livecoinexchangesindex','LiveCoinWatch\ExchangesController@index');
Route::get('/getlivecoinexchanges',
    ['as' => 'datatable.livecoin.exchanges',
        'uses' => 'LiveCoinWatch\ExchangesController@getData']);

// live coin watch fiats
Route::get('/livecoinfiatsindex','LiveCoinWatch\FiatsController@index');
Route::get('/getlivecoinfiats',
    ['as' => 'datatable.livecoin.fiats',
        'uses' => 'LiveCoinWatch\FiatsController@getData']);

// Live Coin Watch History Reviews
Route::get('/livecoinwatch/history/reviews', [App\Http\Controllers\LiveCoinWatchHistoryReviewController::class, 'index']);
Route::post('/livecoinwatch/history/reviews', [App\Http\Controllers\LiveCoinWatchHistoryReviewController::class, 'store']);

// Live Coin Watch Exchanges Reviews
Route::get('/livecoinwatch/exchanges/reviews', [App\Http\Controllers\LiveCoinWatch\ExchangesReviewController::class, 'index']);
Route::post('/livecoinwatch/exchanges/reviews', [App\Http\Controllers\LiveCoinWatch\ExchangesReviewController::class, 'store']);

// Fiat Reviews
Route::get('/livecoinwatch/fiats/reviews', [App\Http\Controllers\LiveCoinWatch\FiatsReviewController::class, 'index']);
Route::post('/livecoinwatch/fiats/reviews', [App\Http\Controllers\LiveCoinWatch\FiatsReviewController::class, 'store']);

/** ===== Coin Gecko ====== */

// Coin Gecko Markets
Route::get('/coingeckomarketsindex', 'Coingecko\MarketsController@index');
Route::get('/getcoingeckodata',
    ['as' => 'datatable.coingecko.markets',
        'uses' => 'Coingecko\MarketsController@getData']);


// Coin Gecko Exchanges
Route::get('/coingeckoexchangesindex', 'Coingecko\ExchangesController@index');
Route::get('/getcoingeckoexchangesdata',
    ['as' => 'datatable.coingecko.exchanges',
        'uses' => 'Coingecko\ExchangesController@getData']);

// Coin Gecko Trendings
Route::get('/coingeckotrendingsindex', 'Coingecko\TrendingsController@index');
Route::get('/getcoingeckotrendingsdata',
    ['as' => 'datatable.coingecko.trendings',
        'uses' => 'Coingecko\TrendingsController@getData']);

// Coin Gecko Exchanges Rates
Route::get('/coingeckoexchangeratesindex', 'Coingecko\ExchangesRatesController@index');
Route::get('/getcoingeckoexchangeratesdata',
    ['as' => 'datatable.coingecko.exchange_rates',
        'uses' => 'Coingecko\ExchangesRatesController@getData']);


// Coin Gecko Nfts
Route::get('/coingeckonftsindex', 'Coingecko\NftsController@index');
Route::get('/getcoingeckonftsdata',
    ['as' => 'datatable.coingecko.nfts',
        'uses' => 'Coingecko\NftsController@getData']);


// Coin Gecko Derivatives
Route::get('/coingeckoderivativesindex', 'Coingecko\DerivativesController@index');
Route::get('/getcoingeckonderivativesdata',
    ['as' => 'datatable.coingecko.derivatives',
        'uses' => 'Coingecko\DerivativesController@getData']);


// Coin Gecko Derivatives Exchanges
Route::get('/coingeckoderivativesexchangesindex',
    'Coingecko\DerivativesExchangesController@index');
Route::get('/getcoingeckonderivativesexchangesdata',
    ['as' => 'datatable.coingecko.derivatives_exchanges',
        'uses' => 'Coingecko\DerivativesExchangesController@getData']);



/** ===== Coin Market Cal ====== */

Route::get('/coinmarketcalindex', 'CoinMarketCalController@index');
Route::get('/coinmarketcal',
    ['as' => 'datatable.coinmarketcal',
        'uses' => 'CoinMarketCalController@getCoinMarketCalData']);


/** ===== Coin Details ====== */

Route::get('/details/{coin}', 'DetailsController@index');



/** ===== Telegram ====== */

Route::get('/telegram', ['as' => 'telegram', 'uses' => 'TelegramController@index']);
Route::resource('telegram', 'TelegramController');
Route::get('/gettelegram', ['as' => 'datatable.gettelegram','uses' => 'TelegramController@getMessages']);


/** ===== Trading Pairs ====== */

Route::get('/tradingPairs', ['as' => 'tradingPairs', 'uses' => 'TradingPairsController@index']);
Route::resource('tradingPairs', 'TradingPairsController');
Route::get('/gettradingPairs', ['as' => 'datatable.gettradingPairs','uses' => 'TradingPairsController@getTradingPairsData']);


/** ===== Profile ====== */

Route::match(['get', 'post'], '/about', ['uses' => 'HomeController@about', 'as' => 'about']);
Route::match(['get', 'post'], '/profile', ['uses' => 'ProfileController@index', 'as' => 'profile']);


Route::get('/ajaxGetCoins', [
    'as'   => 'ajaxGetCoins',
    'uses' => 'TradingPairsController@ajaxGetCoins'
]);

Route::get('/reloadData', 'HomeController@reloadData');

// Coin Gecko Markets Reviews
Route::get('/coingecko/markets/reviews', [App\Http\Controllers\Coingecko\MarketsCoingeckoReviewController::class, 'index']);
Route::post('/coingecko/markets/reviews', [App\Http\Controllers\Coingecko\MarketsCoingeckoReviewController::class, 'store']);

// Coin Gecko Exchanges Reviews
Route::get('/coingecko/exchanges/reviews', [\App\Http\Controllers\Coingecko\CoingeckoExchangesReviewController::class, 'index']);
Route::post('/coingecko/exchanges/reviews', [\App\Http\Controllers\Coingecko\CoingeckoExchangesReviewController::class, 'store']);

// Coin Gecko Trendings Reviews
Route::get('/coingecko/trendings/reviews', [\App\Http\Controllers\Coingecko\CoinGeckoTrendingsReviewController::class, 'index']);
Route::post('/coingecko/trendings/reviews', [\App\Http\Controllers\Coingecko\CoinGeckoTrendingsReviewController::class, 'store']);

// Coin Gecko Exchanges Rates Reviews
Route::get('/coingecko/exchanges_rates/reviews', [\App\Http\Controllers\Coingecko\ExchangesRatesReviewsController::class, 'index']);
Route::post('/coingecko/exchanges_rates/reviews', [\App\Http\Controllers\Coingecko\ExchangesRatesReviewsController::class, 'store']);
Route::get('/coingecko/exchanges_rates/reviews/list', [\App\Http\Controllers\Coingecko\ExchangesRatesReviewsController::class, 'listJson']);

// Coin Gecko Derivatives Exchanges Reviews
Route::get('/coingecko/derivatives_exchanges/reviews', [\App\Http\Controllers\Coingecko\DerivativesExchangesController::class, 'reviewsList']);
Route::post('/coingecko/derivatives_exchanges/reviews', [\App\Http\Controllers\Coingecko\DerivativesExchangesController::class, 'storeReview']);

// Privacy Policy Page
Route::view('/privacy-policy', 'privacy-policy');