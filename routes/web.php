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

Route::get('/solume', 'SolumeController@index');
Route::get('/coinbin', 'CoinbinController@index');
Route::get('/worldcoinindex','WorldCoinIndexController@index');
Route::get('/','LiveCoinController@index');
Route::get('/exchangesindex','ExchangesController@index');
Route::get('/fiatsindex','FiatsController@index');
Route::get('/coingeckoindex', 'CoingeckoController@index');
Route::get('/coingeckoexchangesindex', 'CoingeckoController@indexExchanges');
Route::get('/coingeckotrendingsindex', 'CoingeckoController@indexTrendings');
Route::get('/coingeckoexchangeratesindex', 'CoingeckoController@indexRates');
Route::get('/coingeckonftsindex', 'CoingeckoController@indexNfts');
Route::get('/coingeckoderivativesindex', 'CoingeckoController@indexDerivatives');
Route::get('/coingeckoderivativesexchangesindex', 'CoingeckoController@indexDerivativesExchanges');
Route::get('/coingeckocategoriesindex', 'CoingeckoController@indexCategories');
Route::get('/livecoinplatformsindex', 'LiveCoinController@platforms');
Route::get('/coinmarketcalindex', 'CoinMarketCalController@index');

Route::get('/getcoinmarketcap', ['as' => 'datatable.getcoinmarketcap','uses' => 'HomeController@getCoinmarketcapData']);
Route::get('/getsolume', ['as' => 'datatable.getsolume','uses' => 'SolumeController@getSolumeData']);
Route::get('/getcoinbin', ['as' => 'datatable.getcoinbin','uses' => 'CoinbinController@getCoinbinData']);
Route::get('/getworldcoinindex', ['as' => 'datatable.getworldcoinindex','uses' => 'WorldCoinIndexController@getWorldCoinIndexData']);
Route::get('/getlivecoin', ['as' => 'datatable.getlivecoin','uses' => 'LiveCoinController@getLiveCoinData']);
Route::get('/exchanges', ['as' => 'datatable.exchanges','uses' => 'ExchangesController@getExchangesData']);
Route::get('/fiats', ['as' => 'datatable.fiats','uses' => 'FiatsController@getFiatsData']);
Route::get('/livecoinplatforms', ['as' => 'datatable.getlivecoinplatforms','uses' => 'LiveCoinController@getLiveCoinPlatformData']);

Route::get('/coingecko', ['as' => 'datatable.coingecko','uses' => 'CoingeckoController@getCoingeckoData']);
Route::get('/coingeckoexchanges', ['as' => 'datatable.coingecko_exchanges','uses' => 'CoingeckoController@getCoingeckoExchangesData']);
Route::get('/coingeckotrendings', ['as' => 'datatable.coingecko_trendings','uses' => 'CoingeckoController@getCoingeckoTrendingsData']);
Route::get('/coingeckoexchangerates', ['as' => 'datatable.coingecko_exchange_rates','uses' => 'CoingeckoController@getCoingeckoExchangeRatesData']);
Route::get('/coingeckonfts', ['as' => 'datatable.coingecko_nfts','uses' => 'CoingeckoController@getCoingeckoNftsData']);
Route::get('/coingeckonderivatives', ['as' => 'datatable.coingecko_derivatives','uses' => 'CoingeckoController@getDerivativesData']);
Route::get('/coingeckonderivativesexchanges', ['as' => 'datatable.coingecko_derivatives_exchanges','uses' => 'CoingeckoController@getDerivativesExchangesData']);
Route::get('/coingeckocategories', ['as' => 'datatable.coingecko_categories','uses' => 'CoingeckoController@getCategoriesData']);


Route::get('/coinmarketcal', ['as' => 'datatable.coinmarketcal','uses' => 'CoinMarketCalController@getCoinMarketCalData']);


Route::get('/details/{coin}', 'DetailsController@index');

Route::get('/twitter', ['as' => 'twitter', 'uses' => 'TwitterController@index']);
Route::resource('twitter', 'TwitterController');
Route::get('/gettwitter', ['as' => 'datatable.gettwitter','uses' => 'TwitterController@getTweets']);

Route::get('/tradingPairs', ['as' => 'tradingPairs', 'uses' => 'TradingPairsController@index']);
Route::resource('tradingPairs', 'TradingPairsController');
Route::get('/gettradingPairs', ['as' => 'datatable.gettradingPairs','uses' => 'TradingPairsController@getTradingPairsData']);

Route::get('/chat', 'ChatController@index');

Route::match(['get', 'post'], '/about', ['uses' => 'HomeController@about', 'as' => 'about']);

Route::match(['get', 'post'], '/profile', ['uses' => 'ProfileController@index', 'as' => 'profile']);