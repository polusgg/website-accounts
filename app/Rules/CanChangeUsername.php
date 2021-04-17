<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CanChangeUsername implements Rule
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
        $user = auth()->user();

        $user->fresh();

        return strtolower($user->display_name) == strtolower($value) || Carbon::now()->gte($user->name_change_available_at);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $user = auth()->user();

        $user->fresh();

        $timestamp = $user->name_change_available_at->diffForHumans();

        return "Your next name change will be available $timestamp.";
    }
}
