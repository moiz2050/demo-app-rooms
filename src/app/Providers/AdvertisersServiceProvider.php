<?php

namespace App\Providers;

use App\Integrations\Advertisers\AdvertisersServiceManager;
use App\Services\Advertisers\HubService;
use App\Services\Advertisers\HubServiceInterface;
use Illuminate\Support\ServiceProvider;

class AdvertisersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('advertiser', function ($app) {
            return new AdvertisersServiceManager;
        });

        $this->app->bind(HubServiceInterface::class, HubService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
