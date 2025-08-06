<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LiveCoinWatch\LiveCoinWatch;
use App\Models\LiveCoinWatch\LiveCoinHistory;
use App\Models\LiveCoinWatch\Fiats;
use App\Models\CoinGecko\CoinGeckoCoin;
use App\Models\CoinGecko\CoinGeckoMarkets;
use App\Models\CoinGecko\CoinGeckoExchangeRates;
use App\Models\CoinGecko\CoinGeckoTrending;
use App\Models\CoinGecko\CoingeckoExchanges;
use App\Models\CoinMarketCal\CoinMarketCal;
use App\Models\CoinMarketCal\CoinMarketCalEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables as Datatables;

class MarketsComparizonController extends Controller
{

    public function index()
    {
        return view('marketscomparizon');
    }

    /**
     * Compare data from LiveCoinWatch, CoinGecko, and CoinMarketCal sources
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function compareData()
    {
        try {
            // Cache the comparison data for 5 minutes to avoid repeated heavy queries
            $cacheKey = 'crypto_comparison_data';
            $comparisonData = Cache::remember($cacheKey, 300, function () {
                return $this->generateComparisonData();
            });

            return response()->json([
                'success' => true,
                'data' => $comparisonData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating comparison data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate comprehensive comparison data from all sources
     *
     * @return array
     */
    private function generateComparisonData()
    {
        $data = [];

        // 1. LiveCoinWatch Data Analysis
        $data['livecoinwatch'] = $this->getLiveCoinWatchData();

        // 2. CoinGecko Data Analysis
        $data['coingecko'] = $this->getCoinGeckoData();

        // 3. CoinMarketCal Data Analysis
        $data['coinmarketcal'] = $this->getCoinMarketCalData();

        // 4. Cross-platform Comparison
        $data['comparison'] = $this->getCrossPlatformComparison();

        // 5. Market Trends Analysis
        $data['trends'] = $this->getMarketTrends();

        // 6. Top Performers Analysis
        $data['top_performers'] = $this->getTopPerformers();

        // 7. Volume Analysis
        $data['volume_analysis'] = $this->getVolumeAnalysis();

        // 8. Market Cap Distribution
        $data['market_cap_distribution'] = $this->getMarketCapDistribution();

        return $data;
    }

    /**
     * Get LiveCoinWatch data analysis
     *
     * @return array
     */
    private function getLiveCoinWatchData()
    {
        $livecoinwatch = LiveCoinWatch::query()
            ->join('live_coin_histories', 'live_coin_histories.code', '=', 'live_coin_watches.code')
            ->where('rate', '>', 0)
            ->orderBy('rate', 'DESC')
            ->limit(50)
            ->get();

        $fiats = Fiats::all();

        return [
            'total_coins' => $livecoinwatch->count(),
            'total_market_cap' => $livecoinwatch->sum('cap'),
            'total_volume' => $livecoinwatch->sum('volume'),
            'average_price' => $livecoinwatch->avg('rate'),
            'price_range' => [
                'min' => $livecoinwatch->min('rate'),
                'max' => $livecoinwatch->max('rate')
            ],
            'top_coins_by_price' => $livecoinwatch->take(10)->map(function($coin) {
                return [
                    'code' => $coin->code,
                    'price' => $coin->rate,
                    'market_cap' => $coin->cap,
                    'volume' => $coin->volume
                ];
            }),
            'fiats_count' => $fiats->count(),
            'fiats_list' => $fiats->pluck('code')->toArray()
        ];
    }

