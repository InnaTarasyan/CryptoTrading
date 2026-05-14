<?php

namespace App\Contracts\Repositories;

use App\Models\TradingPair;
use Illuminate\Database\Eloquent\Collection;

interface TradingPairRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?TradingPair;

    public function existsForCoin(int $coinId): bool;

    /**
     * @return ?TradingPair null when a pair for this coin already exists
     */
    public function createPair(int $coinId, string $tradingPair): ?TradingPair;

    public function updatePair(TradingPair $pair, int $coinId, string $tradingPair): bool;

    public function deletePair(TradingPair $pair): bool;
}
