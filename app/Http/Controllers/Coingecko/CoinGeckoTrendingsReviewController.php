<?php

namespace App\Http\Controllers\Coingecko;

use App\Contracts\Repositories\PublicReviewRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreCoinGeckoTrendingsReviewRequest;
use App\Models\CoinGecko\CoinGeckoTrendingsReview;
use Illuminate\Http\Request;

class CoinGeckoTrendingsReviewController extends Controller
{
    public function __construct(
        private readonly PublicReviewRepositoryInterface $publicReviews
    ) {
    }

    public function index(Request $request)
    {
        $trendingCode = $request->query('trending_code');
        $query = CoinGeckoTrendingsReview::query();
        if ($trendingCode) {
            $query->where('trending_code', $trendingCode);
        }
        $reviews = $query->orderBy('created_at', 'desc')->get();

        return response()->json($reviews);
    }

    public function store(StoreCoinGeckoTrendingsReviewRequest $request)
    {
        $review = $this->publicReviews->createCoinGeckoTrendingsReview($request->validated());

        return response()->json(['success' => true, 'review' => $review]);
    }
}
