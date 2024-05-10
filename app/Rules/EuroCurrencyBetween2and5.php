<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EuroCurrencyBetween2and5 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (trim($value) === '') {
            $fail('The :attribute is required.');
        }

        $value = (new \NumberFormatter('pt-PT', \NumberFormatter::CURRENCY))
            ->parse(preg_replace('/\s+/', "\u{A0}", $value));

        if ($value === false) {
            $fail('The :attribute must be given in the "#,## €" format.');
        }

        if ($value < 2 || $value > 5) {
            $fail('The :attribute must be between 2,00 € and 5,00 €');
        }
    }
}
