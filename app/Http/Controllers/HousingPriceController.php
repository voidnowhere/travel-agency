<?php

namespace App\Http\Controllers;

use App\Enums\SeasonTypes;
use App\Iframes\HousingPriceIframe;
use App\Models\HousingPrice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HousingPriceController extends Controller
{
    public function index()
    {
        return view('admin.housing_prices.index', [
            'housingPrices' => HousingPrice::with(['housing.residence', 'formula'])->get(),
        ]);
    }

    public function create()
    {
        return view('admin.housing_prices.create');
    }

    public function store(Request $request)
    {
        HousingPrice::create($this->validateHousingPrice($request));

        return HousingPriceIframe::iframeCUClose() . '<br>' . HousingPriceIframe::reloadParent();
    }

    public function edit(HousingPrice $price)
    {
        return view('admin.housing_prices.edit', [
            'housingPrice' => $price,
        ]);
    }

    public function update(Request $request, HousingPrice $price)
    {
        $price->update($this->validateHousingPrice($request, $price));

        return HousingPriceIframe::iframeCUClose() . '<br>' . HousingPriceIframe::reloadParent();
    }

    public function delete(HousingPrice $price)
    {
        return view('admin.housing_prices.delete', [
            'housingPriceName' => $price->housing->name,
        ]);
    }

    public function destroy(HousingPrice $price)
    {
        $price->delete();

        return HousingPriceIframe::reloadParent();
    }

    public function validateHousingPrice(Request $request, HousingPrice $price = null)
    {
        $attributes = $request->validate([
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id',
            'residence' => 'required|exists:residences,id',
            'housing' => 'required|exists:housings,id',
            'formula' => 'required|exists:housing_formulas,id',
            'type' => [
                'required',
                Rule::in(SeasonTypes::values()),
                Rule::unique('housing_prices', 'type_SHML')
                    ->ignore($price->type_SHML ?? '', 'type_SHML')
                    ->where('housing_id', $request->input('housing') ?? $price?->housing_id)
                    ->where('housing_formula_id', $request->input('formula') ?? $price?->housing_formula_id),
            ],
            'one_price' => 'required|numeric',
            'one_extra_price' => 'required|numeric',
            'min_nights' => 'required|int',
            'weekend_price' => 'required|numeric',
            'weekend_active' => 'nullable',
            'kid_bed_price' => 'required|numeric',
            'kid_bed_active' => 'nullable',
            'extra_bed_price' => 'required|numeric',
            'extra_bed_active' => 'nullable',
        ]);

        $attributes['weekend_active'] = (bool)($attributes['weekend_active'] ?? false);
        $attributes['kid_bed_active'] = (bool)($attributes['kid_bed_active'] ?? false);
        $attributes['extra_bed_active'] = (bool)($attributes['extra_bed_active'] ?? false);

        return [
            'housing_id' => $attributes['housing'],
            'housing_formula_id' => $attributes['formula'],
            'type_SHML' => $attributes['type'],
            'for_one_price' => $attributes['one_price'],
            'for_one_extra_price' => $attributes['one_extra_price'],
            'min_nights' => $attributes['min_nights'],
            'weekend_price' => $attributes['weekend_price'],
            'weekend_is_active' => $attributes['weekend_active'],
            'kid_bed_price' => $attributes['kid_bed_price'],
            'kid_bed_is_active' => $attributes['kid_bed_active'],
            'extra_bed_price' => $attributes['extra_bed_price'],
            'extra_bed_is_active' => $attributes['extra_bed_active'],
        ];
    }
}
