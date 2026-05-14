<?php

namespace App\Listeners;

use App\Events\ProfileUpdated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LogProfileUpdatedActivity
{
    public function handle(ProfileUpdated $event): void
    {
        if ($event->changedAttributeKeys === []) {
            return;
        }

        Log::info('account.profile.updated', [
            'user_id' => $event->user->id,
            'changed' => $event->changedAttributeKeys,
        ]);

        Cache::forget('user.'.$event->user->id.'.profile_summary');
    }
}
