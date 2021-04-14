<?php

namespace App\Discord;

use GuzzleHttp\Client as HttpClient;

class Discord
{
    protected $baseUrl = 'https://discordapp.com/api';

    public function __construct(
        protected HttpClient $http,
        protected string $botToken,
        protected string $guildId,
    ) {
    }

    public function getUsername(string $token)
    {
        $response = $this->requestClient('GET', 'users/@me', $token);

        return sprintf('%s#%s', $response['username'], $response['discriminator']);
    }

    public function joinGuild(string $userId, string $accessToken)
    {
        $this->requestBot('PUT', sprintf('guilds/%s/members/%s', $this->guildId, $userId), [
            'access_token' => $accessToken,
        ]);
    }

    public function getGuilds(string $token)
    {
        return collect($this->requestClient('GET', 'users/@me/guilds', $token));
    }

    public function isInGuild(string $token, string $guildId)
    {
        return $this->getGuilds($token)->contains(fn($guild) => $guild['id'] == $guildId);
    }

    public function getRoles(string $userId)
    {
        return collect($this->requestBot('GET', sprintf('guilds/%s/members/%s', $this->guildId, $userId))['roles'] ?? []);
    }

    public function hasRole(string $userId, string $roleId)
    {
        return $this->getRoles($userId)->contains(fn($role) => $role['id'] == $roleId);
    }

    protected function requestClient(string $method, string $endpoint, string $token, array $data = [])
    {
        return $this->request($method, $endpoint, 'Bearer ' . $token, $data);
    }

    protected function requestBot(string $method, string $endpoint, array $data = [])
    {
        return $this->request($method, $endpoint, 'Bot ' . $this->botToken, $data);
    }

    protected function request(string $method, string $endpoint, string $auth, array $data = [])
    {
        $url = sprintf('%s/%s', rtrim($this->baseUrl, '/'), ltrim($endpoint, '/'));
        $body = [
            'http_errors' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $auth,
            ],
        ] + $data;

        $response = $this->http->request($method, $url, $body);
        $response = json_decode($response->getBody()->getContents(), true);

        // TODO: Return an array with response code and body json
        return $response;
        // return collect($response);
    }
}
