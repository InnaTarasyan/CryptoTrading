<?php

namespace App\Repositories;

use App\Contracts\Repositories\ApiKeyRepositoryInterface;
use App\Events\ApiKeyCreated;
use App\Models\ApiKey;
use App\Models\User;

class ApiKeyRepository implements ApiKeyRepositoryInterface
{
    public function countForUser(User $user): int
    {
        return $user->apiKeys()->count();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function createForUser(User $user, array $attributes): ApiKey
    {
        $apiKey = $user->apiKeys()->create($attributes);

        event(new ApiKeyCreated($user, $apiKey));

        return $apiKey;
    }

    public function delete(ApiKey $apiKey): void
    {
        $apiKey->delete();
    }

    public function toggleActive(ApiKey $apiKey): void
    {
        $apiKey->update(['is_active' => ! $apiKey->is_active]);
    }
}
