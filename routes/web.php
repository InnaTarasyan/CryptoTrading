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
Auth::routes();

Route::get('/getcoinmarketcap', ['as'=>'datatable.getcoinmarketcap','uses'=>'HomeController@getCoinmarketcapData']);
Route::get('/getsolume', ['as'=>'datatable.getsolume','uses'=>'SolumeController@getSolumeData']);
Route::get('/getcoinbin', ['as'=>'datatable.getcoinbin','uses'=>'CoinbinController@getCoinbinData']);
Route::get('/getworldcoinindex', ['as'=>'datatable.getworldcoinindex','uses'=>'WorldCoinIndexController@getWorldCoinIndexData']);

Route::get('/details/{coin}', 'DetailsController@index');

Route::get('/twitter', 'TwitterController@index');
Route::resource('twitter', 'TwitterController');
Route::get('/gettwitter', ['as'=>'datatable.gettwitter','uses'=>'TwitterController@getTweets']);
