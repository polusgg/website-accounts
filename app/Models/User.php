<?php

namespace App\Models;

use App\Discord\Discord;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        'discord_token' => 'encrypted',
        'discord_refresh_token' => 'encrypted',
        'discord_expires_at' => 'datetime',
    ];

    protected $with = ['discordRoles', 'activeBan', 'gamePerkConfig', 'gameConfig'];

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
            if ($user->isDirty('display_name')) {
                $user->name_change_available_at = Carbon::now()->addSeconds(config('polus.name_change_seconds'));
            }

            if ($user->isDirty('password')) {
                $user->api_token = Str::random(60);
            }
        });

        static::updated(function ($user) {
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

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function discordRoles(): BelongsToMany
    {
        return $this->belongsToMany(DiscordRole::class);
    }

    public function hasAnyDiscordRoles($roles): bool
    {
        if ($this->discordRoles->isEmpty()) {
            return false;
        }

        $roles = collect(is_string($roles) ? func_get_args() : $roles);

        return $this->discordRoles->map->display_name->intersect($roles)->count() > 0;
    }

    public function hasAllDiscordRoles($roles): bool
    {
        if ($this->discordRoles->isEmpty()) {
            return false;
        }

        $roles = collect(is_string($roles) ? func_get_args() : $roles);

        return $this->discordRoles->map->display_name->intersect($roles)->count() == $roles->count();
    }

    public function bansFrom(): HasMany
    {
        return $this->hasMany(KickBanLog::class, 'acting_user_id');
    }

    public function bansAgainst(): HasMany
    {
        return $this->hasMany(KickBanLog::class, 'target_user_id');
    }

    public function activeBan(): HasOne
    {
        return $this->hasOne(KickBanLog::class, 'target_user_id')
                    ->orderByDesc('banned_until')
                    ->latest();
    }

    public function getIsBannedAttribute(): bool
    {
        $activeBan = $this->activeBan;

        return !is_null($activeBan)
            && Carbon::now()->lt($activeBan->banned_until);
    }

    public function getGamePerksAttribute()
    {
        return $this->discordRoles->flatMap->gamePerks->unique('id');
    }

    public function hasAnyPerks($perks): bool
    {
        $perks = collect(is_string($perks) ? func_get_args() : $perks);

        return $this->game_perks->map->perk_key->intersect($perks)->count() > 0;
    }

    public function hasAllPerks($perks): bool
    {
        $perks = collect(is_string($perks) ? func_get_args() : $perks);

        return $this->game_perks->map->perk_key->intersect($perks)->count() == $perks->count();
    }

    public function gamePerkConfig(): HasOne
    {
        return $this->hasOne(GamePerkConfig::class);
    }

    public function gameConfig(): HasOne
    {
        return $this->hasOne(GameConfig::class);
    }

    public function getIsDiscordConnectedAttribute(): bool
    {
        return !empty($this->discord_token)
            && app(Discord::class)->isConnected($this->discord_token);
    }

    public function getDiscordUsernameAttribute(): ?string
    {
        return app(Discord::class)->getUsername($this->discord_token);
    }

    public function getIsInPolusDiscordAttribute(): bool
    {
        return app(Discord::class)->isInGuild($this->discord_token, config('services.discord.guild_id'));
    }

    public function getDiscordTokenAttribute($token): ?string
    {
        if (empty($token)) {
            return null;
        }

        if (Carbon::now()->lt(Carbon::parse($this->discord_expires_at))) {
            return Crypt::decryptString($token);
        }

        $response = $this->refreshDiscordToken();

        if (!$response->successful()) {
            return '';
        }

        $this->discord_token = $response['access_token'];
        $this->discord_refresh_token = $response['refresh_token'];
        $this->discord_expires_at = Carbon::now()->addSeconds($response['expires_in']);

        $this->save();

        return $response['access_token'];
    }

    protected function refreshDiscordToken()
    {
        return Http::withHeaders([
            'Accept' => 'application/json',
        ])->asForm()->post('https://discordapp.com/api/v8/oauth2/token', [
            'client_id' => config('services.discord.client_id'),
            'client_secret' => config('services.discord.client_secret'),
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->discord_refresh_token,
        ]);
    }

    protected function defaultProfilePhotoUrl()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->email).'&color=C3B5FD&background=111827';
    }
}
