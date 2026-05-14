<?php

namespace App\Http\Controllers\Coingecko;

use App\Contracts\Repositories\PublicReviewRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreCoingeckoExchangesReviewRequest;
use App\Models\CoinGecko\CoingeckoExchangesReview;
use Illuminate\Http\Request;

class CoingeckoExchangesReviewController extends Controller
{
    public function __construct(
        private readonly PublicReviewRepositoryInterface $publicReviews
    ) {
    }

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

    public function store(StoreCoingeckoExchangesReviewRequest $request)
    {
        $review = $this->publicReviews->createCoingeckoExchangesReview($request->validated());

        return response()->json(['success' => true, 'review' => $review]);
    }
}
