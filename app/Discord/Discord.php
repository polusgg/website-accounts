<?php

namespace App\Discord;

use Http;

class Discord
{
    protected $baseUrl = 'https://discordapp.com/api/v8';

    public function __construct(
        protected string $botToken,
        protected string $guildId,
    ) {
    }

    public function isConnected(string $token)
    {
        return Http::withHeaders($this->getHeaders($token))->get($this->getUrl('oauth2/@me'))->successful();
    }

    public function getUsername(string $token)
    {
        $response = Http::withHeaders($this->getHeaders($token))
                        ->get($this->getUrl('users/@me'));

        return $response->ok() ? sprintf('%s#%s', $response['username'], $response['discriminator']) : null;
    }

    public function joinGuild(string $userId, string $accessToken)
    {
        Http::withHeaders($this->getHeaders($this->botToken, 'Bot'))
            ->put($this->getUrl(sprintf('guilds/%s/members/%s', $this->guildId, $userId)), [
                'access_token' => $accessToken,
            ]);
    }

    public function getGuilds(string $token)
    {
        $response = Http::withHeaders($this->getHeaders($token))
                        ->get($this->getUrl('users/@me/guilds'));

        return $response->ok() ? $response->collect() : collect();
    }

    public function isInGuild(string $token, string $guildId)
    {
        return $this->getGuilds($token)
                    ->contains(fn($guild) => $guild['id'] == $guildId);
    }

    public function getRoles(string $userId)
    {
        $response = Http::withHeaders($this->getHeaders($this->botToken, 'Bot'))
                        ->get($this->getUrl(sprintf('guilds/%s/members/%s', $this->guildId, $userId)));

        return collect($response->ok() ? $response->json()['roles'] : []);
    }

    public function hasRole(string $userId, string $roleId)
    {
        return $this->getRoles($userId)
                    ->contains(fn($role) => $role['id'] == $roleId);
    }

    protected function getUrl(string $endpoint)
    {
        return sprintf('%s/%s', rtrim($this->baseUrl, '/'), ltrim($endpoint, '/'));
    }

    protected function getHeaders(string $token, string $tokenPrefix = 'Bearer')
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => "$tokenPrefix $token",
        ];
    }
}
