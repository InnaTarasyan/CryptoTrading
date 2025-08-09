<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LiveCoinWatch\Fiats;
use App\Models\LiveCoinWatch\LiveCoinHistory;
use App\Models\LiveCoinWatch\LiveCoinWatch;
use Illuminate\Http\Request;

class LiveCoinWatchApiController extends Controller
{
    public function fiats(Request $request)
    {
        $query = Fiats::query();
        
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

    public function liveCoinHistories(Request $request)
    {
        $query = LiveCoinHistory::query();
        
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

    public function liveCoinWatches(Request $request)
    {
        $query = LiveCoinWatch::query();
        
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