    /**
     * Get CoinGecko data analysis
     *
     * @return array
     */
    private function getCoinGeckoData()
    {
        $markets = CoinGeckoMarkets::orderBy('market_cap', 'DESC')->limit(50)->get();
        $coins = CoinGeckoCoin::all();
        $exchanges = CoingeckoExchanges::all();
        $trendings = CoinGeckoTrending::all();

        return [
            'total_coins' => $coins->count(),
            'total_markets' => $markets->count(),
            'total_exchanges' => $exchanges->count(),
            'total_trending' => $trendings->count(),
            'market_cap_stats' => [
                'total' => $markets->sum('market_cap'),
                'average' => $markets->avg('market_cap'),
                'median' => $markets->median('market_cap')
            ],
            'volume_stats' => [
                'total' => $markets->sum('total_volume'),
                'average' => $markets->avg('total_volume')
            ],
            'price_change_24h' => [
                'positive' => $markets->where('price_change_percentage_24h', '>', 0)->count(),
                'negative' => $markets->where('price_change_percentage_24h', '<', 0)->count(),
                'neutral' => $markets->where('price_change_percentage_24h', '=', 0)->count()
            ],
            'top_gainers' => $markets->where('price_change_percentage_24h', '>', 0)
                ->sortByDesc('price_change_percentage_24h')
                ->take(10)
                ->map(function($market) {
                    return [
                        'name' => $market->name,
                        'symbol' => $market->api_id,
                        'price_change' => $market->price_change_percentage_24h,
                        'current_price' => $market->current_price
                    ];
                }),
            'top_losers' => $markets->where('price_change_percentage_24h', '<', 0)
                ->sortBy('price_change_percentage_24h')
                ->take(10)
                ->map(function($market) {
                    return [
                        'name' => $market->name,
                        'symbol' => $market->api_id,
                        'price_change' => $market->price_change_percentage_24h,
                        'current_price' => $market->current_price
                    ];
                })
        ];
    }

    /**
     * Get CoinMarketCal data analysis
     *
     * @return array
     */
    private function getCoinMarketCalData()
    {
        $coinmarketcals = CoinMarketCal::all();
        $events = CoinMarketCalEvents::all();

        return [
            'total_coins' => $coinmarketcals->count(),
            'total_events' => $events->count(),
            'rank_distribution' => [
                'top_10' => $coinmarketcals->where('rank', '<=', 10)->count(),
                'top_50' => $coinmarketcals->where('rank', '<=', 50)->count(),
                'top_100' => $coinmarketcals->where('rank', '<=', 100)->count(),
                'others' => $coinmarketcals->where('rank', '>', 100)->count()
            ],
            'index_stats' => [
                'hot_index_avg' => $coinmarketcals->avg('hot_index'),
                'trending_index_avg' => $coinmarketcals->avg('trending_index'),
                'significant_index_avg' => $coinmarketcals->avg('significant_index')
            ],
            'top_ranked_coins' => $coinmarketcals->sortBy('rank')
                ->take(20)
                ->map(function($coin) {
                    return [
                        'name' => $coin->name,
                        'symbol' => $coin->symbol,
                        'rank' => $coin->rank,
                        'hot_index' => $coin->hot_index,
                        'trending_index' => $coin->trending_index
                    ];
                })
        ];
    }

    /**
     * Get cross-platform comparison data
     *
     * @return array
     */
    private function getCrossPlatformComparison()
    {
        $livecoinwatch = LiveCoinWatch::query()
            ->join('live_coin_histories', 'live_coin_histories.code', '=', 'live_coin_watches.code')
            ->where('rate', '>', 0)
            ->orderBy('rate', 'DESC')
            ->limit(30)
            ->get();

        $coingecko = CoinGeckoMarkets::orderBy('market_cap', 'DESC')->limit(30)->get();

        // Find common coins by symbol (simplified matching)
        $commonCoins = [];
        foreach ($livecoinwatch as $lcw) {
            foreach ($coingecko as $cg) {
                if (strtolower($lcw->code) === strtolower($cg->api_id)) {
                    $commonCoins[] = [
                        'symbol' => strtoupper($lcw->code),
                        'livecoinwatch_price' => $lcw->rate,
                        'coingecko_price' => $cg->current_price,
                        'price_difference' => abs($lcw->rate - $cg->current_price),
                        'price_difference_percentage' => $cg->current_price > 0 ?
                            (abs($lcw->rate - $cg->current_price) / $cg->current_price) * 100 : 0,
                        'livecoinwatch_market_cap' => $lcw->cap,
                        'coingecko_market_cap' => $cg->market_cap
                    ];
                    break;
                }
            }
        }

        return [
            'common_coins_count' => count($commonCoins),
            'average_price_difference' => count($commonCoins) > 0 ?
                collect($commonCoins)->avg('price_difference_percentage') : 0,
            'common_coins_data' => $commonCoins,
            'platform_coverage' => [
                'livecoinwatch_only' => $livecoinwatch->count() - count($commonCoins),
                'coingecko_only' => $coingecko->count() - count($commonCoins),
                'both_platforms' => count($commonCoins)
            ]
        ];
    }

