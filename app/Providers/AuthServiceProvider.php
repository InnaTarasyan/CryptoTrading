<?php

namespace App\Providers;

use App\Models\ApiKey;
use App\Models\User;
use App\Models\UserNotification;
use App\Policies\ApiKeyPolicy;
use App\Policies\UserNotificationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ApiKey::class => ApiKeyPolicy::class,
        UserNotification::class => UserNotificationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('accessApiBasedFeatures', function (User $user) {
            return $user->apiKeys()->where('is_active', true)->exists();
        });

        Gate::define('hasCompletedProfile', function (User $user) {
            return filled($user->first_name) && filled($user->last_name);
        });

        Gate::define('viewBilling', function (User $user) {
            return $user->hasVerifiedEmail() || app()->environment(['local', 'testing']);
        });
    }
}
