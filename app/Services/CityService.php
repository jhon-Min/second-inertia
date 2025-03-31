<?php

namespace App\Services;


use App\Models\City;


class CityService
{

    public function getAll()
    {
        return City::query();
    }

    public function create($data)
    {
        return City::create($data);
    }

    public function update(City $city,  $data)
    {
        $city->update($data);
        return $city;
    }

    public function delete(City $city)
    {
        return $city->delete();
    }
}
