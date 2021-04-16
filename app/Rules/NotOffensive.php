<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotOffensive implements Rule
{
    protected $list;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        protected string $fieldName,
        string $listName,
    ) {
        $this->list = collect(config("wordlist.$listName", []));
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
        return !$this->list->contains(strtolower($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "That $this->fieldName is not allowed.";
    }
}
