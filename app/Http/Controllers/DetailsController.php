<?php

namespace App\Http\Controllers;

use App\TwitterAccount;
use Illuminate\Http\Request;
use App\Coindar;
use App\Coinmarketcap;
use App\Coinbin;
use App\Solume;
use App\WorldCoinIndex;

use Twitter;

class DetailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($symbol)
    {
        $twitter = TwitterAccount::where('coin', $symbol)->first();
        $data = [
            'events' => Coindar::all()->where('coin_symbol', strtoupper($symbol)),
            'coinmarketcap' => Coinmarketcap::where('symbol', $symbol)->first(),
            'coinbin' => Coinbin::where('ticker', $symbol)->first(),
            'solume'=> Solume::where('symbol', $symbol)->first(),
            'worldcoinindex' => WorldCoinIndex::where('Label', 'Like', $symbol.'/%')->first(),
        ];

        if($twitter){
            $screenName = $twitter->account;
            $tweets =  json_decode(Twitter::getUserTimeline(['screen_name' => $screenName, 'count' => 20, 'format' => 'json']), true);
            foreach ($tweets as &$tweet){
                $tweet['text'] = $this->parse_tweet($tweet['text']);
            }
            $data['tweets'] = $tweets;
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
