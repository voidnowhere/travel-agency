<?php

namespace App\Http\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\CityIframe;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function index(Country $country)
    {
        return view('admin.cities.index', [
            'cities' => $country->cities()->orderBy('order_by')->get(['id', 'name', 'order_by', 'is_active']),
            'countryId' => $country->id,
        ]);
    }

    public function get(Request $request)
    {
        $country_id = $request->validate(['country_id' => 'required|int'])['country_id'];

        return Country::findOrFail($country_id)->cities()->orderBy('order_by')->get(['id', 'name']);
    }

    public function getActive(Request $request)
    {
        $country_id = $request->validate(['country_id' => 'required|int'])['country_id'];

        $country = Country::findOrFail($country_id);

        if (!$country->is_active) {
            return null;
        }

        return $country->cities()->active()->orderBy('order_by')->get(['id', 'name']);
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(Request $request, Country $country)
    {
        $country->cities()->create($this->validateCountry($request, country: $country));

        return CityIframe::iframeCUClose() . '<br>' . CityIframe::reloadParent($country->id);
    }

    public function edit(City $city)
    {
        return view('admin.cities.edit', [
            'city' => $city,
        ]);
    }

    public function update(Request $request, City $city)
    {
        $city->update($this->validateCountry($request, $city, $city->country));

        return CityIframe::iframeCUClose() . '<br>' . CityIframe::reloadParent($city->country_id);
    }

    public function delete(City $city)
    {
        return view('admin.cities.delete', [
            'city' => $city,
        ]);
    }

    public function destroy(City $city)
    {
        if ($city->residences()->count() > 0) {
            return NotiflixHelper::report(
                "You can\'t delete $city->name city it has linked residences!",
                'failure',
                CityIframe::$iframeDId,
            );
        }
        if ($city->users()->count() > 0) {
            return NotiflixHelper::report(
                "You can\'t delete $city->name city it has linked users!",
                'failure',
                CityIframe::$iframeDId,
            );
        }

        $city->delete();

        return CityIframe::hideIframeD() . '<br>' . CityIframe::reloadParent($city->country_id);
    }

    protected function validateCountry(Request $request, City $city = null, Country $country = null)
    {
        $attributes = $request->validate([
            'name' => [
                'required',
                'alpha',
                Rule::unique('cities')
                    ->ignore($city->name ?? '', 'name')
                    ->where('country_id', $city->country_id ?? $country->id),
            ],
            'order' => 'required|int',
            'active' => 'nullable',
        ]);

        $attributes['active'] = (bool)($attributes['active'] ?? false);

        return [
            'name' => $attributes['name'],
            'order_by' => $attributes['order'],
            'is_active' => $attributes['active'],
        ];
    }
}
