<?php

namespace App\View\Components;

use App\Models\City;
use App\Models\Country;
use Illuminate\View\Component;

class CitiesSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public Country $country, public string $value = '', public bool $required = true)
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
        return view('components.cities-select', [
            'cities' => $this->country->cities()->get(['id', 'name']),
        ]);
    }
}
