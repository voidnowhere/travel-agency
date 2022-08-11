<?php

namespace App\Http\Controllers;

use App\Iframes\HousingCategoryIframe;
use App\Models\HousingCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HousingCategoryController extends Controller
{
    public function index()
    {
        return view('admin.housing_categories.index', [
            'housingCategories' => HousingCategory::orderBy('order_by')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.housing_categories.create');
    }

    public function store(Request $request)
    {
        HousingCategory::create($this->validateHousingCategory($request));

        return
            HousingCategoryIframe::iframeCUClose()
            . '<br>' .
            HousingCategoryIframe::reloadParent();
    }

    public function edit(HousingCategory $category)
    {
        return view('admin.housing_categories.edit', [
            'housingCategory' => $category,
        ]);
    }

    public function update(Request $request, HousingCategory $category)
    {
        $category->update($this->validateHousingCategory($request, $category));

        return
            HousingCategoryIframe::iframeCUClose()
            . '<br>' .
            HousingCategoryIframe::reloadParent();
    }

    public function delete(HousingCategory $category)
    {
        return view('admin.housing_categories.delete', [
            'housingCategoryName' => $category->name,
        ]);
    }

    public function destroy(HousingCategory $category)
    {
        $category->delete();

        return HousingCategoryIframe::reloadParent();
    }

    protected function validateHousingCategory(Request $request, HousingCategory $category = null)
    {
        $attributes = $request->validate([
            'name' => [
                'required',
                'min:2',
                'max:25',
                'alpha',
                Rule::unique('housing_categories')->ignore($category->name ?? '', 'name'),
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