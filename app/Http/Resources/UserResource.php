<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'success' => true,
            'data' => [
                'client_id' => $this->uuid,
                'client_token' => $this->api_token,
                'discord_id' => $this->discord_snowflake,
                'display_name' => $this->display_name,
                'created_at' => $this->created_at,
                'name_change_available_at' => $this->name_change_available_at,
                'banned' => $this->is_banned,
                'banned_until' => $this->is_banned ? $this->activeBan->banned_until : null,
                'muted' => $this->is_muted,
                'muted_until' => $this->is_muted ? $this->activeMute->muted_until : null,
                'perks' => GamePerkResource::collection($this->gamePerks),
                'settings' => new GamePerkConfigResource($this->gamePerkConfig),
                'options' => new GameConfigResource($this->gameConfig),
                'cosmetics' => new CosmeticConfigResource($this->cosmeticConfig),
            ],
        ];
    }
}
