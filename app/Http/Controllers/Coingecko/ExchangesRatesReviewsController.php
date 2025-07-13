<?php
namespace App\Http\Controllers\Coingecko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coingecko\ExchangesRatesReview;

class ExchangesRatesReviewsController extends Controller
{
    public function index()
    {
        $reviews = ExchangesRatesReview::orderBy('created_at', 'desc')->take(20)->get();
        return view('coingecko.exchanges_rates', compact('reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
            'user_email' => 'required|email|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'required|string|max:150',
            'review_body' => 'required|string|max:2000',
            'exchange_symbol' => 'nullable|string|max:20',
            'exchange_name' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'pros' => 'nullable|string|max:1000',
            'cons' => 'nullable|string|max:1000',
            'would_recommend' => 'required|boolean',
        ]);
        $review = ExchangesRatesReview::create($validated);
        return response()->json(['success' => true, 'review' => $review]);
    }

    public function listJson()
    {
        $reviews = ExchangesRatesReview::orderBy('created_at', 'desc')->take(20)->get();
        return response()->json($reviews);
    }
} 