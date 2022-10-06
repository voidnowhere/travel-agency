<?php

namespace App\Http\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\HousingIframe;
use App\Models\Housing;
use App\Models\Residence;
use App\Rules\AlphaOneSpaceBetween;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HousingController extends Controller
{
    public function index()
    {
        return view('admin.housings.index', [
            'housings' => Housing::with(['residence:id,name', 'category:id,name'])
                ->orderBy('order_by')
                ->get(['id', 'residence_id', 'housing_category_id', 'name', 'description', 'for_max', 'order_by', 'is_active']),
        ]);
    }

    public function get(Request $request)
    {
        $residence_id = $request->validate(['residence_id' => 'required|int'])['residence_id'];

        return Residence::findOrFail($residence_id)->housings()->orderBy('order_by')->get(['id', 'name']);
    }

    public function getActive(Request $request)
    {
        $residence_id = $request->validate(['residence_id' => 'required|int'])['residence_id'];

        return Residence::findOrFail($residence_id)->housings()->active()->orderBy('order_by')->get(['id', 'name']);
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
        if ($housing->prices()->count() > 0) {
            return NotiflixHelper::report(
                "You can\'t delete $housing->name housing it has linked prices!",
                'failure',
                HousingIframe::$iframeDId,
            );
        }

        $housing->delete();

        return HousingIframe::hideIframeD() . '<br>' . HousingIframe::reloadParent();
    }

    protected function validateHousing(Request $request, Housing $housing = null)
    {
        $attributes = $request->validate([
            'name' => [
                'required',
                new AlphaOneSpaceBetween(),
                Rule::unique('housings')
                    ->ignore($housing->name ?? '', 'name')
                    ->where('residence_id', $request->input('residence') ?? $housing?->residence_id)
                    ->where('housing_category_id', $request->input('category') ?? $housing?->housing_category_id),
            ],
            'residence' => 'required|exists:residences,id',
            'category' => 'required|exists:housing_categories,id',
            'description' => 'required',
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
