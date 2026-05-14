<?php

namespace App\Providers;

use App\Contracts\Repositories\ApiKeyRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\ApiKeyRepository;
use App\Repositories\UserRepository;
use Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // @set($i,10)
        Blade::directive('set', function ($exp){
            list($name, $val) = explode(',', $exp);
            return "<?php $name = $val ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(ApiKeyRepositoryInterface::class, ApiKeyRepository::class);
    }
}
