<?php

namespace App\View\Components;

use App\Models\HousingFormula;
use Illuminate\View\Component;

class HousingFormulaSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $value = '',
        public bool $required = true,
        public bool $returnOld = true,
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
        return view('components.housing-formula-select', [
            'formulas' => HousingFormula::get(['id', 'name']),
        ]);
    }
}
