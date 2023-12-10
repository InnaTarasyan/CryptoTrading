<?php

namespace App\Library\Services;
use App\Library\Services\Base\BaseService;
use App\Models\CoinGeckoCoin;
use App\Models\CoinGeckoMarkets;
use Carbon\Carbon;

class CoinGeckoService extends  BaseService
{
    public function handle()
    {
        //$this->ping();
       // $this->coins();
        $this->markets();
    }

    protected function ping()
    {
        $params = [
            'api_key' => env('COIN_GECKO_KEY')
        ];

        $response = $this->retrieveData(env('COIN_GECKO_URL').'ping', $params);

        dump($response);
    }

    protected function coins()
    {
        $params = [
            'api_key' => env('COIN_GECKO_KEY')
        ];

        $response = $this->retrieveData(env('COIN_GECKO_URL').'coins/list?include_platform=false', $params);

        foreach ($response as $item) {
            CoinGeckoCoin::updateOrCreate([
                'symbol' => $item['symbol'],
            ], [
                'api_id' => $item['id'],
                'name'   => $item['name'],
                'symbol' => $item['symbol'],
            ]);
        }
    }

    protected function markets()
    {
        $params = [
            'api_key' => env('COIN_GECKO_KEY'),
            'vs_currency' => 'usd',
            'order' => 'market_cap_desc',
            'per_page' => 100,
        ];

        $response = $this->retrieveData(env('COIN_GECKO_URL').'coins/markets?page=1&sparkline=false&locale=en', $params);

        foreach ($response as $item) {
            CoinGeckoMarkets::updateOrCreate([
                'api_id' => $item['id'],
            ], [
                'api_id' => $item['id'],
                'name'   => $item['name'],
                'image'  => $item['image'],
                'current_price' => $item['current_price'],
                'market_cap' => $item['market_cap'],
                'market_cap_rank' => $item['market_cap_rank'],
                'fully_diluted_valuation' => $item['fully_diluted_valuation'],
                'total_volume' => $item['total_volume'],
                'high_24h' => $item['high_24h'],
                'low_24h'  => $item['low_24h'],
                'price_change_24h' => $item['price_change_24h'],
                'price_change_percentage_24h' => $item['price_change_percentage_24h'],
                'market_cap_change_24h' => $item['market_cap_change_24h'],
                'market_cap_change_percentage_24h' => $item['market_cap_change_percentage_24h'],
                'circulating_supply' => $item['circulating_supply'],
                'total_supply' => $item['total_supply'],
                'max_supply' => $item['max_supply'],
                'ath' => $item['ath'],
                'ath_change_percentage' => $item['ath_change_percentage'],
                'ath_date' => new Carbon($item['ath_date']),
                'atl' => $item['atl'],
                'atl_change_percentage' => $item['atl_change_percentage'],
                'atl_date' => new Carbon($item['atl_date']),
                'roi' => json_encode($item['roi']),
                'last_updated' => new Carbon($item['last_updated']),
            ]);
        }
    }
}