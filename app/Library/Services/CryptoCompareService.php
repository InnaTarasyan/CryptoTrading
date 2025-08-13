<?php

namespace App\Library\Services;

use App\Library\Services\Base\BaseService;
use App\Models\CryptoCompare\CryptoCompareCoins;
use App\Models\CryptoCompare\CryptoCompareMarkets;
use App\Models\CryptoCompare\CryptoCompareExchanges;
use App\Models\CryptoCompare\CryptoCompareNews;
use App\Models\CryptoCompare\CryptoCompareTopPairs;
use Carbon\Carbon;
use function danog\MadelineProto\arr;
use Illuminate\Support\Facades\Log;

class CryptoCompareService extends BaseService
{
    public function handle()
    {
        Log::channel('crabler')->info('CryptoCompareService::coins()');
        $this->coins();
        sleep(60);

        Log::channel('crabler')->info('CryptoCompareService::markets()');
        $this->markets();
        sleep(60);

        Log::channel('crabler')->info('CryptoCompareService::exchanges()');
        $this->exchanges();
        sleep(60);

//        Log::channel('crabler')->info('CryptoCompareService::news()');
//        $this->news();
//        sleep(60);
//
        Log::channel('crabler')->info('CryptoCompareService::topPairs()');
        $this->topPairs();
        sleep(60);
    }

    public function handleSingle()
    {
        $this->markets();
    }

    public function ping()
    {
        $params = [
            'api_key' => env('COIN_DESK')
        ];

        $response = $this->retrieveData('https://min-api.cryptocompare.com/data/ping', $params);
        dump($response);
    }

    protected function coins()
    {
        $params = [
            'api_key' => env('COIN_DESK')
        ];

        $response = $this->retrieveData('https://min-api.cryptocompare.com/data/all/coinlist', $params);

        if (isset($response['Data'])) {
            foreach ($response['Data'] as $symbol => $item) {

                try {

                    CryptoCompareCoins::updateOrCreate([
                        'symbol' => $symbol,
                    ], [
                        'api_id' => $item['Id'],
                        'name' => $item['Name'],
                        'symbol' => $symbol,
                        'full_name' => $item['FullName'],
                        'internal' => array_key_exists('Internal', $item) ? $item['Internal'] : 0,
                        'image_url' => $item['ImageUrl'],
                        'url' => $item['Url'],
                        'algorithm' => $item['Algorithm'] ?? null,
                        'proof_type' => $item['ProofType'] ?? null,
                        'net_hashes_per_second' => $item['NetHashesPerSecond'] ?? null,
                        'block_number' => $item['BlockNumber'] ?? null,
                        'block_time' => $item['BlockTime'] ?? null,
                        'block_reward' => $item['BlockReward'] ?? null,
                        'asset_launch_date' => isset($item['AssetLaunchDate']) ? new Carbon($item['AssetLaunchDate']) : null,
                        'max_supply' => $item['MaxSupply'] ?? null,
                        'mkt_cap_penalty' => $item['MktCapPenalty'] ?? null,
                        'is_trading' => $item['IsTrading'] ?? false,
                        'total_coin_supply' => $item['TotalCoinSupply'] ?? null,
                        'pre_mined_value' => $item['PreMinedValue'] ?? null,
                        'total_coins_free_float' => $item['TotalCoinsFreeFloat'] ?? null,
                        'sort_order' => $item['SortOrder'] ?? null,
                        'sponsored' => $item['Sponsored'] ?? false,
                    ]);
                } catch (\Exception $exception) {
                    continue;
                }
            }
        }
    }

