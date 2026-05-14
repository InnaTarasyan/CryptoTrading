<?php

namespace App\Http\Controllers\Coingecko;

use App\Contracts\Repositories\PublicReviewRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\StoreExchangesRatesReviewRequest;
use App\Models\Coingecko\ExchangesRatesReview;

class ExchangesRatesReviewsController extends Controller
{
    public function __construct(
        private readonly PublicReviewRepositoryInterface $publicReviews
    ) {
    }

    public function index()
    {
        $reviews = ExchangesRatesReview::orderBy('created_at', 'desc')->take(20)->get();

        return view('coingecko.exchanges_rates', compact('reviews'));
    }

    public function store(StoreExchangesRatesReviewRequest $request)
    {
        $review = $this->publicReviews->createExchangesRatesReview($request->validated());

        return response()->json(['success' => true, 'review' => $review]);
    }

    public function listJson()
    {
        $reviews = ExchangesRatesReview::orderBy('created_at', 'desc')->take(20)->get();

        return response()->json($reviews);
    }
}
