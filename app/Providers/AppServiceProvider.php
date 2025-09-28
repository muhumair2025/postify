<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use SocialiteProviders\TikTok\Provider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register TikTok provider for Socialite
        Socialite::extend('tiktok', function ($app) {
            $config = $app['config']['services.tiktok'];
            return Socialite::buildProvider(Provider::class, $config);
        });
    }
}
