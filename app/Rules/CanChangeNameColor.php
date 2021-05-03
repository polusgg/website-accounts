<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CanChangeNameColor implements Rule
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
        switch ($value) {
            case 'normal':
                return true;
            case 'gold':
            case 'match':
                $user = auth()->user();

                $user->fresh();

                return $user->hasAnyPerks("name.color.$value");
            default:
                return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "That is not a valid option for you.";
    }
}
