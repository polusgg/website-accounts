<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\NotOffensive;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $input['display_name'] = trim($input['display_name']);

        Validator::make($input, [
            'display_name' => [
                'required',
                'string',
                'between:3,16',
                'regex:/^[ 0-9a-zA-Z\x{00c0}-\x{00ff}\x{0400}-\x{045f}\x{3131}-\x{318e}\x{ac00}-\x{d7a3}]{3,16}$/u',
                'not_regex:/^' . config('app.blocked_names') . '$/i',
                'unique:users',
                new NotOffensive('names'),
            ],
            'email' => ['required', 'string', 'email', 'confirmed', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::create([
            'display_name' => $input['display_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
