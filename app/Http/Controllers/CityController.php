<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use App\Services\CityService;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(protected CityService $cityService, protected CountryService $countryService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cities = $this->cityService->getAll()->with('country:id,common')->orderBy('id', 'desc')->when($request->search, function ($query, $search) {
            return $query->where('capital', 'ILIKE', "%{$search}%");
        })->paginate(10);
        return inertia('City/Index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = $this->countryService->getAll()->select('id', 'common')->orderBy('id', 'desc')->get();
        return inertia('City/Create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request)
    {
        $this->cityService->create($request->validated());
        return redirect()->route('cities.index')->with('success', 'City created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $countries = $this->countryService->getAll()->select('id', 'common')->orderBy('id', 'desc')->get();
        return inertia('City/Edit', compact('city', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        $this->cityService->update($city, $request->validated());
        return redirect()->route('cities.index')->with('success', 'City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $this->cityService->delete($city);
        return redirect()->route('cities.index')->with('delete', 'City deleted successfully.');
    }
}
