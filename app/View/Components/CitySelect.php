<?php

namespace App\View\Components;

use App\Models\Country;
use Illuminate\View\Component;

class CitySelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Country $country,
        public string  $onChange = '',
        public bool    $default = true,
        public string  $value = '',
        public bool    $required = true,
        public bool    $activeOnly = false,
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
        return view('components.city-select', [
            'cities' => ($this->activeOnly)
                ? $this->country->cities()->active()->get(['id', 'name'])
                : $this->country->cities()->get(['id', 'name']),
        ]);
    }
}