    /**
     * Get market trends analysis
     *
     * @return array
     */
    private function getMarketTrends()
    {
        $markets = CoinGeckoMarkets::orderBy('market_cap', 'DESC')->limit(100)->get();

        $trends = [
            'price_movement' => [
                'gaining' => $markets->where('price_change_percentage_24h', '>', 0)->count(),
                'losing' => $markets->where('price_change_percentage_24h', '<', 0)->count(),
                'stable' => $markets->where('price_change_percentage_24h', '=', 0)->count()
            ],
            'market_cap_movement' => [
                'gaining' => $markets->where('market_cap_change_percentage_24h', '>', 0)->count(),
                'losing' => $markets->where('market_cap_change_percentage_24h', '<', 0)->count(),
                'stable' => $markets->where('market_cap_change_percentage_24h', '=', 0)->count()
            ],
            'volume_trends' => [
                'high_volume' => $markets->where('total_volume', '>', 1000000000)->count(), // > 1B
                'medium_volume' => $markets->whereBetween('total_volume', [100000000, 1000000000])->count(), // 100M - 1B
                'low_volume' => $markets->where('total_volume', '<', 100000000)->count() // < 100M
            ]
        ];

        return $trends;
    }

    /**
     * Get top performers analysis
     *
     * @return array
     */
    private function getTopPerformers()
    {
        $markets = CoinGeckoMarkets::orderBy('market_cap', 'DESC')->limit(50)->get();

        return [
            'by_market_cap' => $markets->take(10)->map(function($market) {
                return [
                    'name' => $market->name,
                    'symbol' => $market->api_id,
                    'market_cap' => $market->market_cap,
                    'rank' => $market->market_cap_rank
                ];
            }),
            'by_volume' => $markets->sortByDesc('total_volume')->take(10)->map(function($market) {
                return [
                    'name' => $market->name,
                    'symbol' => $market->api_id,
                    'volume' => $market->total_volume,
                    'market_cap' => $market->market_cap
                ];
            }),
            'by_price_change' => $markets->sortByDesc('price_change_percentage_24h')->take(10)->map(function($market) {
                return [
                    'name' => $market->name,
                    'symbol' => $market->api_id,
                    'price_change' => $market->price_change_percentage_24h,
                    'current_price' => $market->current_price
                ];
            })
        ];
    }

    /**
     * Get volume analysis
     *
     * @return array
     */
    private function getVolumeAnalysis()
    {
        $livecoinwatch = LiveCoinWatch::query()
            ->join('live_coin_histories', 'live_coin_histories.code', '=', 'live_coin_watches.code')
            ->where('rate', '>', 0)
            ->orderBy('volume', 'DESC')
            ->limit(50)
            ->get();

        $coingecko = CoinGeckoMarkets::orderBy('total_volume', 'DESC')->limit(50)->get();

        return [
            'livecoinwatch_volume' => [
                'total' => $livecoinwatch->sum('volume'),
                'average' => $livecoinwatch->avg('volume'),
                'top_10_volume' => $livecoinwatch->take(10)->sum('volume'),
                'top_10_percentage' => $livecoinwatch->sum('volume') > 0 ?
                    ($livecoinwatch->take(10)->sum('volume') / $livecoinwatch->sum('volume')) * 100 : 0
            ],
            'coingecko_volume' => [
                'total' => $coingecko->sum('total_volume'),
                'average' => $coingecko->avg('total_volume'),
                'top_10_volume' => $coingecko->take(10)->sum('total_volume'),
                'top_10_percentage' => $coingecko->sum('total_volume') > 0 ?
                    ($coingecko->take(10)->sum('total_volume') / $coingecko->sum('total_volume')) * 100 : 0
            ],
            'volume_distribution' => [
                'high' => $coingecko->where('total_volume', '>', 1000000000)->count(),
                'medium' => $coingecko->whereBetween('total_volume', [100000000, 1000000000])->count(),
                'low' => $coingecko->where('total_volume', '<', 100000000)->count()
            ]
        ];
    }

