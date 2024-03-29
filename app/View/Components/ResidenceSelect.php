<?php

namespace App\View\Components;

use App\Models\City;
use Illuminate\View\Component;

class ResidenceSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public City   $city,
        public bool   $default = true,
        public string $value = '',
        public bool   $required = true,
        public string $onChange = '',
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
        return view('components.residence-select', [
            'residences' => ($this->activeOnly)
                ? $this->city->residences()->active()->get(['id', 'name'])
                : $this->city->residences()->get(['id', 'name']),
        ]);
    }
}
