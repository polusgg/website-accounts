<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPronouns implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return collect(config("pronouns", []))
            ->keys()
            ->contains(strtolower($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Those are not valid pronouns.';
    }
}
