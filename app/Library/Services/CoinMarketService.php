<?php

namespace App\Library\Services;

use App\Models\ExchangeMap;
use App\Models\NewItems;
use App\Models\GainersLosers;
use App\Models\TrandingLatest;
use App\Models\Coinmarketcap;
use App\Library\Services\Base\BaseService;
use App\Models\MostVisited;
use Carbon\Carbon;


class CoinMarketService extends  BaseService {

    public function latest(){

        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'listings/latest';
        $parameters = [
            'start' => '1',
            'limit' => '5000',
            'convert' => 'USD'
        ];

        $response = $this->retrieveCoinMarketcapData($url, $parameters);

        Coinmarketcap::truncate();

        foreach (json_decode($response)->data as  $data){
            $data->native_id = $data->id;
            $data->rank = $data->cmc_rank;
            $data->{'24h_volume_usd'} = $data->quote->USD->volume_24h;
            $data->market_cap_usd = $data->quote->USD->market_cap;
            $data->price_usd = $data->quote->USD->price;
            $data->percent_change_1h = $data->quote->USD->percent_change_1h;
            $data->percent_change_24h = $data->quote->USD->percent_change_24h;
            $data->percent_change_7d = $data->quote->USD->percent_change_7d;
            Coinmarketcap::create((array)$data);
        }

    }

