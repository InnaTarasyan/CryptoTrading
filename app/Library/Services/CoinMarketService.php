<?php

namespace App\Library\Services;

use App\Models\Airdrops;
use App\Models\Category;
use App\Models\CategoryDetails;
use App\Models\CategoryItems;
use App\Models\Content;
use App\Models\ExchangeListingLatest;
use App\Models\ExchangeMap;
use App\Models\ListingsLatest;
use App\Models\Map;
use App\Models\NewItems;
use App\Models\GainersLosers;
use App\Models\Posts;
use App\Models\TrandingLatest;
use App\Models\Coinmarketcap;
use App\Library\Services\Base\BaseService;
use App\Models\MostVisited;
use App\Models\TrendingTokens;
use App\Models\TrendingTopic;
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
        dd($response);

        Coinmarketcap::truncate();

        foreach (json_decode($response)->data as  $data){
            dump($data);
            continue;
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
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'airdrops';
        $airdrops = $this->retrieveCoinMarketcapData($url, null);
        foreach ($airdrops->data->data as $item) {
            Airdrops::updateOrCreate(['api_id' => $item->id],[
                'api_id'             => $item->id,
                'project_name'       => $item->project_name,
                'description'        => $item->description,
                'status'             => $item->status,
                'coin'               => json_encode($item->coin, true),
                'start_date'         => new Carbon($item->start_date),
                'end_date'           => new Carbon($item->end_date),
                'total_prize'        => $item->total_prize,
                'winner_count'       => $item->winner_count,
                'link'               => $item->link,
            ]);
        }
    }

    public function categories()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'categories';
        $categories = $this->retrieveCoinMarketcapData($url, null);

        foreach ($categories->data->data as $item) {
            Category::updateOrCreate(['api_id' => $item->id],[
                'api_id'             => $item->id,
                'name'               => $item->name,
                'title'              => $item->title,
                'description'        => $item->description,
                'num_tokens'         => $item->num_tokens,
                'avg_price_change'   => $item->avg_price_change,
                'market_cap'         => $item->market_cap,
                'market_cap_change'  => $item->market_cap_change,
                'volume'             => $item->volume,
                'volume_change'      => $item->volume_change,
                'last_updated'       => $item->last_updated,
            ]);
        }
    }

    public function category($id)
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'category';

        $params = [
            'id' => $id,
        ];

        $data = $this->retrieveCoinMarketcapData($url, $params);
        foreach ($data->data as $index => $item) {
            if(!$item->id) {
                continue;
            }

            Category::updateOrCreate(['api_id' => $item->id],[
                'api_id'             => $item->id,
                'name'               => $item->name,
                'title'              => $item->title,
                'description'        => $item->description,
                'num_tokens'         => $item->num_tokens,
                'avg_price_change'   => $item->avg_price_change,
                'market_cap'         => $item->market_cap,
                'market_cap_change'  => $item->market_cap_change,
                'volume'             => $item->volume,
                'volume_change'      => $item->volume_change,
                'coins'              => json_encode($item->coins, true),
            ]);
        }
    }

    public function map()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'map';
        $data = $this->retrieveCoinMarketcapData($url, null);
        foreach ($data->data as $item) {
            Map::updateOrCreate(['api_id' => $item->id],[
                'api_id'                => $item->id,
                'rank'                  => $item->rank,
                'name'                  => $item->name,
                'symbol'                => $item->symbol,
                'slug'                  => $item->slug,
                'is_active'             => boolval($item->is_active),
                'first_historical_data' => new Carbon($item->first_historical_data),
                'last_historical_data'  => new Carbon($item->last_historical_data),
                'platform'              => json_encode($item->platform),
             ]);
        }
    }

    public function info()
    {
        $url = env('COIN_MARKET_CAP_CURRENCY_URL').'info';
        $slugs = MostVisited::pluck('slug')->toArray();

        foreach ($slugs as $slug) {
            $params = [
                "symbol" => 'bitcoin',
            ];

            $data = $this->retrieveCoinMarketcapData($url, $params);
            dd($data);
        }
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
        $data = $this->retrieveCoinMarketcapData($url, $params);
        dump($data);
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
        $exchangeListingLatest = $this->retrieveCoinMarketcapData($url, null);
        $data = $exchangeListingLatest->data;
        foreach ($data as $item) {
            ExchangeListingLatest::updateOrCreate(['api_id' => $item->id],[
                'api_id'             => $item->id,
                'name'               => $item->name,
                'slug'               => $item->slug,
                'fiats'              => json_encode($item->fiats),
                'traffic_score'      => $item->traffic_score,
                'rank'               => $item->rank,
                'exchange_score'     => $item->exchange_score,
                'liquidity_score'    => $item->liquidity_score,
                'last_updated'       => new Carbon($item->last_updated),
                'quote'              => json_encode($item->quote),
            ]);
        }
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
        $data = $this->retrieveCoinMarketcapData($url, null);
        foreach ($data->data as $item) {
           ListingsLatest::updateOrCreate(['api_id' => $item->id],[
               'api_id'             => $item->id,
               'name'               => $item->name,
               'slug'               => $item->slug,
               'symbol'             => $item->symbol,
               'score'              => $item->score,
               'grade'              => $item->grade,
               'last_updated'       => new Carbon($item->last_updated),
           ]);
        }
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
        $symbols = MostVisited::pluck('symbol')->toArray();

        foreach ($symbols as $symbol) {
            $params = [
                "symbol" => $symbol,
            ];

            $data = $this->retrieveCoinMarketcapData($url, $params);

            foreach ($data->data as $datum) {
                foreach ($datum as $item) {
                    Content::create([
                        'cover'              => $item->cover,
                        'assets'             => json_encode($item->assets, true),
                        'released_at'        => new Carbon($item->released_at),
                        'title'              => $item->title,
                        'subtitle'           => $item->subtitle,
                        'created_at'         => new Carbon($item->created_at),
                        'type'               => $item->type,
                        'source_name'        => $item->source_name,
                        'source_url'         => $item->source_url,
                    ]);
                }
            }
        }
    }

    public function trendingToken()
    {
        $url = env('COIN_MARKET_CAP_URL').'community/trending/token';
        $trendingTokens = $this->retrieveCoinMarketcapData($url, null);
        $data = $trendingTokens->data;
        foreach ($data as $item) {
          TrendingTokens::updateOrCreate(['api_id' => $item->id],[
              'api_id'             => $item->id,
              'name'               => $item->name,
              'slug'               => $item->slug,
              'symbol'             => $item->symbol,
              'cmc_rank'           => $item->cmc_rank,
              'rank'               => $item->rank,
          ]);
        }
    }


    public function trendingTopic()
    {
        $url = env('COIN_MARKET_CAP_URL').'community/trending/topic';
        $trendingTopics = $this->retrieveCoinMarketcapData($url, null);
        $data = $trendingTopics->data;
        foreach ($data as $item) {
            TrendingTopic::updateOrCreate([
                'rank'               => $item->rank,
                'topic'              => $item->topic,
            ],[
                'rank'               => $item->rank,
                'topic'              => $item->topic,
            ]);
        }
    }

    public function postsComments()
    {
        $url = env('COIN_MARKET_CAP_URL').'content/posts/comments';

        $posts = Posts::all();
        foreach ($posts as $post) {
            $params = [
                'post_id' => $post->post_id,
            ];

            $data = $this->retrieveCoinMarketcapData($url, $params);
            dump($data);
        }
    }

    public function postsLatest()
    {
        $url = env('COIN_MARKET_CAP_URL').'content/posts/latest';
        $slugs = MostVisited::pluck('slug')->toArray();

        foreach ($slugs as $slug) {
            $params = [
                "symbol" => $slug,
            ];

            $data = $this->retrieveCoinMarketcapData($url, $params);
            foreach ($data->data as $index => $datum) {
                foreach ($datum->list as $indexInner => $item) {
                    Posts::updateOrCreate(['post_id' => $item->post_id],[
                        'post_id'            => $item->post_id,
                        'comments_url'       => $item->comments_url,
                        'owner'              => json_encode($item->owner),
                        'text_content'       => $item->text_content,
                        'photos'             => json_encode($item->photos),
                        'comment_count'      => $item->comment_count,
                        'like_count'         => $item->like_count,
                        'post_time'          => $item->post_time,
                        'currencies'         => json_encode($item->currencies),
                        'language_code'      => $item->language_code,
                    ]);
                }
            }
        }
    }

    public function postsTop()
    {
        $url = env('COIN_MARKET_CAP_URL').'content/posts/top';
        $slugs = MostVisited::pluck('slug')->toArray();

        foreach ($slugs as $slug) {
            $params = [
                "symbol" => $slug,
            ];

            $data = $this->retrieveCoinMarketcapData($url, $params);
            foreach ($data->data as $index => $datum) {
              foreach ($datum->list as $indexInner => $item) {
                  Posts::updateOrCreate(['post_id' => $item->post_id],[
                      'post_id'            => $item->post_id,
                      'comments_url'       => $item->comments_url,
                      'owner'              => json_encode($item->owner),
                      'text_content'       => $item->text_content,
                      'photos'             => json_encode($item->photos),
                      'comment_count'      => $item->comment_count,
                      'like_count'         => $item->like_count,
                      'post_time'          => $item->post_time,
                      'currencies'         => json_encode($item->currencies),
                      'language_code'      => $item->language_code,
                  ]);
              }
            }
        }
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
