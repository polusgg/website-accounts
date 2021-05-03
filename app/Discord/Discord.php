<?php

namespace App\Discord;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Discord
{
    protected string $baseUrl = 'https://discord.com/api/v8';

    public function __construct(
        protected string $botToken,
        protected string $guildId,
    ) {
    }

    public function isConnected(?string $token): bool
    {
        return !empty($token)
            && Http::withHeaders($this->getHeaders($token))
                   ->get($this->getUrl('oauth2/@me'))
                   ->successful();
    }

    public function getUsername(string $token): ?string
    {
        if (empty($token)) {
            return null;
        }

        $response = Http::withHeaders($this->getHeaders($token))
                        ->get($this->getUrl('users/@me'));

        return $response->ok() ? sprintf('%s#%s', $response['username'], $response['discriminator']) : null;
    }

    public function joinGuild(string $userId, ?string $accessToken)
    {
        if (empty($accessToken)) {
            return;
        }

        Http::withHeaders($this->getHeaders($this->botToken, 'Bot'))
            ->put($this->getUrl(sprintf('guilds/%s/members/%s', $this->guildId, $userId)), [
                'access_token' => $accessToken,
            ]);
    }

    public function getGuilds(?string $token): Collection
    {
        if (empty($token)) {
            return collect();
        }

        $response = Http::withHeaders($this->getHeaders($token))
                        ->get($this->getUrl('users/@me/guilds'));

        return $response->ok() ? $response->collect() : collect();
    }

    public function isInGuild(?string $token, string $guildId): bool
    {
        return !empty($token)
            && $this->getGuilds($token)
                    ->contains(fn($guild) => $guild['id'] == $guildId);
    }

    public function getRoles(string $userId): Collection
    {
        $response = Http::withHeaders($this->getHeaders($this->botToken, 'Bot'))
                        ->get($this->getUrl(sprintf('guilds/%s/members/%s', $this->guildId, $userId)));

        return collect($response->ok() ? $response->json()['roles'] : []);
    }

    protected function getUrl(string $endpoint): string
    {
        return sprintf(
            '%s/%s',
            rtrim($this->baseUrl, '/'),
            ltrim($endpoint, '/'),
        );
    }

    protected function getHeaders(string $token, string $tokenPrefix = 'Bearer'): array
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => "$tokenPrefix $token",
        ];
    }
}
