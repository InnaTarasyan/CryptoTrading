<?php

namespace App\Providers;

use App\Events\ApiKeyCreated;
use App\Events\ProfileUpdated;
use App\Events\PublicReviewSubmitted;
use App\Listeners\CreateInAppNotificationForNewApiKey;
use App\Listeners\LogProfileUpdatedActivity;
use App\Listeners\LogPublicReviewSubmission;
use App\Listeners\RecordUserLoginActivity;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, list<class-string>>
     */
    protected $listen = [
        Login::class => [
            RecordUserLoginActivity::class,
        ],
        ApiKeyCreated::class => [
            CreateInAppNotificationForNewApiKey::class,
        ],
        ProfileUpdated::class => [
            LogProfileUpdatedActivity::class,
        ],
        PublicReviewSubmitted::class => [
            LogPublicReviewSubmission::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
