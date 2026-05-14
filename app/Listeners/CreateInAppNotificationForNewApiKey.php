<?php

namespace App\Listeners;

use App\Events\ApiKeyCreated;
use App\Jobs\AuditSecurityEventJob;
use App\Models\UserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateInAppNotificationForNewApiKey implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ApiKeyCreated $event): void
    {
        UserNotification::create([
            'user_id' => $event->user->id,
            'type' => 'security',
            'title' => 'New API key created',
            'message' => sprintf('A new API key "%s" was added to your account.', $event->apiKey->name),
            'is_read' => false,
            'metadata' => [
                'api_key_id' => $event->apiKey->id,
                'permissions' => $event->apiKey->permissions,
            ],
        ]);

        AuditSecurityEventJob::dispatch(
            $event->user->id,
            'api_key.created',
            [
                'api_key_id' => $event->apiKey->id,
                'name' => $event->apiKey->name,
            ]
        );
    }
}
