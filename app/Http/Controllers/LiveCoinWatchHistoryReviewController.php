<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\PublicReviewRepositoryInterface;
use App\Http\Requests\Reviews\StoreLiveCoinWatchHistoryReviewRequest;
use App\Models\LiveCoinWatchHistoryReview;

class LiveCoinWatchHistoryReviewController extends Controller
{
    public function __construct(
        private readonly PublicReviewRepositoryInterface $publicReviews
    ) {
    }

    public function index()
    {
        $reviews = LiveCoinWatchHistoryReview::orderBy('created_at', 'desc')->get();

        return response()->json($reviews);
    }

    public function store(StoreLiveCoinWatchHistoryReviewRequest $request)
    {
        $review = $this->publicReviews->createHistoryReview($request->validated());

        return response()->json(['success' => true, 'review' => $review]);
    }
}
