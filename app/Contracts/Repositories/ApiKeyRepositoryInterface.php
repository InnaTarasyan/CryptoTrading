<?php

namespace App\Contracts\Repositories;

use App\Models\ApiKey;
use App\Models\User;

interface ApiKeyRepositoryInterface
{
    public function countForUser(User $user): int;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function createForUser(User $user, array $attributes): ApiKey;

    public function delete(ApiKey $apiKey): void;

    public function toggleActive(ApiKey $apiKey): void;
}