    /**
     * Get market cap distribution
     *
     * @return array
     */
    private function getMarketCapDistribution()
    {
        $markets = CoinGeckoMarkets::orderBy('market_cap', 'DESC')->limit(100)->get();

        return [
            'distribution' => [
                'mega_cap' => $markets->where('market_cap', '>', 10000000000)->count(), // > 10B
                'large_cap' => $markets->whereBetween('market_cap', [1000000000, 10000000000])->count(), // 1B - 10B
                'mid_cap' => $markets->whereBetween('market_cap', [100000000, 1000000000])->count(), // 100M - 1B
                'small_cap' => $markets->whereBetween('market_cap', [10000000, 100000000])->count(), // 10M - 100M
                'micro_cap' => $markets->where('market_cap', '<', 10000000)->count() // < 10M
            ],
            'total_market_cap' => $markets->sum('market_cap'),
            'average_market_cap' => $markets->avg('market_cap'),
            'median_market_cap' => $markets->median('market_cap'),
            'market_cap_concentration' => [
                'top_10_percentage' => $markets->sum('market_cap') > 0 ?
                    ($markets->take(10)->sum('market_cap') / $markets->sum('market_cap')) * 100 : 0,
                'top_50_percentage' => $markets->sum('market_cap') > 0 ?
                    ($markets->take(50)->sum('market_cap') / $markets->sum('market_cap')) * 100 : 0
            ]
        ];
    }

    /**
     * Fetch real-time data from external APIs for enhanced comparison
     *
     * @return array
     */
    private function fetchExternalData()
    {
        $externalData = [];

        try {
            // Fetch global crypto market data from CoinGecko API
            $response = Http::timeout(10)->get('https://api.coingecko.com/api/v3/global');
            if ($response->successful()) {
                $globalData = $response->json();
                $externalData['global_market'] = [
                    'total_market_cap' => $globalData['data']['total_market_cap']['usd'] ?? 0,
                    'total_volume' => $globalData['data']['total_volume']['usd'] ?? 0,
                    'market_cap_percentage' => $globalData['data']['market_cap_percentage']['usd'] ?? 0,
                    'active_cryptocurrencies' => $globalData['data']['active_cryptocurrencies'] ?? 0,
                    'active_exchanges' => $globalData['data']['active_exchanges'] ?? 0
                ];
            }
        } catch (\Exception $e) {
            $externalData['global_market'] = null;
        }

        try {
            // Fetch trending coins from CoinGecko API
            $response = Http::timeout(10)->get('https://api.coingecko.com/api/v3/search/trending');
            if ($response->successful()) {
                $trendingData = $response->json();
                $externalData['trending_coins'] = collect($trendingData['coins'] ?? [])->take(10)->map(function($coin) {
                    return [
                        'name' => $coin['item']['name'],
                        'symbol' => $coin['item']['symbol'],
                        'market_cap_rank' => $coin['item']['market_cap_rank'],
                        'price_btc' => $coin['item']['price_btc']
                    ];
                })->toArray();
            }
        } catch (\Exception $e) {
            $externalData['trending_coins'] = [];
        }

        return $externalData;
    }

