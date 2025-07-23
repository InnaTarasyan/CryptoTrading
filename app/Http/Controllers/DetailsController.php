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
use App\Models\TelegramMessages;
use App\Models\TradingPair;

class DetailsController extends Controller
{
    /**
     * @param $symbol
     * @return $this
     */
    public function index($symbol)
    {
        $events = CoinMarketCalEvents::whereJsonContains('coins', [["symbol" => $symbol]])
            ->orWhereJsonContains('coins', [["name" => $symbol]])
            ->orWhereJsonContains('coins', [["fullname" => $symbol]])
            ->orWhereJsonContains('coins', [["id" => $symbol]])
            ->get();

        $events = CoinMarketCalEvents::all();

        $tradingPair = TradingPair::where('coin', $symbol)->first();

        $trendings = CoinGeckoTrending::where('api_id', $symbol)->first() ?
            json_decode(CoinGeckoTrending::where('api_id', $symbol)->first()->data, true) : [];

        $trendingsStr = '<ul>';
        foreach ($trendings as $key => $inner) {
            $innerValue = $inner;
            if(is_array($inner)) {
                $innerValue = '<ul>';
                foreach ($inner as  $value) {
                    $innerValue.= '<li>'.$value.'</li>';
                }
                $innerValue.= '</ul>';
            }
            $trendingsStr.= '<li>'.$key.' : '.$innerValue.'</li>';
        }

        $trendingsStr.= '</ul>';

        $derivativesExchanges = DerivativesExchanges::where('api_id', $symbol)->first();
        $derivatives = Derivatives::where('symbol', $symbol)->first();

        $liveCoinWatch = LiveCoinWatch::where('code', $symbol)->first();

        $coinMarketCal = CoinMarketCal::where('symbol', $symbol)->first();
        if(!$liveCoinWatch) {
            $liveCoinWatch  = CoinMarketCal::where('symbol', 'btc')->first();
        }

        $data = [
            'symbol' => $symbol,
            'name'   => $coinMarketCal ? strtolower($coinMarketCal->name) : 'bitcoin',
            'coin' => $liveCoinWatch,
            'events' => $events,
            'livecoin' => LiveCoinWatch::join('live_coin_histories', 'live_coin_histories.code', '=', 'live_coin_watches.code')
                        ->where('live_coin_watches.code', $symbol)->first(),
            'coingecko' => CoinGeckoCoin::join('coin_gecko_markets',
                'coin_gecko_coins.api_id', '=', 'coin_gecko_markets.api_id')
                              ->where('coin_gecko_markets.api_id', $symbol)->first(),
            'coinmarketcal' => Coinmarketcal::where('symbol', $symbol)->first(),
            'trendings' => $trendings,
            'trendingsText' => $trendingsStr,
            'nfts' => Nfts::where('api_id', $symbol)->first(),
            'derivatives' => $derivatives,
            'coingeckoexchanges' => CoingeckoExchanges::where('api_id', $symbol)->first(),
            'derivativesExchanges' => $derivativesExchanges ? $derivativesExchanges->description : '',
        ];


        if(empty($data['livecoin']) && empty($data['coingecko']) && empty($data['coinmarketcal'])) {
            $fiats = Fiats::where('code', $symbol)->first();

            if(!empty($fiats)) {
                $str = '<ul>';

                foreach (json_decode($fiats->countries, true) as $key => $inner) {
                    $innerValue = $inner;
                    if(is_array($inner)) {
                        $innerValue = '<ul>';
                        foreach ($inner as  $value) {
                            $innerValue.= '<li>'.$value.'</li>';
                        }
                        $innerValue.= '</ul>';
                    }
                    $str.= '<li>'.$innerValue.'</li>';
                }

                $str.= '</ul>';

                $data['fiats'] = $str;
            }
        }

        if(empty($data['livecoin']) && empty($data['coingecko']) && empty($data['coinmarketcal'])) {
            $data['exchanges'] = Exchanges::where('code', $symbol)->first();
        }

        $data['tweets'] = TelegramMessages::take(10)->get();

        if($tradingPair){
            $data['tradingPair'] = $symbol;
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
