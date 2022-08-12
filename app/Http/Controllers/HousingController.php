<?php

namespace App\Http\Controllers;

use App\Iframes\HousingIframe;
use App\Models\Housing;
use App\Models\Residence;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HousingController extends Controller
{
    public function index()
    {
        return view('admin.housings.index', [
            'housings' => Housing::with('residence', 'category')->orderBy('order_by')->get(),
        ]);
    }

    public function get(Request $request)
    {
        $residence_id = $request->validate(['residence_id' => 'required|int'])['residence_id'];

        return Residence::findOrFail($residence_id)->housings()->get(['id', 'name']);
    }

    public function create()
    {
        return view('admin.housings.create');
    }

    public function store(Request $request)
    {
        Housing::create($this->validateHousing($request));

        return HousingIframe::iframeCUClose() . '<br>' . HousingIframe::reloadParent();
    }

    public function edit(Housing $housing)
    {
        return view('admin.housings.edit', [
            'housing' => $housing,
        ]);
    }

    public function update(Request $request, Housing $housing)
    {
        $housing->update($this->validateHousing($request, $housing));

        return HousingIframe::iframeCUClose() . '<br>' . HousingIframe::reloadParent();
    }

    public function delete(Housing $housing)
    {
        return view('admin.housings.delete', [
            'housingName' => $housing->name,
        ]);
    }

    public function destroy(Housing $housing)
    {
        $housing->delete();

        return HousingIframe::reloadParent();
    }

    public function validateHousing(Request $request, Housing $housing = null)
    {
        $attributes = $request->validate([
            'name' => [
                'required',
                Rule::unique('housings')
                    ->ignore($housing->name ?? '', 'name')
                    ->where('residence_id', $request->input('residence') ?? $housing?->residence_id)
                    ->where('housing_category_id', $request->input('category') ?? $housing?->housing_category_id),
                'regex:/^[a-zA-Z]+[a-zA-Z\s]*[a-zA-Z]+$/',
                'min:3',
                'max:50',
            ],
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id',
            'residence' => 'required|exists:residences,id',
            'category' => 'required|exists:housing_categories,id',
            'description' => 'required|string',
            'max' => 'required|int',
            'order' => 'required|int',
            'active' => 'nullable',
        ]);

        $attributes['active'] = (bool)($attributes['active'] ?? false);

        return [
            'name' => $attributes['name'],
            'residence_id' => $attributes['residence'],
            'housing_category_id' => $attributes['category'],
            'description' => $attributes['description'],
            'for_max' => $attributes['max'],
            'order_by' => $attributes['order'],
            'is_active' => $attributes['active'],
        ];
    }
}
