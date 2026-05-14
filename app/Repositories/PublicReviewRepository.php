<?php

namespace App\Repositories;

use App\Contracts\Repositories\PublicReviewRepositoryInterface;
use App\Events\PublicReviewSubmitted;
use App\Models\CoinGecko\CoinGeckoTrendingsReview;
use App\Models\CoinGecko\CoingeckoExchangesReview;
use App\Models\CoinGecko\DerivativesExchangesReview;
use App\Models\Coingecko\DerivativesReview;
use App\Models\Coingecko\ExchangesRatesReview;
use App\Models\Coingecko\MarketsCoingeckoReview;
use App\Models\LiveCoinWatch\ExchangesReview;
use App\Models\LiveCoinWatch\FiatsReview;
use App\Models\LiveCoinWatchHistoryReview;

class PublicReviewRepository implements PublicReviewRepositoryInterface
{
    /**
     * @param  array<string, mixed>  $validated
     */
    public function createHistoryReview(array $validated): LiveCoinWatchHistoryReview
    {
        $review = LiveCoinWatchHistoryReview::create($validated);
        event(new PublicReviewSubmitted($review));

        return $review;
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createFiatsReview(array $validated): FiatsReview
    {
        $review = FiatsReview::create($validated);
        event(new PublicReviewSubmitted($review));

        return $review;
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createLiveCoinExchangesReview(array $validated): ExchangesReview
    {
        $review = ExchangesReview::create($validated);
        event(new PublicReviewSubmitted($review));

        return $review;
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createMarketsCoingeckoReview(array $validated): MarketsCoingeckoReview
    {
        $review = MarketsCoingeckoReview::create($validated);
        event(new PublicReviewSubmitted($review));

        return $review;
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createCoingeckoExchangesReview(array $validated): CoingeckoExchangesReview
    {
        $review = CoingeckoExchangesReview::create($validated);
        event(new PublicReviewSubmitted($review));

        return $review;
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createCoinGeckoTrendingsReview(array $validated): CoinGeckoTrendingsReview
    {
        $review = CoinGeckoTrendingsReview::create($validated);
        event(new PublicReviewSubmitted($review));

        return $review;
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createExchangesRatesReview(array $validated): ExchangesRatesReview
    {
        $review = ExchangesRatesReview::create($validated);
        event(new PublicReviewSubmitted($review));

        return $review;
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createDerivativesReview(array $validated): DerivativesReview
    {
        $review = DerivativesReview::create($validated);
        event(new PublicReviewSubmitted($review));

        return $review;
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createDerivativeExchangeReview(array $validated): DerivativesExchangesReview
    {
        $review = DerivativesExchangesReview::create($validated);
        event(new PublicReviewSubmitted($review));

        return $review;
    }
}
