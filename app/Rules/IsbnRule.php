<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsbnRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // There is a proper rule to check if it's a string
        if (is_string($value)) {
            if ((strlen($value) != 10) && (strlen($value) != 13)) {
                $fail('The :attribute field must have 10 or 13 digits.');
            }

            // I didn't use the 'regex' available rule because the error msg is too generic.
            if (!preg_match('/^[a-zA-Z0-9]+$/', $value)) {
                $fail('The :attribute field only accepts letters and numbers.');
            }
        }
    }
}
