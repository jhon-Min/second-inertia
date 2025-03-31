<?php

namespace App\Providers;

use App\Jobs\CreateCityAndCountry;
use App\Jobs\UpdateCurrencyRates;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        Vite::prefetch(concurrency: 3);
        if ($this->app->runningInConsole()) {
            return;
        }


        if (!Currency::exists()) {
            UpdateCurrencyRates::dispatch()->onQueue('currency');
            Log::info('Currency data successfully fetched and stored');
        }
        if (!Country::exists()) {
            CreateCityAndCountry::dispatch()->onQueue('country');
            Log::info(' Coutry, city data fetched and stored');
        }
    }
}
