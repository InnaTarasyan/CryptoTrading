<?php

namespace App\Library\Services;

use App\Coinmarketcap;
use App\Library\Services\Base\BaseService;


class CoinMarketService extends  BaseService {

    public function latest(){

        $url = env('COIN_MARKET_CAP_URL').'listings/latest';
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
        $url = env('COIN_MARKET_CAP_URL').'airdrops';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function categories()
    {
        $url = env('COIN_MARKET_CAP_URL').'categories';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function category()
    {
        $url = env('COIN_MARKET_CAP_URL').'category';
        $params = [
           'id' => '605e2ce9d41eae1066535f7c',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function map()
    {
        $url = env('COIN_MARKET_CAP_URL').'map';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function info()
    {
        $url = env('COIN_MARKET_CAP_URL').'info';
        $params = [
            'slug' => 'bitcoin',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function historical()
    {
        $url = env('COIN_MARKET_CAP_URL').'listings/historical';
        $params = [
            'date' => '2019-10-10',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function newItems()
    {
        $url = env('COIN_MARKET_CAP_URL').'listings/new';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function gainersLosers()
    {
        $url = env('COIN_MARKET_CAP_URL').'trending/gainers-losers';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function trendingLatest()
    {
        $url = env('COIN_MARKET_CAP_URL').'trending/latest';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function mostVisited()
    {
        $url = env('COIN_MARKET_CAP_URL').'trending/most-visited';
        $this->retrieveCoinMarketcapData($url, null);
    }

    public function marketPairsLatest()
    {
        $url = env('COIN_MARKET_CAP_URL_V2').'market-pairs/latest';
        $params = [
            'slug' => 'bitcoin',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function ohlcvHistorical()
    {
        $url = env('COIN_MARKET_CAP_URL_V2').'ohlcv/historical';
        $params = [
            'slug' => 'bitcoin',
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function ohlcvLatest()
    {
        $url = env('COIN_MARKET_CAP_URL_V2').'ohlcv/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function pricePerformanceStatsLatest()
    {
        $url = env('COIN_MARKET_CAP_URL_V2').'price-performance-stats/latest';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function quotesHistorical()
    {
        $url = env('COIN_MARKET_CAP_URL_V2').'quotes/historical';
        $params = [
            "symbol" => "BTC",
        ];
        $this->retrieveCoinMarketcapData($url, $params);
    }

    public function quotesLatest()
    {
        $url = env('COIN_MARKET_CAP_URL_V2').'quotes/latest';
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
        print_r(json_decode($response)); // print json decoded response
        curl_close($curl); // Close request

        return $response;
    }
}
