<?php

namespace App\Actions;

use App\Models\User;
use App\Rules\ValidLanguage;
use App\Rules\ValidPronouns;
use App\Rules\CanChangeNameColor;
use App\Rules\NotOffensive;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserConfigInformation implements UpdatesUserConfigInformation
{
    /**
     * @param User $user
     * @param array $input
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($user, array $input)
    {
        $config = $user->gamePerkConfig;
        $input['lobby_code_custom_value'] = strtoupper(trim($input['lobby_code_custom_value']));

        Validator::make($input, [
            'lobby_code_custom_value' => [
                'string',
                'regex:/^([a-z]{2}){2,3}$/i',
                Rule::unique('game_perk_configs')->ignore($config->id),
                new NotOffensive('lobby code', 'codes'),
            ],
            'name_color' => [
                'required',
                new CanChangeNameColor(),
            ],
            'language' => [
                'required',
                new ValidLanguage(),
            ],
            'pronouns' => [
                'required',
                new ValidPronouns(),
            ]
        ])->validateWithBag('updateConfigInformation');

        $config->forceFill([
            'lobby_code_custom_value' => $input['lobby_code_custom_value'],
            'name_color_gold_enabled' => $input['name_color'] == 'gold',
            'name_color_match_enabled' => $input['name_color'] == 'match',
        ])->save();

        $user->forceFill([
            'language' => $input['language'],
            'pronouns' => $input['pronouns'],
        ])->save();
    }
}
