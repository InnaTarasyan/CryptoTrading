<?php

namespace App\Http\Controllers\LiveCoinWatch;

use App\Contracts\Repositories\PublicReviewRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreFiatsReviewRequest;
use App\Models\LiveCoinWatch\FiatsReview;
use Illuminate\Http\Request;

class FiatsReviewController extends Controller
{
    public function __construct(
        private readonly PublicReviewRepositoryInterface $publicReviews
    ) {
    }

    public function index(Request $request)
    {
        $fiatCode = $request->query('fiat_code');
        $query = FiatsReview::query();
        if ($fiatCode) {
            $query->where('fiat_code', $fiatCode);
        }
        $reviews = $query->orderBy('created_at', 'desc')->get();

        return response()->json($reviews);
    }

    public function store(StoreFiatsReviewRequest $request)
    {
        $review = $this->publicReviews->createFiatsReview($request->validated());

        return response()->json(['success' => true, 'review' => $review]);
    }
}
