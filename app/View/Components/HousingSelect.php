<?php

namespace App\View\Components;

use App\Models\Residence;
use Illuminate\View\Component;

class HousingSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Residence $residence,
        public bool      $default = true,
        public string    $value = '',
        public bool      $required = true,
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
        return view('components.housing-select', [
            'housings' => $this->residence->housings()->get(['id', 'name']),
        ]);
    }
}
