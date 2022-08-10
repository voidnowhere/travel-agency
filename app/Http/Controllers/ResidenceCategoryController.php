<?php

namespace App\Http\Controllers;

use App\Helpers\JavaScriptHelper;
use App\Iframes\ResidenceCategoryIframe;
use App\Models\ResidenceCategory;
use \Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResidenceCategoryController extends Controller
{
    public function index()
    {
        return view('admin.residence_categories.index', [
            'residenceCategories' => ResidenceCategory::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.residence_categories.create');
    }

    public function store(Request $request)
    {
        ResidenceCategory::create($this->validateResidenceCategory($request));

        return
            ResidenceCategoryIframe::iframeCUClose()
            . '<br>' .
            ResidenceCategoryIframe::reloadParent();
    }

    public function edit(ResidenceCategory $category)
    {
        return view('admin.residence_categories.edit', [
            'residenceCategory' => $category,
        ]);
    }

    public function update(Request $request, ResidenceCategory $category)
    {
        $category->update($this->validateResidenceCategory($request, $category));

        return
            ResidenceCategoryIframe::iframeCUClose()
            . '<br>' .
            ResidenceCategoryIframe::reloadParent();
    }

    public function delete(ResidenceCategory $category)
    {
        return view('admin.residence_categories.delete', [
            'residenceCategoryName' => $category->name,
        ]);
    }

    public function destroy(ResidenceCategory $category)
    {
        if ($category->residences()->count() > 0) {
            return JavaScriptHelper::alert("You can't delete $category->name category it has linked residences!");
        }

        $category->delete();

        return ResidenceCategoryIframe::reloadParent();
    }

    protected function validateResidenceCategory(Request $request, ResidenceCategory $category = null)
    {
        $attributes = $request->validate([
            'name' => [
                'required',
                'min:2',
                'max:25',
                'alpha',
                Rule::unique('residence_categories')->ignore($category->name ?? '', 'name'),
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
