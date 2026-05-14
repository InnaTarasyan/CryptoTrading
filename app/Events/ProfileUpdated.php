<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProfileUpdated
{
    use Dispatchable;
    use SerializesModels;

    /**
     * @param  list<string>  $changedAttributeKeys
     */
    public function __construct(
        public User $user,
        public array $changedAttributeKeys
    ) {
    }
}
