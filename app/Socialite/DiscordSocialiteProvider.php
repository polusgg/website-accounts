<?php

namespace App\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

class DiscordSocialiteProvider extends AbstractProvider implements ProviderInterface
{
    protected $scopes = [
        'identify',
        'guilds',
        'guilds.join',
    ];

    protected $scopeSeparator = ' ';

    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase('https://discordapp.com/api/oauth2/authorize', $state);
    }

    protected function getTokenUrl(): string
    {
        return 'https://discordapp.com/api/oauth2/token';
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            'https://discord.com/api/v8/users/@me',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function formatAvatar(array $user): ?string
    {
        if (empty($user['avatar'])) {
            return null;
        }

        return sprintf(
            'https://cdn.discordapp.com/avatars/%s/%s.%s',
            $user['id'],
            $user['avatar'],
            preg_match('/a_.+/m', $user['avatar']) === 1 ? 'gif' : 'png',
        );
    }

    protected function mapUserToObject(array $user): User
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'nickname' => sprintf('%s#%s', $user['username'], $user['discriminator']),
            'name' => $user['username'],
            'email' => $user['email'] ?? null,
            'avatar' => $this->formatAvatar($user),
        ]);
    }

    protected function getTokenFields($code): array
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
}
