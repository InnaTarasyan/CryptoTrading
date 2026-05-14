<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function update(User $auth, User $model): bool
    {
        return (int) $auth->id === (int) $model->id;
    }

    public function updatePassword(User $auth, User $model): bool
    {
        return $this->update($auth, $model);
    }
}
