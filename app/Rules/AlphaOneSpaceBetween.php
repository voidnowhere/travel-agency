<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class AlphaOneSpaceBetween implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!preg_match('/^[a-zA-Z]+( [a-zA-Z]+)*$/', $value)) {
            $fail('The :attribute must be valid.');
        }
    }
}
