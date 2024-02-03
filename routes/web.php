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
Route::get('/','LiveCoinWatch\HistoryController@index');
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



/** ===== Twitter ====== */

Route::get('/twitter', ['as' => 'twitter', 'uses' => 'TwitterController@index']);
Route::resource('twitter', 'TwitterController');
Route::get('/gettwitter', ['as' => 'datatable.gettwitter','uses' => 'TwitterController@getTweets']);


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