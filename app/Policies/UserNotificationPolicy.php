<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserNotification;

class UserNotificationPolicy
{
    public function update(User $user, UserNotification $userNotification): bool
    {
        return (int) $user->id === (int) $userNotification->user_id;
    }

    public function delete(User $user, UserNotification $userNotification): bool
    {
        return $this->update($user, $userNotification);
    }
}
