<?php

namespace App\Http\Controllers;

use App\Helpers\JavaScriptHelper;
use App\Iframes\CityIframe;
use App\Iframes\CountryIframe;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CountryController extends Controller
{
    public function index()
    {
        return view('admin.countries.index', [
            'countries' => Country::orderBy('order_by')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $country = Country::create($this->validateCountry($request));

        return
            CountryIframe::iframeCUClose()
            . '<br>' .
            CountryIframe::reloadParent()
            . '<br>' .
            CountryIframe::parentFocusRow($country->id)
            . '<br>' .
            CityIframe::reloadParent($country->id);
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', [
            'country' => $country,
        ]);
    }

    public function update(Request $request, Country $country)
    {
        $attributes = $this->validateCountry($request, $country);

        $country->cities()->update(['is_active' => $attributes['is_active']]);

        $country->update($attributes);

        return
            CountryIframe::iframeCUClose()
            . '<br>' .
            CountryIframe::reloadParent()
            . '<br>' .
            CountryIframe::parentFocusRow($country->id)
            . '<br>' .
            CityIframe::reloadParent($country->id);
    }

    public function delete(Country $country)
    {
        return view('admin.countries.delete', [
            'country' => $country,
        ]);
    }

    public function destroy(Country $country)
    {
        if ($country->residences()->count() > 0) {
            return JavaScriptHelper::alert("You can't delete $country->name country it has linked residences!");
        }

        $country->cities()->delete();
        $country->delete();

        return
            CityIframe::unloadParent()
            . '<br>' .
            CountryIframe::reloadParent();
    }

    public function validateCountry(Request $request, Country $country = null)
    {
        $attributes = $request->validate([
            'name' => [
                'required',
                'min:2',
                'max:255',
                'alpha',
                Rule::unique('countries')->ignore($country->name ?? '', 'name'),
            ],
            'order' => 'required|int',
            'active' => 'nullable',
        ]);

        $attributes['active'] = ($country === null) || (bool)($attributes['active'] ?? false);

        return [
            'name' => $attributes['name'],
            'order_by' => $attributes['order'],
            'is_active' => $attributes['active'],
        ];
    }
}
