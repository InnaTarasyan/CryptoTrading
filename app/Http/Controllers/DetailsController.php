<?php

namespace App\Http\Controllers;

use App\Models\CoinGecko\CoinGeckoMarkets;
use App\Models\CoinGecko\Derivatives;
use App\Models\CoinMarketCal\CoinMarketCalEvents;
use App\Models\LiveCoinWatch\LiveCoinHistory;
use App\Models\LiveCoinWatch\LiveCoinWatch;
use App\Models\TelegramMessages;

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

        if(empty($events) || $events->count() === 0) {
            $events = CoinMarketCalEvents::all();
        }

        $coin = null;

        if(!$coin) {
            $coin = LiveCoinWatch::join('live_coin_histories', 'live_coin_histories.code',
                '=', 'live_coin_watches.code')
                ->where('live_coin_histories.code', $symbol)->first();
        }

        if(!$coin) {
            $coin  = LiveCoinHistory::where('code', 'btc')->first();
        }

        $data = [
            'symbol' => $symbol,
            'name'   => $coin ? strtolower($coin->name) : 'bitcoin',
            'coin'   => $coin,
            'events' => $events,
            'tweets' => TelegramMessages::orderBy('created_at', 'desc')->get(),
        ];

        if($coin) {
            $coingeckoMarkets = CoinGeckoMarkets::where('api_id', strtolower($coin->name))->first();
            $derivatives = Derivatives::where('index_id', strtoupper($coin->code))->first();
            $data['derivatives'] = $derivatives;
            $data['coinGeckoMarkets'] = $coingeckoMarkets;
        }

        if(!$coin) {
            abort(404);
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
