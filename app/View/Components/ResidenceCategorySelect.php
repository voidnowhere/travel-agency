<?php

namespace App\View\Components;

use App\Models\ResidenceCategory;
use Illuminate\View\Component;

class ResidenceCategorySelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $value = '',
        public bool   $required = true,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.residence-category-select', [
            'residenceCategories' => ResidenceCategory::get(['id', 'name']),
        ]);
    }
}
