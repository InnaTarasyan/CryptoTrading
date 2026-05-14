<?php

namespace App\Events;

use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApiKeyCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public User $user,
        public ApiKey $apiKey
    ) {
    }
}
