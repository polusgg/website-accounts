<x-jet-action-section submit="updateDiscord">
    <x-slot name="title">
        {{ __('Discord Integration') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Manage a connected Discord account to enable any of your unlocked Patreon or Content Creator perks.') }}
    </x-slot>

    <x-slot name="content">
        <div class="space-y-5">
            @if ($this->isDiscordConnected)
                <div class="max-w-xl text-base text-gray-600">
                    <p>{{ __('Logged in as') }} <span class="font-bold">{{ $this->user->discord_username }}</span></p>
                </div>
            @endif

            @if ($this->user->discordRoles->isNotEmpty())
                <div class="space-y-1">
                    @foreach ($this->user->discordRoles as $role)
                        {{-- <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-base font-black" style="background-color: rgba(55, 57, 62, 1); color: {{ $role->rgbColor }};"> --}}
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-bold border-2" style="border-color: {{ $role->rgbColor }};">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2" style="color: {{ $role->rgbColor }};" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            {{ $role->display_name }}
                        </span>
                    @endforeach
                </div>
            @endif

            @if ($this->isDiscordConnected)
                <div class="flex items-center">
                    @if (!$this->user->is_in_polus_discord)
                        <x-jet-button wire:click="joinDiscord" wire:loading.attr="disabled" class="mr-2">
                            {{ __('Join the Polus.gg Discord') }}
                        </x-jet-button>
                    @endif

                    <x-jet-danger-button wire:click="confirmDiscordDisconnection" wire:loading.attr="disabled">
                        {{ __('Disconnect from Discord') }}
                    </x-jet-danger-button>
                </div>

                <!-- Disconnect Discord Confirmation Modal -->
                <x-jet-dialog-modal wire:model="confirmingDiscordDisconnection">
                    <x-slot name="title">
                        {{ __('Disconnect from Discord') }}
                    </x-slot>

                    <x-slot name="content">
                        {{ __('Once your Discord account is disconnected, you will lose access to all perks tied to a Patreon account or Content Creator status.') }}
                    </x-slot>

                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="$toggle('confirmingDiscordDisconnection')" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-jet-secondary-button>

                        <x-jet-danger-button class="ml-2" wire:click="disconnectDiscord" wire:loading.attr="disabled">
                            {{ __('Disconnect from Discord') }}
                        </x-jet-danger-button>
                    </x-slot>
                </x-jet-dialog-modal>
            @else
                <div class="flex items-center">
                    <a href="{{ route('discord.connect') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        {{ __('Connect your Discord account') }}
                    </a>
                </div>
            @endif
        </div>
    </x-slot>
</x-jet-action-section>
