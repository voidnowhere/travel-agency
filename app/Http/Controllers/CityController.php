<?php

namespace App\Http\Controllers;

use App\Iframes\CityIframe;
use App\Models\City;
use App\Models\Country;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function index(Country $country)
    {
        return view('admin.cities.index', [
            'cities' => $country->cities()->latest()->get(),
            'country_id' => $country->id,
        ]);
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(Country $country)
    {
        $attributes = $this->validateCountry(country: $country);

        $country->cities()->create($attributes);

        return CityIframe::iframeClose();
    }

    public function edit(City $city)
    {
        return view('admin.cities.edit', [
            'city' => $city,
        ]);
    }

    public function update(City $city)
    {
        $attributes = $this->validateCountry($city);

        $city->update($attributes);

        return CityIframe::iframeClose();
    }

    public function destroy(City $city)
    {
        $city->delete();

        return CityIframe::reloadParent($city->country_id);
    }

    public function validateCountry(City $city = null, Country $country = null)
    {
        $attributes = request()->validate([
            'name' => [
                'required',
                'min:2',
                'max:255',
                'alpha',
                Rule::unique('cities')
                    ->ignore($city->name ?? '', 'name')
                    ->where('country_id', $city->country_id ?? $country->id),
            ],
            'is_active' => 'nullable',
        ]);
        $attributes['is_active'] = (bool)($attributes['is_active'] ?? false);
        return $attributes;
    }
}
