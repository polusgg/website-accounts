<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GamePerkConfigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'lobby.code.custom' => $this->lobby_code_custom_value,
            'name.color.gold' => $this->name_color_gold_enabled,
            'name.color.match' => $this->name_color_match_enabled,
        ];
    }
}
