<?php

namespace App\Services;


use App\Models\Country;
use Illuminate\Support\Facades\Http;

class CountryService
{

    public function getAll()
    {
        return Country::query();
    }

    public function create($data)
    {
        return Country::create($data);
    }

    public function update(Country $country,  $data)
    {
        $country->update($data);
        return $country;
    }

    public function delete(Country $country)
    {
        return $country->delete();
    }
}
