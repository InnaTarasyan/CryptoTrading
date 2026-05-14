<?php

namespace App\Http\Controllers\LiveCoinWatch;

use App\Contracts\Repositories\PublicReviewRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreLiveCoinWatchExchangesReviewRequest;
use App\Models\LiveCoinWatch\ExchangesReview;
use Illuminate\Http\Request;

class ExchangesReviewController extends Controller
{
    public function __construct(
        private readonly PublicReviewRepositoryInterface $publicReviews
    ) {
    }

    public function index(Request $request)
    {
        $exchangeCode = $request->query('exchange_code');
        $query = ExchangesReview::query();
        if ($exchangeCode) {
            $query->where('exchange_code', $exchangeCode);
        }
        $reviews = $query->orderBy('created_at', 'desc')->get();

        return response()->json($reviews);
    }

    public function store(StoreLiveCoinWatchExchangesReviewRequest $request)
    {
        $review = $this->publicReviews->createLiveCoinExchangesReview($request->validated());

        return response()->json(['success' => true, 'review' => $review]);
    }
}
