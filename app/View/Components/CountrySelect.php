<?php

namespace App\View\Components;

use App\Models\Country;
use Illuminate\View\Component;

class CountrySelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $value = '',
        public string $onChange = '',
        public bool   $required = true,
        public bool   $returnOld = true,
        public bool   $activeOnly = false,
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
        return view('components.country-select', [
            'countries' => ($this->activeOnly) ? Country::active()->get(['id', 'name']) : Country::get(['id', 'name']),
        ]);
    }
}
