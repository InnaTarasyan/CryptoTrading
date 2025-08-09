<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TwitterMessages;
use Illuminate\Http\Request;

class TwitterApiController extends Controller
{
    public function twitterMessages(Request $request)
    {
        $query = TwitterMessages::query();
        
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
}
