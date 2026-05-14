<?php

namespace App\Http\Controllers\Coingecko;

use App\Contracts\Repositories\PublicReviewRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreDerivativesReviewRequest;
use App\Models\Coingecko\DerivativesReview;

class DerivativesReviewController extends Controller
{
    public function __construct(
        private readonly PublicReviewRepositoryInterface $publicReviews
    ) {
    }

    public function index()
    {
        $reviews = DerivativesReview::orderBy('created_at', 'desc')->get();

        return response()->json($reviews);
    }

    public function store(StoreDerivativesReviewRequest $request)
    {
        $review = $this->publicReviews->createDerivativesReview($request->validated());

        return response()->json(['success' => true, 'review' => $review]);
    }
}
