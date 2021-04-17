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
                'display_name' => $this->display_name,
                'banned_until' => $this->is_banned ? $this->activeBan->banned_until : null,
                'perks' => GamePerkResource::collection($this->gamePerks),
                'settings' => new GamePerkConfigResource($this->gamePerkConfig),
            ],
        ];
    }
}
