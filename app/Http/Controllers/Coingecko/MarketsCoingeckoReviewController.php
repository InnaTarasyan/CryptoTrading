<?php

namespace App\Http\Controllers\Coingecko;

use App\Contracts\Repositories\PublicReviewRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreMarketsCoingeckoReviewRequest;
use App\Models\Coingecko\MarketsCoingeckoReview;
use Illuminate\Http\Request;

class MarketsCoingeckoReviewController extends Controller
{
    public function __construct(
        private readonly PublicReviewRepositoryInterface $publicReviews
    ) {
    }

    public function index(Request $request)
    {
        $coinId = $request->query('coin_id');
        $query = MarketsCoingeckoReview::query();
        if ($coinId) {
            $query->where('coin_id', $coinId);
        }
        $reviews = $query->orderBy('created_at', 'desc')->get();

        return response()->json($reviews);
    }

    public function store(StoreMarketsCoingeckoReviewRequest $request)
    {
        $review = $this->publicReviews->createMarketsCoingeckoReview($request->validated());

        return response()->json(['success' => true, 'review' => $review]);
    }
}
