<?php

namespace App\Http\Controllers;

use App\Iframes\CityIframe;
use App\Iframes\CountryIframe;
use App\Models\Country;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    public function index()
    {
        return view('admin.countries.index', [
            'countries' => Country::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store()
    {
        $attributes = $this->validateCountry();

        Country::create($attributes);

        return
            CountryIframe::iframeCUClose()
            . '<br>' .
            CityIframe::unloadParent()
            . '<br>' .
            CountryIframe::reloadParent();
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', [
            'country' => $country,
        ]);
    }

    public function update(Country $country)
    {
        $attributes = $this->validateCountry($country);

        $country->cities()->update(['is_active' => $attributes['is_active']]);

        $country->update($attributes);

        return
            CountryIframe::iframeCUClose()
            . '<br>' .
            CityIframe::unloadParent()
            . '<br>' .
            CountryIframe::reloadParent();
    }

    public function delete(Country $country)
    {
        return view('admin.countries.delete', [
            'country' => $country,
        ]);
    }

    public function destroy(Country $country)
    {
        $country->cities()->delete();
        $country->delete();

        return
            CityIframe::unloadParent()
            . '<br>' .
            CountryIframe::reloadParent();
    }

    public function validateCountry(Country $country = null)
    {
        $attributes = request()->validate([
            'name' => [
                'required',
                'min:2',
                'max:255',
                'alpha',
                Rule::unique('countries')->ignore($country->name ?? '', 'name'),
            ],
            'is_active' => 'nullable',
        ]);
        $attributes['is_active'] = ($country === null) || (bool)($attributes['is_active'] ?? false);
        return $attributes;
    }
}
