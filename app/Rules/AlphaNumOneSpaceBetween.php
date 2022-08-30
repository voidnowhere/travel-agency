<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class AlphaNumOneSpaceBetween implements InvokableRule
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
        if (!preg_match('/^[a-zA-Z0-9]+( [a-zA-Z0-9]+)*$/', $value)) {
            $fail('The :attribute must only contain letters and numbers.');
        }
    }
}
