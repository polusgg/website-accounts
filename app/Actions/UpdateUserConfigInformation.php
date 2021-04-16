<?php

namespace App\Actions;

use App\Rules\CanChangeNameColor;
use App\Rules\NotOffensive;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserConfigInformation implements UpdatesUserConfigInformation
{
    public function update($config, array $input)
    {
        $input['lobby_code_custom_value'] = strtoupper(trim($input['lobby_code_custom_value']));

        Validator::make($input, [
            'lobby_code_custom_value' => [
                'string',
                'regex:/^([a-z]{2}){2,3}$/i',
                Rule::unique('game_perk_configs')->ignore($config->id),
                new NotOffensive('codes'),
            ],
            'name_color' => [
                'required',
                new CanChangeNameColor(),
            ],
        ])->validateWithBag('updateConfigInformation');

        $config->forceFill([
            'lobby_code_custom_value' => $input['lobby_code_custom_value'],
            'name_color_gold_enabled' => $input['name_color'] == 'gold',
            'name_color_match_enabled' => $input['name_color'] == 'match',
        ])->save();
    }
}
