<?php

namespace App\Services;

use App\Jobs\UpdateCurrencyRates;
use App\Models\Currency;
use Illuminate\Support\Facades\Http;

class CurrencyService
{

    public function getAll()
    {
        return Currency::query();
    }

    public function create($data)
    {
        return Currency::create($data);
    }

    public function update(Currency $currency,  $data)
    {
        $currency->update($data);
        return $currency;
    }

    public function delete(Currency $currency)
    {
        return $currency->delete();
    }
}
