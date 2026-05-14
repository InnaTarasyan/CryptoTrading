<?php

namespace App\Contracts\Repositories;

use App\Models\CoinGecko\CoinGeckoTrendingsReview;
use App\Models\CoinGecko\CoingeckoExchangesReview;
use App\Models\CoinGecko\DerivativesExchangesReview;
use App\Models\Coingecko\DerivativesReview;
use App\Models\Coingecko\ExchangesRatesReview;
use App\Models\Coingecko\MarketsCoingeckoReview;
use App\Models\LiveCoinWatch\ExchangesReview;
use App\Models\LiveCoinWatch\FiatsReview;
use App\Models\LiveCoinWatchHistoryReview;

interface PublicReviewRepositoryInterface
{
    /**
     * @param  array<string, mixed>  $validated
     */
    public function createHistoryReview(array $validated): LiveCoinWatchHistoryReview;

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createFiatsReview(array $validated): FiatsReview;

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createLiveCoinExchangesReview(array $validated): ExchangesReview;

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createMarketsCoingeckoReview(array $validated): MarketsCoingeckoReview;

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createCoingeckoExchangesReview(array $validated): CoingeckoExchangesReview;

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createCoinGeckoTrendingsReview(array $validated): CoinGeckoTrendingsReview;

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createExchangesRatesReview(array $validated): ExchangesRatesReview;

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createDerivativesReview(array $validated): DerivativesReview;

    /**
     * @param  array<string, mixed>  $validated
     */
    public function createDerivativeExchangeReview(array $validated): DerivativesExchangesReview;
}
