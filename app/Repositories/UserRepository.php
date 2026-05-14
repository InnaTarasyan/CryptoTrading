<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Events\ProfileUpdated;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function updateProfile(User $user, array $attributes): bool
    {
        $user->fill($attributes);
        $changedKeys = array_keys($user->getDirty());

        if ($changedKeys === []) {
            return true;
        }

        $saved = $user->save();

        if ($saved) {
            event(new ProfileUpdated($user, $changedKeys));
        }

        return $saved;
    }
}