    /**
     * Get enhanced comparison data with external API data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEnhancedComparison()
    {
        try {
            $cacheKey = 'enhanced_crypto_comparison_data';
            $comparisonData = Cache::remember($cacheKey, 300, function () {
                $data = $this->generateComparisonData();
                $data['external_data'] = $this->fetchExternalData();
                return $data;
            });

            return response()->json([
                'success' => true,
                'data' => $comparisonData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating enhanced comparison data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed analysis for a specific coin across platforms
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCoinAnalysis(Request $request)
    {
        $symbol = strtolower($request->get('symbol', ''));

        if (empty($symbol)) {
            return response()->json([
                'success' => false,
                'message' => 'Symbol parameter is required'
            ], 400);
        }

        try {
            $analysis = [];

            // LiveCoinWatch data
            $lcwData = LiveCoinWatch::query()
                ->join('live_coin_histories', 'live_coin_histories.code', '=', 'live_coin_watches.code')
                ->where('live_coin_watches.code', 'LIKE', $symbol)
                ->first();

            if ($lcwData) {
                $analysis['livecoinwatch'] = [
                    'price' => $lcwData->rate,
                    'market_cap' => $lcwData->cap,
                    'volume' => $lcwData->volume,
                    'last_updated' => $lcwData->updated_at
                ];
            }

            // CoinGecko data
            $cgData = CoinGeckoMarkets::where('api_id', 'LIKE', $symbol)->first();

            if ($cgData) {
                $analysis['coingecko'] = [
                    'name' => $cgData->name,
                    'current_price' => $cgData->current_price,
                    'market_cap' => $cgData->market_cap,
                    'market_cap_rank' => $cgData->market_cap_rank,
                    'total_volume' => $cgData->total_volume,
                    'price_change_24h' => $cgData->price_change_24h,
                    'price_change_percentage_24h' => $cgData->price_change_percentage_24h,
                    'circulating_supply' => $cgData->circulating_supply,
                    'total_supply' => $cgData->total_supply,
                    'max_supply' => $cgData->max_supply,
                    'ath' => $cgData->ath,
                    'ath_change_percentage' => $cgData->ath_change_percentage,
                    'last_updated' => $cgData->last_updated
                ];
            }

            // CoinMarketCal data
            $cmcData = CoinMarketCal::where('symbol', 'LIKE', strtoupper($symbol))->first();

            if ($cmcData) {
                $analysis['coinmarketcal'] = [
                    'name' => $cmcData->name,
                    'rank' => $cmcData->rank,
                    'hot_index' => $cmcData->hot_index,
                    'trending_index' => $cmcData->trending_index,
                    'significant_index' => $cmcData->significant_index
                ];
            }

            return response()->json([
                'success' => true,
                'symbol' => strtoupper($symbol),
                'analysis' => $analysis
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error analyzing coin: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Advanced Cryptocurrency Price Prediction Page
     * Shows predictions for top coins using DB, external APIs, and advanced models
     */
    public function coinPredictions()
    {
        $topSymbols = [
            'BTC', 'ETH', 'BNB', 'SOL', 'ADA',
//            'XRP', 'DOGE', 'LTC',
//            'TRX', 'DOT', 'AVAX', 'LINK', 'MATIC', 'BCH', 'UNI', 'XLM', 'ATOM', 'FIL', 'ETC', 'HBAR'
        ];
        $days = 7;
        $results = [];
        $errors = [];

        foreach ($topSymbols as $symbol) {
            // 1. Fetch historical data from CoinGecko, fallback to CoinPaprika if not enough data
            $history = collect();
            $marketCap = null;
            $volume24h = null;
            $coingeckoId = $this->getCoinGeckoId($symbol);
            $paprikaId = $this->getCoinPaprikaId($symbol);
            $usedPaprika = false;
            try {
                if ($coingeckoId) {
                    $response = Http::timeout(10)->get("https://api.coingecko.com/api/v3/coins/{$coingeckoId}/market_chart", [
                        'vs_currency' => 'usd',
                        'days' => 60,
                        'interval' => 'daily',
                    ]);
                    if ($response->successful()) {
                        $prices = $response->json('prices');
                        $market_caps = $response->json('market_caps');
                        $volumes = $response->json('total_volumes');
                        $history = collect($prices)->map(function($item) {
                            return [
                                'date' => date('Y-m-d', $item[0] / 1000),
                                'rate' => $item[1],
                            ];
                        });
                        if (is_array($market_caps) && count($market_caps)) {
                            $marketCap = $market_caps[count($market_caps)-1][1];
                        }
                        if (is_array($volumes) && count($volumes)) {
                            $volume24h = $volumes[count($volumes)-1][1];
                        }
                    }
                }
                // Fallback to CoinPaprika if not enough data
                if ($history->count() < 2 && $paprikaId) {
                    $paprikaResp = Http::timeout(10)->get("https://api.coinpaprika.com/v1/tickers/{$paprikaId}/historical", [
                        'start' => now()->subDays(60)->toIso8601String(),
                        'interval' => '1d',
                        'limit' => 60,
                    ]);
                    if ($paprikaResp->successful()) {
                        $prices = $paprikaResp->json();
                        if (!isset($prices['error'])) {
                            $history = collect($prices)->map(function($item) {
                                return [
                                    'date' => isset($item['timestamp']) ? substr($item['timestamp'], 0, 10) : null,
                                    'rate' => $item['close'] ?? null,
                                ];
                            })->filter(fn($row) => $row['date'] && $row['rate'] !== null);
                            $usedPaprika = true;
                        }
                        // else: leave history empty, error will be shown
                    }
                }
                // Fallback to CoinCap if still not enough data
                $coincapId = $this->getCoinCapId($symbol);
                if ($history->count() < 2 && $coincapId) {
                    $start = now()->subDays(60)->startOfDay()->timestamp * 1000;
                    $end = now()->endOfDay()->timestamp * 1000;
                    $capResp = Http::timeout(10)->get("https://api.coincap.io/v2/assets/{$coincapId}/history", [
                        'interval' => 'd1',
                        'start' => $start,
                        'end' => $end,
                    ]);
                    if ($capResp->successful()) {
                        $prices = $capResp->json('data');
                        if (is_array($prices)) {
                            $history = collect($prices)->map(function($item) {
                                return [
                                    'date' => isset($item['date']) ? substr($item['date'], 0, 10) : null,
                                    'rate' => isset($item['priceUsd']) ? (float)$item['priceUsd'] : null,
                                ];
                            })->filter(fn($row) => $row['date'] && $row['rate'] !== null);
                        }
                    }
                }
                // Fallback to CryptoCompare if still not enough data
                $cryptocompareId = $this->getCryptoCompareId($symbol);
                if ($history->count() < 2 && $cryptocompareId) {
                    $ccResp = Http::timeout(10)->get("https://min-api.cryptocompare.com/data/v2/histoday", [
                        'fsym' => $cryptocompareId,
                        'tsym' => 'USD',
                        'limit' => 60,
                    ]);
                    if ($ccResp->successful()) {
                        $ccData = $ccResp->json('Data.Data');
                        if (is_array($ccData)) {
                            $history = collect($ccData)->map(function($item) {
                                return [
                                    'date' => isset($item['time']) ? date('Y-m-d', $item['time']) : null,
                                    'rate' => isset($item['close']) ? (float)$item['close'] : null,
                                ];
                            })->filter(fn($row) => $row['date'] && $row['rate'] !== null);
                        }
                    }
                }
            } catch (\Exception $e) {
                $errors[] = "CoinGecko/Paprika/CoinCap/CryptoCompare error for $symbol: " . $e->getMessage();
            }

            // 2. Internal regression prediction (polynomial fallback to linear)
            $predictions = [];
            if ($history->count() > 7) {
                $n = $history->count();
                $x = range(1, $n);
                $y = $history->pluck('rate')->toArray();
                // Polynomial regression (degree 2)
                $X = array_map(function($xi) { return [$xi, pow($xi,2), 1]; }, $x);
                $Y = $y;
                // Solve normal equations: (X^T X)B = X^T Y
                $XTX = [
                    [array_sum(array_map(function($v){return $v*$v;}, $x)), array_sum(array_map(function($v){return $v*pow($v,2);}, $x)), array_sum($x)],
                    [array_sum(array_map(function($v){return pow($v,2)*$v;}, $x)), array_sum(array_map(function($v){return pow($v,4);}, $x)), array_sum(array_map(function($v){return pow($v,2);}, $x))],
                    [array_sum($x), array_sum(array_map(function($v){return pow($v,2);}, $x)), $n]
                ];
                $XTY = [
                    array_sum(array_map(function($xi,$yi){return $xi*$yi;}, $x, $y)),
                    array_sum(array_map(function($xi,$yi){return pow($xi,2)*$yi;}, $x, $y)),
                    array_sum($y)
                ];
                $B = [0,0,0];
                $det = $XTX[0][0]*($XTX[1][1]*$XTX[2][2]-$XTX[1][2]*$XTX[2][1])
                    -$XTX[0][1]*($XTX[1][0]*$XTX[2][2]-$XTX[1][2]*$XTX[2][0])
                    +$XTX[0][2]*($XTX[1][0]*$XTX[2][1]-$XTX[1][1]*$XTX[2][0]);
                if (abs($det) > 1e-8) {
                    for ($i=0;$i<3;$i++) {
                        $mat = $XTX;
                        $mat[0][$i] = $XTY[0];
                        $mat[1][$i] = $XTY[1];
                        $mat[2][$i] = $XTY[2];
                        $B[$i] = (
                            $mat[0][0]*($mat[1][1]*$mat[2][2]-$mat[1][2]*$mat[2][1])
                            -$mat[0][1]*($mat[1][0]*$mat[2][2]-$mat[1][2]*$mat[2][0])
                            +$mat[0][2]*($mat[1][0]*$mat[2][1]-$mat[1][1]*$mat[2][0])
                        )/$det;
                    }
                } else {
                    $x_sum = array_sum($x);
                    $y_sum = array_sum($y);
                    $xy_sum = array_sum(array_map(function($xi, $yi) { return $xi * $yi; }, $x, $y));
                    $xx_sum = array_sum(array_map(function($xi) { return $xi * $xi; }, $x));
                    $slope = ($n * $xy_sum - $x_sum * $y_sum) / ($n * $xx_sum - $x_sum * $x_sum);
                    $intercept = ($y_sum - $slope * $x_sum) / $n;
                }
                for ($i = 1; $i <= $days; $i++) {
                    $future_x = $n + $i;
                    if (abs($det) > 1e-8) {
                        $predicted = $B[0]*$future_x + $B[1]*pow($future_x,2) + $B[2];
                    } else {
                        $predicted = $slope * $future_x + $intercept;
                    }
                    $predictions[] = [
                        'date' => now()->addDays($i)->toDateString(),
                        'predicted_price' => round($predicted, 4)
                    ];
                }
            }

            // 3. External API (Cryptics.tech)
            $external = null;
            try {
                $cryptics = Http::timeout(10)->get('https://devapi.cryptics.tech/daily_fcast', [ 'pair' => strtolower($symbol) . '/USD' ]);
                if ($cryptics->successful()) {
                    $external = collect($cryptics->json())->map(function($item) {
                        return [
                            'date' => $item['timestamp'],
                            'predicted_price' => round($item['fcast'], 4)
                        ];
                    })->toArray();
                }
            } catch (\Exception $e) {
                $external = null;
            }

            // 4. Volatility (stddev of last 30 days)
            $volatility = null;
            if ($history->count() >= 30) {
                $last30 = $history->slice(-30)->pluck('rate')->toArray();
                $mean = array_sum($last30) / count($last30);
                $variance = array_sum(array_map(function($v) use ($mean) { return pow($v - $mean, 2); }, $last30)) / count($last30);
                $volatility = sqrt($variance);
            }

            $results[] = [
                'symbol' => $symbol,
                'history' => $history,
                'predictions' => $predictions,
                'external' => $external,
                'market_cap' => $marketCap,
                'volume_24h' => $volume24h,
                'volatility' => $volatility
            ];
            if ($history->count() < 2) {
                $errors[] = "Not enough data for $symbol";
            }
        }
        return view('coinpredictions', [
            'results' => $results,
            'errors' => $errors
        ]);
    }

