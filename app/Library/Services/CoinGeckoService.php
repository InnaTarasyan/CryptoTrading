<?php

namespace App\Library\Services;
use App\Library\Services\Base\BaseService;
use App\Models\CoinGeckoCategories;
use App\Models\CoinGeckoCoin;
use App\Models\CoinGeckoExchangeRates;
use App\Models\CoingeckoExchanges;
use App\Models\CoinGeckoMarkets;
use App\Models\CoinGeckoTrending;
use App\Models\Derivatives;
use App\Models\DerivativesExchanges;
use App\Models\Nfts;
use Carbon\Carbon;

class CoinGeckoService extends  BaseService
{
    public function handle()
    {
        //$this->ping();
       // $this->coins();
      //  $this->markets();
      //  $this->exchanges();
       // $this->trending();
       // $this->exchangeRates();
      //  $this->nfts();
       // $this->getDerivatives();
       // $this->getDerivativesExchanges();
        $this->getCategories();
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
                'roi' => isset($item['roi']) ? json_encode($item['roi']) : null,
                'last_updated' => new Carbon($item['last_updated']),
            ]);
        }
    }

    public function exchanges()
    {
        $params = [
            'api_key' => env('COIN_GECKO_KEY'),
        ];

        $response = $this->retrieveData(env('COIN_GECKO_URL').'exchanges', $params);
        foreach ($response as $item) {
            CoingeckoExchanges::updateOrCreate(['api_id' => $item['id']], [
                'api_id' => $item['id'],
                'name'   => $item['name'],
                'year_established' => $item['year_established'],
                'country' => $item['country'],
                'description' => $item['description'],
                'url' => $item['url'],
                'image' => $item['image'],
                'has_trading_incentive' => $item['has_trading_incentive'],
                'trust_score' => $item['trust_score'],
                'trust_score_rank' => $item['trust_score_rank'],
                'trade_volume_24h_btc' => $item['trade_volume_24h_btc'],
                'trade_volume_24h_btc_normalized' => $item['trade_volume_24h_btc_normalized'],
            ]);
        }
    }

    public function trending()
    {
        $params = [
            'api_key' => env('COIN_GECKO_KEY'),
        ];

        $response = $this->retrieveData(env('COIN_GECKO_URL').'search/trending', $params);
        foreach ($response['coins'] as $item) {
           $item = $item['item'];
           CoinGeckoTrending::updateOrCreate(['api_id' => $item['id']], [
               'api_id'  => $item['id'],
               'coin_id' => $item['coin_id'],
               'name'    => $item['name'],
               'symbol'  => $item['symbol'],
               'market_cap_rank' => $item['market_cap_rank'],
               'thumb'  => $item['thumb'],
               'small'  => $item['small'],
               'large'  => $item['large'],
               'slug'   => $item['slug'],
               'price_btc' => $item['price_btc'],
               'score'  => $item['score'],
               'data'   => json_encode($item['data'], true),
           ]);
        }
    }

    public function exchangeRates()
    {
        $params = [
            'api_key'  => env('COIN_GECKO_KEY'),
        ];

        $response = $this->retrieveData(env('COIN_GECKO_URL').'exchange_rates', $params);
        foreach ($response['rates'] as $index => $item) {
           CoinGeckoExchangeRates::updateOrCreate(['symbol' => $index], [
               'symbol' => $index,
               'name'   => $item['name'],
               'unit'   => $item['unit'],
               'value'  => $item['value'],
               'type'   => $item['type'],
           ]);
        }
    }

    public function nfts()
    {
        $page = 1;
        while(true) {
            $params = [
                'api_key' => env('COIN_GECKO_KEY'),
                'per_page' => 100,
                'page'     => $page++,
            ];

            $response = $this->retrieveData(env('COIN_GECKO_URL').'nfts/list', $params);

            foreach ($response as $item) {
                Nfts::updateOrCreate([
                    'api_id' => $item['id']
                ], [
                    'api_id' => $item['id'],
                    'contract_address' => $item['contract_address'],
                    'name' => $item['name'],
                    'asset_platform_id' => $item['asset_platform_id'],
                    'symbol' => $item['symbol'],
                ]);
            }

            if($page > 5) {
                return;
            }

            sleep(5);
        }
    }

    public function getDerivatives()
    {
        $params = [
            'api_key' => env('COIN_GECKO_KEY'),
        ];

        $response = $this->retrieveData(env('COIN_GECKO_URL').'derivatives', $params);
        foreach ($response as $item) {
            Derivatives::updateOrCreate([
                'symbol'  => $item['symbol'],
            ], [
                'symbol'  => $item['symbol'],
                'market' => $item['market'],
                'index_id' => $item['index_id'],
                'price' => $item['price'],
                'price_percentage_change_24h' => $item['price_percentage_change_24h'],
                'contract_type' => $item['contract_type'],
                'index' => $item['index'],
                'basis' => $item['basis'],
                'spread' => $item['spread'],
                'funding_rate' => $item['funding_rate'],
                'open_interest' => $item['open_interest'],
                'volume_24h' => $item['volume_24h'],
                'last_traded_at' => new Carbon($item['last_traded_at']),
                'expired_at' => new Carbon($item['expired_at']),
            ]);
        }
    }

    public function getDerivativesExchanges()
    {
        $params = [
            'api_key' => env('COIN_GECKO_KEY'),
        ];

        $response = $this->retrieveData(env('COIN_GECKO_URL').'derivatives/exchanges', $params);
        foreach ($response as $item) {
            DerivativesExchanges::updateOrCreate([
                'api_id' => $item['id']
            ], [
                'api_id' => $item['id'],
                'name'   => $item['name'],
                'open_interest_btc' => $item['open_interest_btc'],
                'trade_volume_24h_btc' => $item['trade_volume_24h_btc'],
                'number_of_perpetual_pairs' => $item['number_of_perpetual_pairs'],
                'number_of_futures_pairs' => $item['number_of_futures_pairs'],
                'image' => $item['image'],
                'year_established' => new Carbon($item['year_established']),
                'country' => $item['country'],
                'description' => $item['description'],
                'url' => $item['url']
            ]);
        }
    }

    public function getCategories()
    {
        $params = [
            'api_key' => env('COIN_GECKO_KEY'),
        ];

        $response = $this->retrieveData(env('COIN_GECKO_URL').'coins/categories/list', $params);
        foreach ($response as $item) {
          CoinGeckoCategories::updateOrCreate([
              'name'   => $item['name'],
              'category_id' => $item['category_id'],
          ],[
              'name'   => $item['name'],
              'category_id' => $item['category_id'],
          ]);
        }
    }
}