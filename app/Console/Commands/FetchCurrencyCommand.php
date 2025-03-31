<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCurrencyRates;
use Illuminate\Console\Command;

class FetchCurrencyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch currency data from API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Dispatching currency fetch job...');
        UpdateCurrencyRates::dispatch();
        $this->info('Currency fetch job dispatched to queue!');
    }
}
