<?php

namespace App\Http\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\HousingFormulaIframe;
use App\Models\HousingFormula;
use App\Rules\AlphaOneSpaceBetween;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HousingFormulaController extends Controller
{
    public function index()
    {
        return view('admin.housing_formulas.index', [
            'housingFormulas' => HousingFormula::orderBy('order_by')->get(['id', 'name', 'order_by', 'is_active']),
        ]);
    }

    public function create()
    {
        return view('admin.housing_formulas.create');
    }

    public function store(Request $request)
    {
        HousingFormula::create($this->validateHousingFormula($request));

        return HousingFormulaIframe::iframeCUClose() . '<br>' . HousingFormulaIframe::reloadParent();
    }

    public function edit(HousingFormula $formula)
    {
        return view('admin.housing_formulas.edit', [
            'housingFormula' => $formula,
        ]);
    }

    public function update(Request $request, HousingFormula $formula)
    {
        $formula->update($this->validateHousingFormula($request, $formula));

        return HousingFormulaIframe::iframeCUClose() . '<br>' . HousingFormulaIframe::reloadParent();
    }

    public function delete(HousingFormula $formula)
    {
        return view('admin.housing_formulas.delete', [
            'housingFormulaName' => $formula->name,
        ]);
    }

    public function destroy(HousingFormula $formula)
    {
        if ($formula->prices()->count() > 0) {
            return NotiflixHelper::report(
                "You can\'t delete $formula->name formula it has linked prices!",
                'failure',
                HousingFormulaIframe::$iframeDId,
            );
        }

        $formula->delete();

        return HousingFormulaIframe::hideIframeD() . '<br>' . HousingFormulaIframe::reloadParent();
    }

    protected function validateHousingFormula(Request $request, HousingFormula $formula = null)
    {
        $attributes = $request->validate([
            'name' => [
                'required',
                new AlphaOneSpaceBetween(),
                Rule::unique('housing_formulas')->ignore($formula->name ?? '', 'name'),
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
