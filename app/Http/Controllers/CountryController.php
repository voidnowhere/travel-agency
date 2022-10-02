<?php

namespace App\Http\Controllers;

use App\Helpers\NotiflixHelper;
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
            'countries' => Country::orderBy('order_by')->get(['id', 'name', 'order_by', 'is_active']),
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
            CountryIframe::iframeCUClose() . '<br>' . CountryIframe::reloadParent()
            . '<br>' .
            CountryIframe::parentFocusRow($country->id) . '<br>' . CityIframe::reloadParent($country->id);
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
            CountryIframe::iframeCUClose() . '<br>' . CountryIframe::reloadParent()
            . '<br>' .
            CountryIframe::parentFocusRow($country->id) . '<br>' . CityIframe::reloadParent($country->id);
    }

    public function delete(Country $country)
    {
        return view('admin.countries.delete', [
            'country' => $country,
        ]);
    }

    public function destroy(Country $country)
    {
        if ($country->cities()->count() > 0) {
            return NotiflixHelper::report(
                "You can\'t delete $country->name country it has linked cities!",
                'failure',
                CountryIframe::$iframeDId,
            );
        }

        $country->delete();

        return CountryIframe::hideIframeD() . '<br>' . CityIframe::unloadParent() . '<br>' . CountryIframe::reloadParent();
    }

    protected function validateCountry(Request $request, Country $country = null)
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
