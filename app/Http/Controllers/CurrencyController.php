<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CurrencyController extends Controller
{
    public function __construct(protected CurrencyService $currencyService)
    {
    }

    public function index(Request $request)
    {

        $lists = $this->currencyService->getAll()->orderBy('id', 'desc')
            ->when($request->search, function ($query, $search) {
                return $query->where('code', 'ILIKE', "%{$search}%");
            })
            ->paginate(10);

        return Inertia::render('Currency/Index', ['currencies' => $lists, 'filters' => $request->only(['search'])]);
    }

    public function store(StoreCurrencyRequest $request)
    {
        $currency = $this->currencyService->create($request->validated());
        return redirect()->route('currencies.index')->with('success', 'Currency created successfully.');
    }

    public function create()
    {
        return Inertia::render('Currency/Create');
    }

    public function edit(Currency $currency)
    {
        return inertia('Currency/Edit', compact('currency'));
    }

    public function update(UpdateCurrencyRequest $request, Currency $currency)
    {
        $currency = $this->currencyService->update($currency, $request->validated());
        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }


    public function destroy(Currency $currency)
    {
        $this->currencyService->delete(currency: $currency);
        return redirect()->route('currencies.index')->with('delete', 'Currency deleted successfully.');
    }
}
