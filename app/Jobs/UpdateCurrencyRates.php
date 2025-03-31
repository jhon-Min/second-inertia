<?php

namespace App\Jobs;

use App\Models\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateCurrencyRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $baseUrl = config('services.currency_api.base_url');
            $res = Http::get($baseUrl);
            // dd('hello');
            $currencies = $res->json()['eur'];
            foreach ($currencies as $code => $rate) {
                Currency::updateOrCreate(
                    ['code' => $code],
                    ['rate' => $rate, 'updated_at' => now()]
                );
            }
            Log::info('Currency data successfully fetched and stored');
        } catch (\Exception $e) {
            Log::error('Currency fetch failed: ' . $e->getMessage());
            $this->fail($e);
        }
    }
}
