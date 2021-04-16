<?php

namespace App\Actions\Fortify;

use App\Rules\CanChangeUsername;
use App\Rules\NotOffensive;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        $input['display_name'] = trim($input['display_name']);

        Validator::make($input, [
            'display_name' => [
                'required',
                'string',
                'between:3,16',
                'regex:/^[ 0-9a-zA-Z\x{00c0}-\x{00ff}\x{0400}-\x{045f}\x{3131}-\x{318e}\x{ac00}-\x{d7a3}]{3,16}$/u',
                'not_regex:/^' . config('app.blocked_names') . '$/i',
                Rule::unique('users')->ignore($user->id),
                new CanChangeUsername(),
                new NotOffensive('names'),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'email_confirmation' => [
                Rule::requiredIf(auth()->user()->email !== $input['email']),
                'same:email',
                'string',
                'email',
                'max:255',
            ],
            'photo' => [
                'nullable',
                'mimes:jpg,jpeg,png',
                'max:1024',
            ],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'display_name' => $input['display_name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'display_name' => $input['display_name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