    protected function markets()
    {
        $params = [
            'api_key' => env('COIN_DESK'),
            'tsym' => 'USD',
            'limit' => 100,
        ];

        $response = $this->retrieveData('https://min-api.cryptocompare.com/data/top/mktcapfull', $params);

        if (isset($response['Data'])) {
            foreach ($response['Data'] as $item) {
                $raw = $item['RAW'] ?? [];
                $display = $item['DISPLAY'] ?? [];
                $coinInfo = $item['CoinInfo'] ?? [];
                
                CryptoCompareMarkets::updateOrCreate([
                    'symbol' => $coinInfo['Name'] ?? '',
                ], [
                    'symbol' => $coinInfo['Name'] ?? '',
                    'name' => $coinInfo['FullName'] ?? '',
                    'internal' => isset($coinInfo['Internal']) ? (bool)$coinInfo['Internal'] : false,
                    'image_url' => $coinInfo['ImageUrl'] ?? null,
                    'url' => $coinInfo['Url'] ?? null,
                    'algorithm' => $coinInfo['Algorithm'] ?? null,
                    'proof_type' => $coinInfo['ProofType'] ?? null,
                    'net_hashes_per_second' => $coinInfo['NetHashesPerSecond'] ?? null,
                    'block_number' => $coinInfo['BlockNumber'] ?? null,
                    'block_time' => $coinInfo['BlockTime'] ?? null,
                    'block_reward' => $coinInfo['BlockReward'] ?? null,
                    'asset_launch_date' => isset($coinInfo['AssetLaunchDate']) ? new Carbon($coinInfo['AssetLaunchDate']) : null,
                    'max_supply' => $coinInfo['MaxSupply'] ?? null,
                    'mkt_cap_penalty' => $coinInfo['MktCapPenalty'] ?? null,
                    'is_trading' => isset($coinInfo['IsTrading']) ? (bool)$coinInfo['IsTrading'] : false,
                    'total_coin_supply' => $coinInfo['TotalCoinSupply'] ?? null,
                    'pre_mined_value' => $coinInfo['PreMinedValue'] ?? null,
                    'total_coins_free_float' => $coinInfo['TotalCoinsFreeFloat'] ?? null,
                    'sort_order' => $coinInfo['SortOrder'] ?? null,
                    'sponsored' => isset($coinInfo['Sponsored']) ? (bool)$coinInfo['Sponsored'] : false,
                    'price_usd' => isset($raw['USD']) ? $raw['USD']['PRICE'] : null,
                    'volume_24h_usd' => isset($raw['USD']) ? $raw['USD']['VOLUME24HOUR'] : null,
                    'market_cap_usd' => isset($raw['USD']) ? $raw['USD']['MKTCAP'] : null,
                    'change_24h_usd' => isset($raw['USD']) ? $raw['USD']['CHANGE24HOUR'] : null,
                    'change_pct_24h_usd' => isset($raw['USD']) ? $raw['USD']['CHANGEPCT24HOUR'] : null,
                    'high_24h_usd' => isset($raw['USD']) ? $raw['USD']['HIGH24HOUR'] : null,
                    'low_24h_usd' => isset($raw['USD']) ? $raw['USD']['LOW24HOUR'] : null,
                    'open_24h_usd' => isset($raw['USD']) ? $raw['USD']['OPEN24HOUR'] : null,
                    'supply' => isset($raw['USD']) ? $raw['USD']['SUPPLY'] : null,
                    'last_update' => isset($raw['USD']) ? new Carbon($raw['USD']['LASTUPDATE']) : null,
                ]);
            }
        }
    }

    public function exchanges()
    {
        $params = [
            'api_key' => env('COIN_DESK')
        ];

        $response = $this->retrieveData('https://min-api.cryptocompare.com/data/exchanges/general', $params);

        if (isset($response['Data'])) {
            foreach ($response['Data'] as $exchange) {
                // Ensure all values are properly converted to appropriate types
                $data = [
                    'name' => (string)($exchange['Name'] ?? ''),
                    'internal_name' => (string)($exchange['InternalName'] ?? ''),
                    'url' => $exchange['Url'] ?? null,
                    'logo_url' => $exchange['LogoUrl'] ?? null,
                    'affiliate_url' => $exchange['AffiliateUrl'] ?? null,
                    'country' => $exchange['Country'] ?? null,
                    'centralized' => isset($exchange['Centralized']) ? (bool)$exchange['Centralized'] : false,
                    'internal_note' => $exchange['InternalNote'] ?? null,
                    'item_type' => is_array($exchange['ItemType'] ?? null) ? json_encode($exchange['ItemType']) : ($exchange['ItemType'] ?? null),
                    'grade' => $exchange['Grade'] ?? null,
                    'grade_points' => is_numeric($exchange['GradePoints'] ?? null) ? (int)round($exchange['GradePoints']) : null,
                    'grade_points_split' => is_array($exchange['GradePointsSplit'] ?? null) ? json_encode($exchange['GradePointsSplit']) : null,
                    'sort_order' => is_numeric($exchange['SortOrder'] ?? null) ? (int)$exchange['SortOrder'] : null,
                    'sponsored' => isset($exchange['Sponsored']) ? (bool)$exchange['Sponsored'] : false,
                    'recommended' => isset($exchange['Recommended']) ? (bool)$exchange['Recommended'] : false,
                    'description' => $exchange['Description'] ?? null,
                    'features' => is_array($exchange['Features'] ?? null) ? json_encode($exchange['Features']) : null,
                    'collection' => $exchange['Collection'] ?? null,
                    'data_start' => isset($exchange['DataStart']) ? new Carbon($exchange['DataStart']) : null,
                    'data_end' => isset($exchange['DataEnd']) ? new Carbon($exchange['DataEnd']) : null,
                    'data_quote_start' => isset($exchange['DataQuoteStart']) ? new Carbon($exchange['DataQuoteStart']) : null,
                    'data_quote_end' => isset($exchange['DataQuoteEnd']) ? new Carbon($exchange['DataQuoteEnd']) : null,
                    'data_orderbook_start' => isset($exchange['DataOrderbookStart']) ? new Carbon($exchange['DataOrderbookStart']) : null,
                    'data_orderbook_end' => isset($exchange['DataOrderbookEnd']) ? new Carbon($exchange['DataOrderbookEnd']) : null,
                    'data_trade_start' => isset($exchange['DataTradeStart']) ? new Carbon($exchange['DataTradeStart']) : null,
                    'data_trade_end' => isset($exchange['DataTradeEnd']) ? new Carbon($exchange['DataTradeEnd']) : null,
                    'data_symbols_count' => is_numeric($exchange['DataSymbolsCount'] ?? null) ? (int)$exchange['DataSymbolsCount'] : null,
                    'volume_1hrs_usd' => is_numeric($exchange['Volume1hrsUsd'] ?? null) ? (float)$exchange['Volume1hrsUsd'] : null,
                    'volume_1day_usd' => is_numeric($exchange['Volume1dayUsd'] ?? null) ? (float)$exchange['Volume1dayUsd'] : null,
                    'volume_1mth_usd' => is_numeric($exchange['Volume1mthUsd'] ?? null) ? (float)$exchange['Volume1mthUsd'] : null,
                ];

                // Remove any null values that might cause issues
                $data = array_filter($data, function($value) {
                    return $value !== null;
                });

                CryptoCompareExchanges::updateOrCreate([
                    'name' => $data['name'],
                ], $data);
            }
        }
    }

