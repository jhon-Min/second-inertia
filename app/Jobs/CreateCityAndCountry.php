<?php

namespace App\Jobs;

use App\Models\City;
use App\Models\Country;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateCityAndCountry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $baseUrl = config('services.city_country_api.base_url');
            $res = Http::get($baseUrl);
            if ($res->successful()) {
                $data = $res->json();
                // $chunkSize = 100;


                foreach ($data as $x) {
                    $capital = $x['capital'][0] ?? 'capital';

                    $saveCountry = Country::updateOrCreate(
                        ['common' => $x['name']['common']],
                        [
                            'offical' => $x['name']['official'] ?? 'default',
                            'region' => $x['region'] ?? 'Unknown'
                        ]
                    );


                    if ($capital) {
                        City::updateOrCreate(
                            ['capital' => $capital, 'country_id' => $saveCountry->id]
                        );
                    }
                }
            }
        } catch (\Throwable $th) {
            Log::error('Currency fetch failed: ' . $th);
        }
    }
}
