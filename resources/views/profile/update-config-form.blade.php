<x-jet-form-section submit="updateConfig">
    <x-slot name="title">
        {{ __('In-Game Options') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Change the settings for your unlocked in-game perks.') }}
    </x-slot>

    <x-slot name="form">
        @if ($this->user->hasAnyPerks('lobby.code.custom'))
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="lobby_code_custom_value" value="{{ __('Custom Lobby Code') }}" />
                <x-jet-input id="lobby_code_custom_value" type="text" class="mt-1 block w-full" wire:model.defer="state.lobby_code_custom_value" autocomplete="lobby_code_custom_value" />
                <x-jet-input-error for="lobby_code_custom_value" class="mt-2" />
            </div>
        @endif

        @if ($this->user->hasAnyPerks('name.color.gold', 'name.color.match'))
            <div class="col-span-6 sm:col-span-4">
                <fieldset>
                    <legend class="sr-only">
                        Name color options
                    </legend>
                    <div class="bg-white rounded-md -space-y-px">
                        <label class="border-gray-200 rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer">
                            <input type="radio" name="name_color" value="normal" wire:model.defer="state.name_color" class="h-4 w-4 mt-0.5 cursor-pointer text-indigo-600 border-gray-300 focus:ring-indigo-500" aria-labelledby="name-color-setting-0-label" aria-describedby="name-color-setting-0-description">
                            <div class="ml-3 flex flex-col">
                                <span id="name-color-setting-0-label" class="text-gray-700 block text-sm font-medium">
                                    Normal player name
                                </span>
                                <span id="name-color-setting-0-description" class="text-gray-500 block text-sm">
                                    Your in-game name will not be colored.
                                </span>
                            </div>
                        </label>
                        @if ($this->user->hasAnyPerks('name.color.gold'))
                            <label class="border-gray-200 relative border p-4 flex cursor-pointer">
                                <input type="radio" name="name_color" value="gold" wire:model.defer="state.name_color" class="h-4 w-4 mt-0.5 cursor-pointer text-indigo-600 border-gray-300 focus:ring-indigo-500" aria-labelledby="name-color-setting-1-label" aria-describedby="name-color-setting-1-description">
                                <div class="ml-3 flex flex-col">
                                    <span id="name-color-setting-1-label" class="text-gray-700 block text-sm font-medium">
                                        Gold player name
                                    </span>
                                    <span id="name-color-setting-1-description" class="text-gray-500 block text-sm">
                                        Your in-game name will be colored gold.
                                    </span>
                                </div>
                            </label>
                        @endif
                        @if ($this->user->hasAnyPerks('name.color.match'))
                            <label class="border-gray-200 rounded-bl-md rounded-br-md relative border p-4 flex cursor-pointer">
                                <input type="radio" name="name_color" value="match" wire:model.defer="state.name_color" class="h-4 w-4 mt-0.5 cursor-pointer text-indigo-600 border-gray-300 focus:ring-indigo-500" aria-labelledby="name-color-setting-2-label" aria-describedby="name-color-setting-2-description">
                                <div class="ml-3 flex flex-col">
                                    <span id="name-color-setting-2-label" class="text-gray-700 block text-sm font-medium">
                                        Matching player name
                                    </span>
                                    <span id="name-color-setting-2-description" class="text-gray-500 block text-sm">
                                        Your in-game name will be colored to match your character color.
                                    </span>
                                </div>
                            </label>
                        @endif
                    </div>
                </fieldset>
            </div>
        @endif

        {{-- @if ($this->user->hasAnyPerks('name.color.gold'))
            <div class="col-span-6 sm:col-span-4">
                <div class="flex items-center justify-between space-x-4">
                    <x-jet-checkbox id="name_color_gold_enabled" wire:model.defer="state.name_color_gold_enabled" />
                    <label for="name_color_gold_enabled" class="flex-grow flex flex-col" id="availability-label">
                        <span class="text-sm font-medium text-gray-700">Gold player name</span>
                        <span class="text-sm text-gray-500">Your player name will be colored gold when enabled.</span>
                    </label>
                    <x-jet-input-error for="name_color_gold_enabled" class="mt-2" />
                </div>
            </div>
        @endif

        @if ($this->user->hasAnyPerks('name.color.match'))
            <div class="col-span-6 sm:col-span-4">
                <div class="flex items-center justify-between space-x-4">
                    <x-jet-checkbox id="name_color_match_enabled" wire:model.defer="state.name_color_match_enabled" />
                    <label for="name_color_match_enabled" class="flex-grow flex flex-col" id="availability-label">
                        <span class="text-sm font-medium text-gray-700">Matching player name</span>
                        <span class="text-sm text-gray-500">Your player name will match your player color when enabled.</span>
                    </label>
                    <x-jet-input-error for="name_color_match_enabled" class="mt-2" />
                </div>
            </div>
        @endif

        @if ($this->user->hasAllPerks('name.color.gold', 'name.color.match'))
            <div class="col-span-6 sm:col-span-4">
                <div class="flex items-start justify-between space-x-2">
                    <div class="max-w-xl text-sm text-gray-600">
                        <p><span class="font-bold">Note:</span></p>
                    </div>
                    <div class="max-w-xl text-sm text-gray-600">
                        <p><span class="italic">Matching player name</span> takes precedence over <span class="italic">Gold player name</span> and so it should be disabled if you prefer a gold name.</p>
                    </div>
                </div>
            </div>
        @endif --}}
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
