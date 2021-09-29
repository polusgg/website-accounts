<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidLanguage implements Rule
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
    public function passes($attribute, $value): bool
    {
        return collect(config("languages", []))
            ->keys()
            ->contains(strtolower($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'That is not a valid language.';
    }
}
