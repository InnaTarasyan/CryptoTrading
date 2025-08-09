<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoinMarketCal\CoinMarketCal;
use App\Models\CoinMarketCal\CoinMarketCalEvents;
use Illuminate\Http\Request;

class CoinMarketCalApiController extends Controller
{
    public function coinmarketcals(Request $request)
    {
        $query = CoinMarketCal::query();
        
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

    public function events(Request $request)
    {
        $query = CoinMarketCalEvents::query();
        
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
