<?php

namespace App\Http\Controllers;

use App\Library\Services\CryptoCompareService;
use App\Models\CryptoCompare\CryptoCompareMarkets;
use App\Models\CryptoCompare\CryptoCompareNews;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CryptoCompareController extends Controller
{
    protected $cryptoCompareService;

    public function __construct(CryptoCompareService $cryptoCompareService)
    {
        $this->cryptoCompareService = $cryptoCompareService;
    }

    /**
     * Get market data
     */
    public function getMarkets(): JsonResponse
    {
        try {
            $markets = CryptoCompareMarkets::orderBy('market_cap_usd', 'desc')
                ->limit(100)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $markets,
                'count' => $markets->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching market data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get news data
     */
    public function getNews(): JsonResponse
    {
        try {
            $news = CryptoCompareNews::orderBy('published_on', 'desc')
                ->limit(50)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $news,
                'count' => $news->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching news data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific coin data
     */
    public function getCoin(Request $request): JsonResponse
    {
        $symbol = strtoupper($request->get('symbol', 'BTC'));

        try {
            $coin = CryptoCompareMarkets::where('symbol', $symbol)->first();

            if (!$coin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Coin not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $coin
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching coin data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Manually trigger data fetch
     */
    public function fetchData(Request $request): JsonResponse
    {
        try {
            if ($request->get('single')) {
                $this->cryptoCompareService->handleSingle();
                $message = 'Single market data fetch completed';
            } else {
                $this->cryptoCompareService->handle();
                $message = 'Full data fetch completed';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test API connection
     */
    public function testConnection(): JsonResponse
    {
        try {
            $this->cryptoCompareService->ping();
            
            return response()->json([
                'success' => true,
                'message' => 'API connection successful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'API connection failed: ' . $e->getMessage()
            ], 500);
        }
    }
} 