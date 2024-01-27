<?php

namespace App\Http\Controllers;

use App\Models\CoinGecko\CoinGeckoCoin;
use App\Models\CoinGecko\CoingeckoExchanges;
use App\Models\CoinGecko\CoinGeckoTrending;
use App\Models\CoinMarketCal\CoinMarketCal;
use App\Models\CoinMarketCal\CoinMarketCalEvents;
use App\Models\CoinGecko\Derivatives;
use App\Models\CoinGecko\DerivativesExchanges;
use App\Models\LiveCoinWatch\Exchanges;
use App\Models\LiveCoinWatch\Fiats;
use App\Models\LiveCoinWatch\LiveCoinWatch;
use App\Models\CoinGecko\Nfts;
use App\Models\TradingPair;
use App\Models\TwitterAccount;

class DetailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($symbol)
    {
        $symbol = trim($symbol);

        $events = CoinMarketCalEvents::whereJsonContains('coins', [["symbol" => $symbol]])
            ->orWhereJsonContains('coins', [["name" => $symbol]])
            ->orWhereJsonContains('coins', [["fullname" => $symbol]])
            ->orWhereJsonContains('coins', [["id" => $symbol]])
            ->get();

        $twitter = TwitterAccount::where('coin', $symbol)->first();
        $tradingPair = TradingPair::where('coin', $symbol)->first();

        $trendings = CoinGeckoTrending::where('symbol', $symbol)->first() ?
            json_decode(CoinGeckoTrending::where('symbol', $symbol)->first()->data, true) : [];

        $str = '<ul>';

        foreach ($trendings as $key => $inner) {
            $innerValue = $inner;
            if(is_array($inner)) {
                $innerValue = '<ul>';
                foreach ($inner as  $value) {
                    $innerValue.= '<li>'.$value.'</li>';
                }
                $innerValue.= '</ul>';
            }
            $str.= '<li>'.$key.' : '.$innerValue.'</li>';
        }

        $str.= '</ul>';

        $derivativesExchanges = DerivativesExchanges::where('api_id', $symbol)->first();
        $derivatives = Derivatives::where('symbol', $symbol)->first();

        $data = [
            'symbol' => $symbol,
            'coin' => LiveCoinWatch::where('code', $symbol)->first() ?
                LiveCoinWatch::where('code', $symbol)->first()->name :
                (CoinGeckoCoin::where('symbol', $symbol)->first() ?
                    CoinGeckoCoin::where('symbol', $symbol)->first()->name : ''),
           // 'events' => Coindar::all()->where('coin_symbol', strtoupper($symbol)),
            'events' => $events,
            'livecoin' => LiveCoinWatch::join('live_coin_histories', 'live_coin_histories.code', '=', 'live_coin_watches.code')
                        ->where('live_coin_watches.code', $symbol)->first(),
            'coingecko' => CoinGeckoCoin::join('coin_gecko_markets',
                'coin_gecko_coins.api_id', '=', 'coin_gecko_markets.api_id')
                              ->where('symbol', $symbol)->first(),
            'coinmarketcal' => Coinmarketcal::where('symbol', $symbol)->first(),
            'trendings' => $trendings,
            'trendingsText' => $str,
            'nfts' => Nfts::where('api_id', $symbol)->first(),
            'derivatives' => $derivatives,
            'coingeckoexchanges' => CoingeckoExchanges::where('api_id', $symbol)->first(),
            'derivativesExchanges' => $derivativesExchanges ? $derivativesExchanges->description : '',
        ];

        if(empty($data['livecoin']) && empty($data['coingecko']) && empty($data['coinmarketcal'])) {
            $data['fiats'] = Fiats::where('code', $symbol)->first();
        }

        if(empty($data['livecoin']) && empty($data['coingecko']) && empty($data['coinmarketcal'])) {
            $data['exchanges'] = Exchanges::where('code', $symbol)->first();
        }

        if($twitter){
            /**
            $screenName = $twitter->account;
            $tweets =  json_decode(Twitter::getUserTimeline(['screen_name' => $screenName, 'count' => 20, 'format' => 'json']), true);
            foreach ($tweets as &$tweet){
                $tweet['text'] = $this->parse_tweet($tweet['text']);
            }
            $data['tweets'] = $tweets; **/
        }

        if($tradingPair){
            $data['tradingPair'] = $tradingPair->trading_pair;
        }

        return view('coindetails')
            ->with($data);
    }


    /**
     *  Parse the tweet
     */
    function parse_tweet($text) {
        // Parse links.
        $text = preg_replace(
            '@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@',
            '<a href="$1">$1</a>',
            $text);
        // Parse @mentions
        $text = preg_replace(
            '/@(\w+)/',
            '<a href="http://twitter.com/$1">@$1</a>',
            $text);
        // Parse #hashtags
        $text = preg_replace(
            '/\s+#(\w+)/',
            ' <a href="http://search.twitter.com/search?q=%23$1">#$1</a>',
            $text);
        return $text;
    }
}