    public function news()
    {
        $params = [
            'api_key' => env('COIN_DESK'),
            'feeds' => 'ALL',
            'categories' => 'ALL',
            'excludeCategories' => 'Sponsored',
            'lTs' => time() - (7 * 24 * 60 * 60), // Last 7 days
            'lang' => 'EN'
        ];

        $response = $this->retrieveData('https://min-api.cryptocompare.com/data/v2/news/', $params);

        if (isset($response['Data'])) {
            foreach ($response['Data'] as $item) {
                CryptoCompareNews::updateOrCreate([
                    'id' => $item['id'],
                ], [
                    'id' => $item['id'],
                    'guid' => $item['guid'],
                    'published_on' => new Carbon($item['published_on']),
                    'imageurl' => $item['imageurl'],
                    'title' => $item['title'],
                    'url' => $item['url'],
                    'source' => $item['source'],
                    'body' => $item['body'],
                    'tags' => $item['tags'],
                    'categories' => $item['categories'],
                    'upvotes' => $item['upvotes'],
                    'downvotes' => $item['downvotes'],
                    'lang' => $item['lang'],
                    'source_info' => json_encode($item['source_info'] ?? []),
                ]);
            }
        }
    }

    public function topPairs()
    {
        $params = [
            'api_key' => env('COIN_DESK'),
            'fsym' => 'BTC',
            'limit' => 50
        ];

        $response = $this->retrieveData('https://min-api.cryptocompare.com/data/top/pairs', $params);

        if (isset($response['Data'])) {
            foreach ($response['Data'] as $item) {
                CryptoCompareTopPairs::updateOrCreate([
                    'exchange' => $item['exchange'],
                    'from_symbol' => $item['fromSymbol'],
                    'to_symbol' => $item['toSymbol'],
                ], [
                    'exchange' => $item['exchange'],
                    'from_symbol' => $item['fromSymbol'],
                    'to_symbol' => $item['toSymbol'],
                    'volume_24h' => $item['volume24h'],
                    'volume_24h_to' => $item['volume24hTo'],
                    'open_24h' => array_key_exists('open24h', $item) ? $item['open24h'] : 0,
                    'high_24h' => array_key_exists('high24h', $item) ? $item['high24h'] : 0,
                    'low_24h' => array_key_exists('low24h', $item) ? $item['low24h'] : 0,
                    'change_24h' => array_key_exists('change24h', $item) ? $item['change24h'] : 0,
                    'change_pct_24h' => array_key_exists('changepct24h', $item)  ? $item['changepct24h'] : 0,
                    'from_display_name' => array_key_exists('fromDisplayName', $item) ? $item['fromDisplayName'] : '',
                    'to_display_name' => array_key_exists('toDisplayName', $item) ? $item['toDisplayName'] : '',
                    'flags' => array_key_exists('flags', $item) ? $item['flags'] : '',
                    'last_update' => array_key_exists('lastUpdate', $item) ? new Carbon($item['lastUpdate']) : null,
                ]);
            }
        }
    }
} 