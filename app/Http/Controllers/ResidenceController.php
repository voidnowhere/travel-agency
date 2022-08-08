<?php

namespace App\Http\Controllers;

use App\Iframes\ResidenceIframe;
use App\Models\City;
use App\Models\Residence;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResidenceController extends Controller
{
    public function index()
    {
        return view('admin.residence.index', [
            'residences' => Residence::with('city.country', 'category')->orderBy('order_by')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.residence.create');
    }

    public function store(Request $request)
    {
        Residence::create($this->validateResidence($request));

        return ResidenceIframe::iframeCUClose() . '<br>' . ResidenceIframe::reloadParent();
    }

    public function edit(Residence $residence)
    {
        return view('admin.residence.edit', [
            'residence' => $residence,
        ]);
    }

    public function update(Request $request, Residence $residence)
    {
        $residence->update($this->validateResidence($request));

        return ResidenceIframe::iframeCUClose() . '<br>' . ResidenceIframe::reloadParent();
    }

    public function delete(Residence $residence)
    {
        return view('admin.residence.delete', [
            'residenceName' => $residence->name,
        ]);
    }

    public function destroy(Residence $residence)
    {
        $residence->delete();

        return ResidenceIframe::reloadParent();
    }

    public function validateResidence(Request $request, Residence $residence = null)
    {
        $attributes = $request->validate([
            'name' => [
                'required',
                Rule::unique('residences')
                    ->ignore($residence->name ?? '', 'name')
                    ->where('city_id', $request->input('city') ?? $residence?->city_id),
                'regex:/^[a-zA-Z]+[a-zA-Z\s]*[a-zA-Z]+$/',
                'min:3',
                'max:50',
            ],
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id',
            'category' => 'required|exists:residence_categories,id',
            'description' => 'required|string',
            'website' => 'required|active_url',
            'email' => 'required|email',
            'contact' => 'required|regex:/^[a-zA-Z]+[a-zA-Z\s]*[a-zA-Z]+$/',
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
