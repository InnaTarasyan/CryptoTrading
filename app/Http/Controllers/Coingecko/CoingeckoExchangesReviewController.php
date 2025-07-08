<?php

namespace App\Http\Controllers\Coingecko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoinGecko\CoingeckoExchangesReview;

class CoingeckoExchangesReviewController extends Controller
{
    public function index(Request $request)
    {
        $exchangeCode = $request->query('exchange_code');
        $query = CoingeckoExchangesReview::query();
        if ($exchangeCode) {
            $query->where('exchange_code', $exchangeCode);
        }
        $reviews = $query->orderBy('created_at', 'desc')->get();
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exchange_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'country' => 'nullable|string|max:255',
            'experience_level' => 'nullable|string|max:255',
            'pros' => 'nullable|string',
            'cons' => 'nullable|string',
            'recommend' => 'nullable|in:0,1,true,false',
        ]);
        $review = CoingeckoExchangesReview::create($validated);
        return response()->json(['success' => true, 'review' => $review]);
    }
} 