<?php

namespace App\Models;

use Str;
use App\Discord\Discord;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable// implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'discord_token',
        'discord_refresh_token',
        'discord_expires_at',
        'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_creator' => 'boolean',
        'name_change_available_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'discord_expires_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['gamePerks'];

    protected $with = ['discordRoles', 'discordRoles.gamePerks', 'activeBan', 'gamePerkConfig'];

    public static function booted()
    {
        static::creating(function ($user) {
            $user->uuid = Str::uuid();
            $user->name_change_available_at = Carbon::now();
            $user->api_token = Str::random(60);
        });

        static::created(function ($user) {
            $user->gamePerkConfig()->save(new GamePerkConfig());
        });

        static::updating(function ($user) {
            // if ($user->getOriginal()['display_name'] != $user->display_name) {
            if ($user->isDirty('display_name')) {
                $user->name_change_available_at = Carbon::now()->addSeconds(config('polus.name_change_seconds'));
            }

            if ($user->isDirty('password')) {
                $user->api_token = Str::random(60);
            }
        });

        static::updated(function ($user) {
            // if ($user->getOriginal()['is_creator'] != $user->is_creator) {
            if ($user->isDirty('is_creator')) {
                $creator = DiscordRole::where('role_snowflake', config('services.discord.creator_role_id'))->first();

                if (!$creator) {
                    return;
                }

                if ($user->is_creator) {
                    $user->discordRoles()->syncWithoutDetaching($creator);
                } else if (!$user->is_creator) {
                    $user->discordRoles()->detach($creator);
                }
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function discordRoles()
    {
        return $this->belongsToMany(DiscordRole::class);
    }

    public function hasAnyDiscordRoles($roles)
    {
        if ($this->discordRoles->isEmpty()) {
            return false;
        }

        $roles = collect(is_string($roles) ? func_get_args() : $roles);

        return $this->discordRoles->map->display_name->intersect($roles)->count() > 0;
    }

    public function hasAllDiscordRoles($roles)
    {
        if ($this->discordRoles->isEmpty()) {
            return false;
        }

        $roles = collect(is_string($roles) ? func_get_args() : $roles);

        return $this->discordRoles->map->display_name->intersect($roles)->count() == $roles->count();
    }

    public function bansFrom()
    {
        return $this->hasMany(KickBanLog::class, 'acting_user_id');
    }

    public function bansAgainst()
    {
        return $this->hasMany(KickBanLog::class, 'target_user_id');
    }

    public function activeBan()
    {
        return $this->hasOne(KickBanLog::class, 'target_user_id')->orderByDesc('banned_until')->latest();
    }

    public function getIsBannedAttribute()
    {
        $activeBan = $this->activeBan;

        return is_null($activeBan) ? false : Carbon::now()->lt($activeBan->banned_until);
    }

    public function getGamePerksAttribute()
    {
        return $this->discordRoles->flatMap->gamePerks->unique('id');
    }

    public function hasAnyPerks($perks)
    {
        $perks = collect(is_string($perks) ? func_get_args() : $perks);

        return $this->game_perks->map->perk_key->intersect($perks)->count() > 0;
    }

    public function hasAllPerks($perks)
    {
        $perks = collect(is_string($perks) ? func_get_args() : $perks);

        return $this->game_perks->map->perk_key->intersect($perks)->count() == $perks->count();
    }

    public function gamePerkConfig()
    {
        return $this->hasOne(GamePerkConfig::class);
    }

    public function getDiscordUsernameAttribute()
    {
        return app(Discord::class)->getUsername($this->discord_token);
    }

    public function getIsInPolusDiscordAttribute()
    {
        return app(Discord::class)->isInGuild($this->discord_token, config('services.discord.guild_id'));
    }

    public function getDiscordTokenAttribute($token)
    {
        if ($token == null || Carbon::now()->lt(Carbon::parse($this->discord_expires_at))) {
            return $token;
        }

        $response = $this->refreshDiscordToken();

        $this->discord_token = $response['access_token'];
        $user->discord_refresh_token = $response['refresh_token'];
        $user->discord_expires_at = Carbon::now()->addSeconds($response['expires_in']);

        $this->save();

        return $response['access_token'];
    }

    protected function refreshDiscordToken()
    {
        $client = new \GuzzleHttp\Client;
        $response = $client->get(
            'https://discordapp.com/api/oauth2/token',
            [
                'http_errors' => false,
                'headers' => [
                    'Accept' => 'application/json',
                    'Conent-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'client_id' => config('services.discord.client_id'),
                    'client_secret' => config('services.discord.client_secret'),
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->discord_refresh_token,
                    'redirect_uri' => config('services.discord.redirect'),
                    'scope' => 'identify guilds guilds.join',
                ],
            ],
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}
