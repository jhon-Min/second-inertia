<?php

namespace App\Providers;

use App\Jobs\UpdateCurrencyRates;
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

        // Check if table exists and is empty
        try {
            if (Currency::count() === 0) {
                UpdateCurrencyRates::dispatch();
            }
        } catch (\Exception $e) {
            Log::error('Currency checked failed: ' . $e->getMessage());
        }
    }
}
