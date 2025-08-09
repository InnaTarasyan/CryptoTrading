<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\CoingeckoExchanges;
use App\Models\CoinGecko\CoinGeckoCoin;
use App\Models\CoinGecko\CoinGeckoExchangeRates;
use App\Models\CoinGecko\CoinGeckoMarkets;
use App\Models\CoinGecko\CoinGeckoTrending;
use App\Models\CoinGecko\Derivatives;
use App\Models\CoinGecko\DerivativesExchanges;
use App\Models\CoinGecko\Nfts;
use Illuminate\Http\Request;

class CoinGeckoApiController extends Controller
{
    public function exchanges(Request $request)
    {
        $query = CoingeckoExchanges::query();
        
        // Add pagination
        $perPage = min($request->get('per_page', 50), 100);
        $data = $query->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ]
        ]);
    }

    public function coins(Request $request)
    {
        $query = CoinGeckoCoin::query();
        
        $perPage = min($request->get('per_page', 50), 100);
        $data = $query->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ]
        ]);
    }

    public function exchangeRates(Request $request)
    {
        $query = CoinGeckoExchangeRates::query();
        
        $perPage = min($request->get('per_page', 50), 100);
        $data = $query->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ]
        ]);
    }

    public function markets(Request $request)
    {
        $query = CoinGeckoMarkets::query();
        
        $perPage = min($request->get('per_page', 50), 100);
        $data = $query->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ]
        ]);
    }

    public function trendings(Request $request)
    {
        $query = CoinGeckoTrending::query();
        
        $perPage = min($request->get('per_page', 50), 100);
        $data = $query->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ]
        ]);
    }

    public function derivatives(Request $request)
    {
        $query = Derivatives::query();
        
        $perPage = min($request->get('per_page', 50), 100);
        $data = $query->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ]
        ]);
    }

    public function derivativesExchanges(Request $request)
    {
        $query = DerivativesExchanges::query();
        
        $perPage = min($request->get('per_page', 50), 100);
        $data = $query->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ]
        ]);
    }

    public function nfts(Request $request)
    {
        $query = Nfts::query();
        
        $perPage = min($request->get('per_page', 50), 100);
        $data = $query->paginate($perPage);
        
        return response()->json([
            'status' => 'success',
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ]
        ]);
    }
}
