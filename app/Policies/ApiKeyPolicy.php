<?php

namespace App\Policies;

use App\Models\ApiKey;
use App\Models\User;

class ApiKeyPolicy
{
    public const MAX_KEYS_PER_USER = 10;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ApiKey $apiKey): bool
    {
        return (int) $user->id === (int) $apiKey->user_id;
    }

    public function create(User $user): bool
    {
        return $user->apiKeys()->count() < self::MAX_KEYS_PER_USER;
    }

    public function update(User $user, ApiKey $apiKey): bool
    {
        return $this->view($user, $apiKey);
    }

    public function delete(User $user, ApiKey $apiKey): bool
    {
        return $this->view($user, $apiKey);
    }
}
