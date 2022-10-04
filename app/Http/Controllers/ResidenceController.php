<?php

namespace App\Http\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\ResidenceIframe;
use App\Models\City;
use App\Models\Residence;
use App\Rules\AlphaOneSpaceBetween;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResidenceController extends Controller
{
    public function index()
    {
        return view('admin.residences.index', [
            'residences' => Residence
                ::with(['city:id,country_id,name', 'city.country:id,name', 'category:id,name'])
                ->orderBy('order_by')
                ->get([
                    'id',
                    'city_id', 'residence_category_id',
                    'name',
                    'description',
                    'email',
                    'contact',
                    'tax',
                    'order_by',
                    'is_active',
                ]),
        ]);
    }

    public function get(Request $request)
    {
        $city_id = $request->validate(['city_id' => 'required|int'])['city_id'];

        return City::findOrFail($city_id)->residences()->orderBy('order_by')->get(['id', 'name']);
    }

    public function getActive(Request $request)
    {
        $city_id = $request->validate(['city_id' => 'required|int'])['city_id'];

        return City::findOrFail($city_id)->residences()->active()->orderBy('order_by')->get(['id', 'name']);
    }

    public function create()
    {
        return view('admin.residences.create');
    }

    public function store(Request $request)
    {
        Residence::create($this->validateResidence($request));

        return ResidenceIframe::iframeCUClose() . '<br>' . ResidenceIframe::reloadParent();
    }

    public function edit(Residence $residence)
    {
        return view('admin.residences.edit', [
            'residence' => $residence,
        ]);
    }

    public function update(Request $request, Residence $residence)
    {
        $residence->update($this->validateResidence($request, $residence));

        return ResidenceIframe::iframeCUClose() . '<br>' . ResidenceIframe::reloadParent();
    }

    public function delete(Residence $residence)
    {
        return view('admin.residences.delete', [
            'residenceName' => $residence->name,
        ]);
    }

    public function destroy(Residence $residence)
    {
        if ($residence->housings()->count() > 0) {
            return NotiflixHelper::report(
                "You can\'t delete $residence->name residence it has linked housings!",
                'failure',
                ResidenceIframe::$iframeDId,
            );
        }

        $residence->delete();

        return ResidenceIframe::hideIframeD() . '<br>' . ResidenceIframe::reloadParent();
    }

    protected function validateResidence(Request $request, Residence $residence = null)
    {
        $attributes = $request->validate([
            'name' => [
                'required',
                Rule::unique('residences')
                    ->ignore($residence->name ?? '', 'name')
                    ->where('city_id', $request->input('city') ?? $residence?->city_id),
                new AlphaOneSpaceBetween,
            ],
            'city' => 'required|exists:cities,id',
            'category' => 'required|exists:residence_categories,id',
            'description' => 'required',
            'website' => 'required|url',
            'email' => 'required|email:rfc,dns',
            'contact' => ['required', new AlphaOneSpaceBetween],
            'tax' => 'required|numeric',
            'order' => 'required|int',
            'active' => 'nullable',
        ]);

        $attributes['active'] = (bool)($attributes['active'] ?? false);

        return [
            'name' => $attributes['name'],
            'city_id' => $attributes['city'],
            'residence_category_id' => $attributes['category'],
            'description' => $attributes['description'],
            'website' => $attributes['website'],
            'email' => $attributes['email'],
            'contact' => $attributes['contact'],
            'tax' => $attributes['tax'],
            'order_by' => $attributes['order'],
            'is_active' => $attributes['active'],
        ];
    }
}
