<x-jet-form-section submit="updateConfig">
    <x-slot name="title">
        {{ __('In-Game Options') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Change some of your in-game settings.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="language" value="{{ __('Language') }}" />
            <select id="language" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-purple-300 dark:focus:border-purple-500 focus:ring focus:ring-purple-200 dark:focus:ring-purple-600 focus:ring-opacity-50 dark:focus:ring-opacity-100 rounded-md shadow-sm" wire:model.defer="state.language" autocomplete="language">
                @foreach ($languages as $languageKey => $languageName)
                    <option value="{{ $languageKey }}">{{ $languageName }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="language" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="pronouns" value="{{ __('Pronouns') }}" />
            <select id="pronouns" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-purple-300 dark:focus:border-purple-500 focus:ring focus:ring-purple-200 dark:focus:ring-purple-600 focus:ring-opacity-50 dark:focus:ring-opacity-100 rounded-md shadow-sm" wire:model.defer="state.pronouns" autocomplete="pronouns">
                @foreach ($pronouns as $pronounKey => $pronounName)
                    <option value="{{ $pronounKey }}">{{ $pronounName }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="pronouns" class="mt-2" />
        </div>

        @if ($this->user->hasAnyPerks('lobby.code.custom'))
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="lobby_code_custom_value" value="{{ __('Custom Lobby Code') }}" />
                <x-jet-input id="lobby_code_custom_value" type="text" class="mt-1 block w-full" wire:model.defer="state.lobby_code_custom_value" autocomplete="lobby_code_custom_value" />
                <x-jet-input-error for="lobby_code_custom_value" class="mt-2" />
            </div>
        @endif

        @if ($this->user->hasAnyPerks('name.color.gold', 'name.color.match'))
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name_color" value="{{ __('In-Game Name Color') }}" />
                <fieldset class="mt-1">
                    <legend class="sr-only">
                        In-game name color choices
                    </legend>
                    <div class="bg-white dark:bg-gray-900 rounded-md -space-y-px">
                        <label class="border-gray-200 dark:border-gray-700 rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer">
                            <input type="radio" name="name_color" value="normal" wire:model.defer="state.name_color" class="h-4 w-4 mt-0.5 cursor-pointer text-purple-600 border-gray-300 focus:ring-purple-500" aria-labelledby="name-color-setting-0-label" aria-describedby="name-color-setting-0-description">
                            <div class="ml-3 flex flex-col">
                                <span id="name-color-setting-0-label" class="text-gray-700 dark:text-gray-50 block text-sm font-medium">
                                    Normal player name
                                </span>
                                <span id="name-color-setting-0-description" class="text-gray-500 dark:text-gray-300 block text-sm">
                                    Your in-game name will not be colored.
                                </span>
                            </div>
                        </label>
                        @if ($this->user->hasAnyPerks('name.color.gold'))
                            <label class="border-gray-200 dark:border-gray-700 relative border p-4 flex cursor-pointer">
                                <input type="radio" name="name_color" value="gold" wire:model.defer="state.name_color" class="h-4 w-4 mt-0.5 cursor-pointer text-purple-600 border-gray-300 focus:ring-purple-500" aria-labelledby="name-color-setting-1-label" aria-describedby="name-color-setting-1-description">
                                <div class="ml-3 flex flex-col">
                                    <span id="name-color-setting-1-label" class="text-gray-700 dark:text-gray-50 block text-sm font-medium">
                                        Gold player name
                                    </span>
                                    <span id="name-color-setting-1-description" class="text-gray-500 dark:text-gray-300 block text-sm">
                                        Your in-game name will be colored gold.
                                    </span>
                                </div>
                            </label>
                        @endif
                        @if ($this->user->hasAnyPerks('name.color.match'))
                            <label class="border-gray-200 dark:border-gray-700 rounded-bl-md rounded-br-md relative border p-4 flex cursor-pointer">
                                <input type="radio" name="name_color" value="match" wire:model.defer="state.name_color" class="h-4 w-4 mt-0.5 cursor-pointer text-purple-600 border-gray-300 focus:ring-purple-500" aria-labelledby="name-color-setting-2-label" aria-describedby="name-color-setting-2-description">
                                <div class="ml-3 flex flex-col">
                                    <span id="name-color-setting-2-label" class="text-gray-700 dark:text-gray-50 block text-sm font-medium">
                                        Matching player name
                                    </span>
                                    <span id="name-color-setting-2-description" class="text-gray-500 dark:text-gray-300 block text-sm">
                                        Your in-game name will be colored to match your character color.
                                    </span>
                                </div>
                            </label>
                        @endif
                    </div>
                </fieldset>
            </div>
        @endif
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
