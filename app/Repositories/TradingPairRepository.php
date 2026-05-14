<?php

namespace App\Repositories;

use App\Contracts\Repositories\TradingPairRepositoryInterface;
use App\Models\TradingPair;
use Illuminate\Database\Eloquent\Collection;

class TradingPairRepository implements TradingPairRepositoryInterface
{
    public function all(): Collection
    {
        return TradingPair::all();
    }

    public function find(int $id): ?TradingPair
    {
        return TradingPair::query()->find($id);
    }

    public function existsForCoin(int $coinId): bool
    {
        return TradingPair::query()->where('coin', $coinId)->exists();
    }

    public function createPair(int $coinId, string $tradingPair): ?TradingPair
    {
        if ($this->existsForCoin($coinId)) {
            return null;
        }

        return TradingPair::create([
            'coin' => $coinId,
            'trading_pair' => $tradingPair,
        ]);
    }

    public function updatePair(TradingPair $pair, int $coinId, string $tradingPair): bool
    {
        return $pair->update([
            'coin' => $coinId,
            'trading_pair' => $tradingPair,
        ]);
    }

    public function deletePair(TradingPair $pair): bool
    {
        return (bool) $pair->delete();
    }
}
