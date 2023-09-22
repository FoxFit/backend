<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();
        // Set expire time.
        Passport::tokensExpireIn(now()->addDays(config('auth.passport_token_expire_time')));
        Passport::refreshTokensExpireIn(now()->addDays(config('auth.passport_refresh_token_expire_time')));
        // Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        $this->registerRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function registerRepositories(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
