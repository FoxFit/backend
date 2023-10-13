<?php

namespace App\Providers;

use App\Contracts\Support\CountryCityInterface;
use App\Contracts\Support\CountryInterface;
use App\Repositories\Contracts\CountryCityRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\CountryCityRepository;
use App\Repositories\UserRepository;
use App\Support\Country;
use App\Support\CountryCity;
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
        $this->registerFacades();
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
        $this->app->bind(CountryCityRepositoryInterface::class, CountryCityRepository::class);
    }

    private function registerFacades(): void
    {
        $this->app->singleton(CountryInterface::class, Country::class);
        $this->app->singleton(CountryCityInterface::class, CountryCity::class);
    }
}