    public function airDrops()
    {
        $url = env('COIN_MARKET_CURRENCY_CAP_URL').'airdrops';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function categories()
    {
        $url = env('COIN_MARKET_CURRENCY_CAP_URL').'categories';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function category()
    {
        $url = env('COIN_MARKET_CURRENCY_CAP_URL').'category';
        $params = [
           'id' => '605e2ce9d41eae1066535f7c',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function map()
    {
        $url = env('COIN_MARKET_CURRENCY_CAP_URL').'map';
        $map = $this->retrieveCoinMarketcapData($url, null);
    }

    public function info()
    {
        $url = env('COIN_MARKET_CURRENCY_CAP_URL').'info';
        $params = [
            'slug' => 'bitcoin',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function historical()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'listings/historical';
        $params = [
            'date' => '2019-10-10',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function newItems()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'listings/new';
        $newItems = $this->retrieveCoinMarketcapData($url, null);
        $data = $newItems->data;
        foreach ($data as $item) {
            NewItems::updateOrCreate(['api_id' => $item->id],[
                'api_id'             => $item->id,
                'name'               => $item->name,
                'symbol'             => $item->symbol,
                'slug'               => $item->slug,
                'cmc_rank'           => $item->cmc_rank,
                'num_market_pairs'   => $item->num_market_pairs,
                'circulating_supply' => $item->circulating_supply,
                'total_supply'       => $item->total_supply,
                'max_supply'         => $item->max_supply,
                'last_updated'       => new Carbon($item->last_updated),
                'date_added'         => new Carbon($item->date_added),
                'tags'               => json_encode($item->tags, true),
                'platform'           => $item->platform,
                'quote'              => json_encode($item->quote, true),
            ]);
        }
    }

    public function gainersLosers()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'trending/gainers-losers';
        $gainersLosers = $this->retrieveCoinMarketcapData($url, null);
        $data = $gainersLosers->data->data;
        foreach ($data as $item) {
            GainersLosers::updateOrCreate(['api_id' => $item->id],[
                'api_id'             => $item->id,
                'name'               => $item->name,
                'symbol'             => $item->symbol,
                'slug'               => $item->slug,
                'cmc_rank'           => $item->cmc_rank,
                'num_market_pairs'   => $item->num_market_pairs,
                'circulating_supply' => $item->circulating_supply,
                'total_supply'       => $item->total_supply,
                'max_supply'         => $item->max_supply,
                'last_updated'       => new Carbon($item->last_updated),
                'date_added'         => new Carbon($item->date_added),
                'tags'               => json_encode($item->tags, true),
                'platform'           => $item->platform,
                'quote'              => json_encode($item->quote, true),
            ]);
        }
    }

    public function trendingLatest()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'trending/latest';
        $trandingLatest = $this->retrieveCoinMarketcapData($url, null);
        $data = $trandingLatest->data->data;
        foreach ($data as $item) {
            TrandingLatest::updateOrCreate(['api_id' => $item->id],[
                'api_id'             => $item->id,
                'name'               => $item->name,
                'symbol'             => $item->symbol,
                'slug'               => $item->slug,
                'cmc_rank'           => $item->cmc_rank,
                'is_active'          => $item->is_active,
                'is_fiat'            => $item->is_fiat ?? false,
                'self_reported_circulating_supply' => $item->self_reported_circulating_supply,
                'self_reported_market_cap' => $item->self_reported_market_cap,
                'num_market_pairs'   => $item->num_market_pairs,
                'circulating_supply' => $item->circulating_supply,
                'total_supply'       => $item->total_supply,
                'max_supply'         => $item->max_supply,
                'last_updated'       => new Carbon($item->last_updated),
                'date_added'         => new Carbon($item->date_added),
                'tags'               => json_encode($item->tags, true),
                'platform'           => $item->platform,
                'quote'              => json_encode($item->quote, true),
            ]);
        }
    }

    public function mostVisited()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'trending/most-visited';
        $mostVisited = $this->retrieveCoinMarketcapData($url, null);
        $data = $mostVisited->data->data;

        foreach ($data as $item) {
            MostVisited::updateOrCreate(['api_id' => $item->id],[
              'api_id'             => $item->id,
              'name'               => $item->name,
              'symbol'             => $item->symbol,
              'slug'               => $item->slug,
              'cmc_rank'           => $item->cmc_rank,
              'num_market_pairs'   => $item->num_market_pairs,
              'circulating_supply' => $item->circulating_supply,
              'total_supply'       => $item->total_supply,
              'max_supply'         => $item->max_supply,
              'last_updated'       => new Carbon($item->last_updated),
              'date_added'         => new Carbon($item->date_added),
              'tags'               => json_encode($item->tags, true),
              'platform'           => $item->platform,
              'quote'              => json_encode($item->quote, true),
            ]);
        }
    }

    public function marketPairsLatest()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL_V2').'market-pairs/latest';
        $params = [
            'slug' => 'bitcoin',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function ohlcvHistorical()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL_V2').'ohlcv/historical';
        $params = [
            'slug' => 'bitcoin',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function ohlcvLatest()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL_V2').'ohlcv/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function pricePerformanceStatsLatest()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL_V2').'price-performance-stats/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function quotesHistorical()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL_V2').'quotes/historical';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function quotesHistoricalV3()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL_V3').'quotes/historical';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function quotesLatest()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL_V2').'quotes/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function fiatMap()
    {
        $url = env('COIN_MARKET_CAP_URL').'fiat/map';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function exchangeAssets()
    {
        $url = env('COIN_MARKET_CAP_URL').'exchange/assets';
        $params = [
           'id' => '3564'
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function exchangeInfo()
    {
        $url = env('COIN_MARKET_CAP_URL').'exchange/info';
        $params = [
            'id' => '3564'
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function exchangeMap()
    {
        $url = env('COIN_MARKET_CAP_URL').'exchange/map';
        $exchangeMap = $this->retrieveCoinMarketcapData($url, null);
        $data = $exchangeMap->data;
        foreach ($data as $item) {
            ExchangeMap::updateOrCreate(['api_id' => $item->id],[
                'api_id'             => $item->id,
                'name'               => $item->name,
                'slug'               => $item->slug,
                'is_active'          => $item->is_active,
                'first_historical_data' => new Carbon($item->first_historical_data),
                'last_historical_data'  => new Carbon($item->last_historical_data),
            ]);
        }
    }

    public function exchangeListingLatest()
    {
        $url = env('COIN_MARKET_CAP_URL').'exchange/listings/latest';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function marketPairsLatestV1()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'market-pairs/latest';
        $params = [
            'slug' => 'bitcoin',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function ohlcvHistoricalV1()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'ohlcv/historical';
        $params = [
            'slug' => 'bitcoin',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }


    public function ohlcvLatestV1()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'ohlcv/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function pricePerformanceStatsLatestV1()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'price-performance-stats/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function quotesHistoricalV1()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'quotes/historical';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function quotesLatestV1()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'quotes/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function listingsLatest()
    {
        $url = env('COIN_MARKET_CAP_PARTNER_URL').'flipside-crypto/fcas/listings/latest';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function quotesLatestPartner()
    {
        $url = env('COIN_MARKET_CAP_PARTNER_URL').'flipside-crypto/fcas/quotes/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function contentLatest()
    {
        $url = env('COIN_MARKET_CAP_URL').'content/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function trendingToken()
    {
        $url = env('COIN_MARKET_CAP_URL').'community/trending/token';
        $this->retrieveCoinMarketcapData($url, null);
    }


    public function trendingTopic()
    {
        $url = env('COIN_MARKET_CAP_URL').'community/trending/topic';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function postsComments()
    {
        $url = env('COIN_MARKET_CAP_URL').'content/posts/comments';
        $params = [
           'post_id' => '325670123',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function postsLatest()
    {
        $url = env('COIN_MARKET_CAP_URL').'content/posts/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function postsTop()
    {
        $url = env('COIN_MARKET_CAP_URL').'content/posts/top';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    protected function retrieveCoinMarketcapData($url, $params)
    {
        $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: '.env('COIN_MARKET_KEY'),

        ];

        if($params) {
            $qs = http_build_query($params); // query string encode the parameters
            $request = "{$url}?{$qs}"; // create the request URL
        } else {
            $request = "{$url}"; // create the request URL
        }

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
       // print_r(json_decode($response)); // print json decoded response
        curl_close($curl); // Close request

        return json_decode($response);
    }
}
