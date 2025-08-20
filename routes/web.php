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

// Coin markets comparison
Route::get('/', 'MarketsComparizonController@index')->name('main');
Route::get('/coinmpredictions', 'MarketsComparizonController@coinPredictions')->name('predictions');
Route::get('/api/coin-predictions', 'MarketsComparizonController@getCoinPredictionsData')->name('api.coin.predictions');
Route::get('/api/coin-prediction', 'MarketsComparizonController@getSingleCoinPrediction')->name('api.coin.prediction');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Personal Cabinet
Route::middleware('auth')->group(function () {
    Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->name('account.index');
    Route::get('/account/profile', [App\Http\Controllers\AccountController::class, 'profile'])->name('account.profile');
    Route::put('/account/profile', [App\Http\Controllers\AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::get('/account/security', [App\Http\Controllers\AccountController::class, 'security'])->name('account.security');
    Route::put('/account/security/password', [App\Http\Controllers\AccountController::class, 'updatePassword'])->name('account.security.password');
    Route::post('/account/security/2fa/setup', [App\Http\Controllers\AccountController::class, 'setupTwoFactor'])->name('account.security.2fa.setup');
    Route::post('/account/security/2fa/verify', [App\Http\Controllers\AccountController::class, 'verifyTwoFactor'])->name('account.security.2fa.verify');
    Route::post('/account/security/2fa/disable', [App\Http\Controllers\AccountController::class, 'disableTwoFactor'])->name('account.security.2fa.disable');
    Route::get('/account/security/2fa/recovery-codes', [App\Http\Controllers\AccountController::class, 'getRecoveryCodes'])->name('account.security.2fa.recovery-codes');
    Route::post('/account/security/sessions/terminate-all', [App\Http\Controllers\AccountController::class, 'terminateAllSessions'])->name('account.security.sessions.terminate-all');
    Route::get('/account/notifications', [App\Http\Controllers\AccountController::class, 'notifications'])->name('account.notifications');
    Route::post('/account/notifications/save', [App\Http\Controllers\AccountController::class, 'saveNotificationSettings'])->name('account.notifications.save');
    Route::post('/account/notifications/update-status/{id}', [App\Http\Controllers\AccountController::class, 'updateNotificationStatus'])->name('account.notifications.update-status');
    Route::post('/account/notifications/delete/{id}', [App\Http\Controllers\AccountController::class, 'deleteNotification'])->name('account.notifications.delete');
    Route::get('/account/connections', [App\Http\Controllers\AccountController::class, 'connections'])->name('account.connections');
    Route::get('/account/api-keys', [App\Http\Controllers\AccountController::class, 'apiKeys'])->name('account.api_keys');
    Route::post('/account/api-keys', [App\Http\Controllers\AccountController::class, 'generateApiKey'])->name('account.api_keys.generate');
    Route::delete('/account/api-keys/{apiKey}', [App\Http\Controllers\AccountController::class, 'deleteApiKey'])->name('account.api_keys.delete');
    Route::patch('/account/api-keys/{apiKey}/toggle', [App\Http\Controllers\AccountController::class, 'toggleApiKey'])->name('account.api_keys.toggle');
    Route::get('/account/billing', [App\Http\Controllers\AccountController::class, 'billing'])->name('account.billing');
    Route::get('/account/support', [App\Http\Controllers\AccountController::class, 'support'])->name('account.support');
});


// live coin watch comparison data
Route::get('/livecoinwatch/compare',
    ['as' => 'livecoinwatch.compare',
        'uses' => 'MarketsComparizonController@compareData']);

// enhanced comparison with external API data
Route::get('/livecoinwatch/enhanced-compare',
    ['as' => 'livecoinwatch.enhanced.compare',
        'uses' => 'MarketsComparizonController@getEnhancedComparison']);

// Individual API endpoints for AJAX loading
Route::get('/api/coinpaprika-data', 'MarketsComparizonController@getCoinPaprikaDataApi')->name('api.coinpaprika.data');
Route::get('/api/cryptics-data', 'MarketsComparizonController@getCrypticsDataApi')->name('api.cryptics.data');

// New: Main page analytics endpoints
Route::get('/api/main/timeseries-prices', 'MarketsComparizonController@getTimeSeriesPrices')->name('api.main.ts_prices');
Route::get('/api/main/market-dominance', 'MarketsComparizonController@getMarketDominance')->name('api.main.market_dominance');
Route::get('/api/main/top-volume-markets', 'MarketsComparizonController@getTopVolumeMarkets')->name('api.main.top_volume_markets');
Route::get('/api/main/events-calendar', 'MarketsComparizonController@getEventsCalendar')->name('api.main.events_calendar');

// coin analysis across platforms
Route::get('/livecoinwatch/coin-analysis',
    ['as' => 'livecoinwatch.coin.analysis',
        'uses' => 'MarketsComparizonController@getCoinAnalysis']);



// live coin watch history
Route::get('/history','LiveCoinWatch\HistoryController@index')->name('home');
Route::get('/getlivecoinhistory',
    ['as' => 'datatable.livecoin.history',
        'uses' => 'LiveCoinWatch\HistoryController@getData']);

//// live coin watch comparison data
//Route::get('/livecoinwatch/compare',
//    ['as' => 'livecoinwatch.compare',
//        'uses' => 'LiveCoinWatch\HistoryController@compareData']);
//
//// enhanced comparison with external API data
//Route::get('/livecoinwatch/enhanced-compare',
//    ['as' => 'livecoinwatch.enhanced.compare',
//        'uses' => 'LiveCoinWatch\HistoryController@getEnhancedComparison']);
//
//// coin analysis across platforms
//Route::get('/livecoinwatch/coin-analysis',
//    ['as' => 'livecoinwatch.coin.analysis',
//        'uses' => 'LiveCoinWatch\HistoryController@getCoinAnalysis']);

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



/** ===== CryptoCompare ====== */

// CryptoCompare Coins
Route::get('/cryptocomparecoinsindex', 'CryptoCompare\CoinsController@index');
Route::get('/getcryptocomparecoinsdata',
    ['as' => 'datatable.cryptocompare.coins',
        'uses' => 'CryptoCompare\CoinsController@getData']);

// CryptoCompare Markets
Route::get('/cryptocomparemarketsindex', 'CryptoCompare\MarketsController@index');
Route::get('/getcryptocomparemarketsdata',
    ['as' => 'datatable.cryptocompare.markets',
        'uses' => 'CryptoCompare\MarketsController@getData']);

// CryptoCompare Exchanges
Route::get('/cryptocompareexchangesindex', 'CryptoCompare\ExchangesController@index');
Route::get('/getcryptocompareexchangesdata',
    ['as' => 'datatable.cryptocompare.exchanges',
        'uses' => 'CryptoCompare\ExchangesController@getData']);

// CryptoCompare News
Route::get('/cryptocomparenewsindex', 'CryptoCompare\NewsController@index');
Route::get('/getcryptocomparenewsdata',
    ['as' => 'datatable.cryptocompare.news',
        'uses' => 'CryptoCompare\NewsController@getData']);

// CryptoCompare Top Pairs
Route::get('/cryptocomparetopairsindex', 'CryptoCompare\TopPairsController@index');
Route::get('/getcryptocomparetopairsdata',
    ['as' => 'datatable.cryptocompare.top_pairs',
        'uses' => 'CryptoCompare\TopPairsController@getData']);



/** ===== Coin Market Cal ====== */

Route::get('/coinmarketcalindex', 'CoinMarketCalController@index');
Route::get('/coinmarketcal',
    ['as' => 'datatable.coinmarketcal',
        'uses' => 'CoinMarketCalController@getCoinMarketCalData']);


/** ===== Coin Details ====== */

Route::get('/details/{coin}', 'DetailsController@index')->name('coin_details');



/** ===== Telegram ====== */

Route::get('/telegram', ['as' => 'telegram', 'uses' => 'TelegramController@index']);
Route::resource('telegram', 'TelegramController');
Route::get('/gettelegram', ['as' => 'datatable.gettelegram','uses' => 'TelegramController@getMessages']);



/** ===== Twitter ====== */

Route::get('/twitter', ['as' => 'twitter', 'uses' => 'TwitterController@index']);
Route::resource('twitter', 'TwitterController');
Route::get('/gettwitter', ['as' => 'datatable.gettwitter','uses' => 'TwitterController@getMessages']);
//
///** ===== Facebook ====== */
//
//Route::get('/facebook', ['as' => 'facebook', 'uses' => 'FacebookController@index']);
//Route::resource('facebook', 'FacebookController');
//Route::get('/getfacebook', ['as' => 'datatable.getfacebook','uses' => 'FacebookController@getPosts']);
//Route::get('/facebook/groups', ['as' => 'facebook.groups', 'uses' => 'FacebookController@groups']);
//Route::get('/facebook/posts', ['as' => 'facebook.posts', 'uses' => 'FacebookController@posts']);
//Route::get('/facebook/users', ['as' => 'facebook.users', 'uses' => 'FacebookController@users']);
//Route::get('/facebook/coin/{coin}', ['as' => 'facebook.coin.posts', 'uses' => 'FacebookController@coinPosts']);
//Route::post('/facebook/fetch-data', ['as' => 'facebook.fetch.data', 'uses' => 'FacebookController@fetchData']);
//Route::post('/facebook/search', ['as' => 'facebook.search', 'uses' => 'FacebookController@searchPosts']);
//Route::get('/facebook/api-status', ['as' => 'facebook.api.status', 'uses' => 'FacebookController@checkApiStatus']);

/** ===== Trading Pairs ====== */

Route::get('/tradingPairs', ['as' => 'tradingPairs', 'uses' => 'TradingPairsController@index']);
Route::resource('tradingPairs', 'TradingPairsController');
Route::get('/gettradingPairs',
    ['as' => 'datatable.gettradingPairs','uses' => 'TradingPairsController@getTradingPairsData']);


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

// Coin Gecko Derivatives Reviews
Route::get('/coingecko/derivatives/reviews', [\App\Http\Controllers\Coingecko\DerivativesReviewController::class, 'index'])->name('coingecko.derivatives.reviews.index');
Route::post('/coingecko/derivatives/reviews', [\App\Http\Controllers\Coingecko\DerivativesReviewController::class, 'store'])->name('coingecko.derivatives.reviews.store');

// Privacy Policy Page
Route::view('/privacy-policy', 'privacy-policy')->name('privacy.policy');

// Terms of Use Page
Route::view('/terms-of-use', 'terms-of-use')->name('terms.of.use');

