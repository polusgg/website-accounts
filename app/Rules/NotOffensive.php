<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Collection;

class NotOffensive implements Rule
{
    protected Collection $list;

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
    public function passes($attribute, $value): bool
    {
        return !$this->list->contains(strtolower($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "That $this->fieldName is not allowed.";
    }
}
