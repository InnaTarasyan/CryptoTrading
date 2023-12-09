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

Route::get('/', 'HomeController@index');
Route::get('/solume', 'SolumeController@index');
Route::get('/coinbin', 'CoinbinController@index');
Route::get('/worldcoinindex','WorldCoinIndexController@index');
Route::get('/livecoinwatch','LiveCoinController@index');
Route::get('/exchangesindex','ExchangesController@index');

Route::get('/getcoinmarketcap', ['as' => 'datatable.getcoinmarketcap','uses' => 'HomeController@getCoinmarketcapData']);
Route::get('/getsolume', ['as' => 'datatable.getsolume','uses' => 'SolumeController@getSolumeData']);
Route::get('/getcoinbin', ['as' => 'datatable.getcoinbin','uses' => 'CoinbinController@getCoinbinData']);
Route::get('/getworldcoinindex', ['as' => 'datatable.getworldcoinindex','uses' => 'WorldCoinIndexController@getWorldCoinIndexData']);
Route::get('/getlivecoin', ['as' => 'datatable.getlivecoin','uses' => 'LiveCoinController@getLiveCoinData']);
Route::get('/exchanges', ['as' => 'datatable.exchanges','uses' => 'ExchangesController@getExchangesData']);



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