    // Helper to map symbol to CoinGecko ID
    private function getCoinGeckoId($symbol)
    {
        $map = [
            'BTC' => 'bitcoin',
            'ETH' => 'ethereum',
            'BNB' => 'binancecoin',
            'SOL' => 'solana',
            'ADA' => 'cardano',
            'XRP' => 'ripple',
            'DOGE' => 'dogecoin',
            'LTC' => 'litecoin',
            'TRX' => 'tron',
            'DOT' => 'polkadot',
            'AVAX' => 'avalanche-2',
            'LINK' => 'chainlink',
            'MATIC' => 'matic-network',
            'BCH' => 'bitcoin-cash',
            'UNI' => 'uniswap',
            'XLM' => 'stellar',
            'ATOM' => 'cosmos',
            'FIL' => 'filecoin',
            'ETC' => 'ethereum-classic',
            'HBAR' => 'hedera-hashgraph',
        ];
        return $map[strtoupper($symbol)] ?? null;
    }

    // Helper to map symbol to CoinPaprika ID
    private function getCoinPaprikaId($symbol)
    {
        $map = [
            'BTC' => 'btc-bitcoin',
            'ETH' => 'eth-ethereum',
            'BNB' => 'bnb-binance-coin',
            'SOL' => 'sol-solana',
            'ADA' => 'ada-cardano',
        ];
        return $map[strtoupper($symbol)] ?? null;
    }

    // Helper to map symbol to CoinCap ID
    private function getCoinCapId($symbol)
    {
        $map = [
            'BTC' => 'bitcoin',
            'ETH' => 'ethereum',
            'BNB' => 'binance-coin',
            'SOL' => 'solana',
            'ADA' => 'cardano',
        ];
        return $map[strtoupper($symbol)] ?? null;
    }

    // Helper to map symbol to CryptoCompare ID
    private function getCryptoCompareId($symbol)
    {
        $map = [
            'BTC' => 'BTC',
            'ETH' => 'ETH',
            'BNB' => 'BNB',
            'SOL' => 'SOL',
            'ADA' => 'ADA',
        ];
        return $map[strtoupper($symbol)] ?? null;
    }

    public function predictions()
    {
        return view('coinpredictions');
    }
}
