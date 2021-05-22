<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-purple-500 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="py-10 px-6 sm:px-20 bg-white dark:bg-gray-800 dark:bg-opacity-90 border-b border-gray-200 dark:border-gray-900">
                    <div class="text-xl sm:text-2xl text-center flex flex-shrink-0 items-center justify-center">
                        <p>Welcome to your Polus.gg account</p>
                    </div>

                    @if (auth()->user()->is_discord_connected)
                        @if (!auth()->user()->is_in_polus_discord)
                            <div class="mt-6 flex items-center justify-center">
                                <a href="{{ route('discord.join') }}" class="inline-flex items-center px-4 py-2 bg-purple-700 border border-transparent rounded-md font-semibold text-sm font-bold text-white uppercase tracking-widest hover:bg-purple-800 active:bg-purple-900 focus:outline-none focus:border-purple-600 focus:ring focus:ring-purple-500 disabled:opacity-25 transition shadow-lg">
                                    {{ __('Join the Polus.gg Discord') }}
                                </a>
                            </div>
                            <div class="mt-6 text-gray-500 dark:text-gray-50 text-center">
                                To unlock the full experience of Polus.gg, we highly recommend connecting your Discord account. Connecting your Discord account is a requirement in order to access all of your exclusive in-game perks if you are a Content Creator or a Patreon subscriber. If you are not already supporting Polus.gg and would like to unlock some of these perks, you can subscribe to our <a href="https://patreon.com/polus" target="_blank" rel="noopener" class="font-semibold underline text-purple-400 hover:text-purple-500 focus:text-purple-600">Patreon</a>.
                            </div>
                        @endif
                    @else
                        <div class="mt-6 flex items-center justify-center">
                            <a href="{{ route('discord.connect') }}" class="inline-flex items-center px-4 py-2 bg-purple-700 border border-transparent rounded-md font-semibold text-sm font-bold text-white uppercase tracking-widest hover:bg-purple-800 active:bg-purple-900 focus:outline-none focus:border-purple-600 focus:ring focus:ring-purple-500 disabled:opacity-25 transition shadow-lg">
                                {{ __('Connect your Discord account') }}
                            </a>
                        </div>
                        <div class="mt-6 text-gray-500 dark:text-gray-50 text-center">
                            To unlock the full experience of Polus.gg, we highly recommend connecting your Discord account. Connecting your Discord account is a requirement in order to access all of your exclusive in-game perks if you are a Content Creator or a Patreon subscriber. If you are not already supporting Polus.gg and would like to unlock some of these perks, you can subscribe to our <a href="https://patreon.com/polus" target="_blank" rel="noopener" class="font-semibold underline text-purple-400 hover:text-purple-500 focus:text-purple-600">Patreon</a>
                        </div>
                    @endif
                </div>

                <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 dark:bg-opacity-100 grid grid-cols-1 md:grid-cols-2">
                    {{-- Supporter --}}
                    <div class="p-6">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('Supporter', 'VIP Donator', 'Elite', 'Legend', 'Impostor', 'Jester'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(254, 202, 202, 1);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 dark:text-gray-50 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942972" target="_blank" rel="noopener">Supporter</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('Supporter', 'VIP Donator', 'Elite', 'Legend', 'Impostor', 'Jester'))
                                <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400">
                                    You have unlocked the Supporter perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942972" target="_blank" rel="noopener">
                                    <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300">
                                        <div>Become a Supporter</div>

                                        <div class="ml-1">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            <ul class="mt-2 text-sm text-gray-500 dark:text-gray-50 list-disc list-outside lg:list-inside">
                                <li>Access to VIP channels on Discord</li>
                                <li>Ability to change your nickname on Discord</li>
                            </ul>
                        </div>
                    </div>

                    {{-- VIP Donator --}}
                    <div class="p-6 border-t border-gray-200 dark:border-gray-900 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('VIP Donator', 'Elite', 'Legend', 'Impostor', 'Jester'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(252, 165, 165, 1);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 dark:text-gray-50 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942976" target="_blank" rel="noopener">VIP Donator</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('VIP Donator', 'Elite', 'Legend', 'Impostor', 'Jester'))
                                <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400">
                                    You have unlocked the VIP Donator perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942976" target="_blank" rel="noopener">
                                    <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300">
                                        <div>Become a VIP Donator</div>

                                        <div class="ml-1">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-50">
                                Everything from <span class="font-bold">Supporter</span> and more:
                            </p>

                            <ul class="mt-2 text-sm text-gray-500 dark:text-gray-50 list-disc list-outside lg:list-inside">
                                <li>Ability to post images on Discord</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Elite --}}
                    <div class="p-6 border-t border-gray-200 dark:border-gray-900">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('Elite', 'Legend', 'Impostor', 'Jester'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(248, 113, 113, 1);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 dark:text-gray-50 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942983" target="_blank" rel="noopener">Elite</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('Elite', 'Legend', 'Impostor', 'Jester'))
                                <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400">
                                    You have unlocked the Elite perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942983" target="_blank" rel="noopener">
                                    <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300">
                                        <div>Become an Elite</div>

                                        <div class="ml-1">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-50">
                                Everything from <span class="font-bold">VIP Donator</span> and more:
                            </p>

                            <ul class="mt-2 text-sm text-gray-500 dark:text-gray-50 list-disc list-outside lg:list-inside">
                                <li>Among Us player name is colored gold (can be turned off)</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Legend --}}
                    <div class="p-6 border-t border-gray-200 dark:border-gray-900 md:border-l">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('Legend', 'Impostor', 'Jester'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(239, 68, 68, 1);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 dark:text-gray-50 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942984" target="_blank" rel="noopener">Legend</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('Legend', 'Impostor', 'Jester'))
                                <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400">
                                    You have unlocked the Legend perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942984" target="_blank" rel="noopener">
                                    <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300">
                                        <div>Become a Legend</div>

                                        <div class="ml-1">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-50">
                                Everything from <span class="font-bold">Elite</span> and more:
                            </p>

                            <ul class="mt-2 text-sm text-gray-500 dark:text-gray-50 list-disc list-outside lg:list-inside">
                                <li>Ability to host Among Us lobbies with up to 25 players</li>
                                <li>Among Us player name color matches your player color (can be turned off)</li>
                                <li>Access to a Discord channel with staff members to pitch ideas</li>
                                <li>Sneak peeks at future ideas and releases</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Impostor --}}
                    <div class="p-6 border-t border-gray-200 dark:border-gray-900">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('Impostor', 'Jester'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(220, 38, 38, 1);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 dark:text-gray-50 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942986" target="_blank" rel="noopener">Impostor</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('Impostor', 'Jester'))
                                <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400">
                                    You have unlocked the Impostor perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942986" target="_blank" rel="noopener">
                                    <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300">
                                        <div>Become an Impostor</div>

                                        <div class="ml-1">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-50">
                                Everything from <span class="font-bold">Legend</span> and more:
                            </p>

                            <ul class="mt-2 text-sm text-gray-500 dark:text-gray-50 list-disc list-outside lg:list-inside">
                                <li>Ability to host Among Us lobbies with up to 50 players</li>
                                <li>Custom 4 or 6 letter Among Us lobby codes</li>
                                <li>Custom Among Us player color using an RGB color picker</li>
                                <li>Voting power on future updates</li>
                                <li>An emote of your choice in our Discord server (it must follow Discord ToS as well as our server rules, and you must provide the emote)</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Jester --}}
                    <div class="p-6 border-t border-gray-200 dark:border-gray-900 md:border-l">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('Jester'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(185, 28, 28);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 dark:text-gray-50 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=7087067" target="_blank" rel="noopener">Jester</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('Jester'))
                                <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400">
                                    You have unlocked the Jester perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=7087067" target="_blank" rel="noopener">
                                    <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300">
                                        <div>Become a Jester</div>

                                        <div class="ml-1">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-50">
                                Everything from <span class="font-bold">Impostor</span> and more:
                            </p>

                            <ul class="mt-2 text-sm text-gray-500 dark:text-gray-50 list-disc list-outside lg:list-inside">
                                <li>Ability to host Among Us lobbies with up to 100 players</li>
                                <li>A role of your choice gets implemented into Town of Polus (it must be approved by us)</li>
                                <li>Your name in the Polus.gg credits screen</li>
                            </ul>
                        </div>
                    </div>

                    {{-- Creator --}}
                    @if (auth()->user()->hasAnyDiscordRoles('Creator', 'Creator Manager'))
                        <div class="p-6 border-t border-gray-200 dark:border-gray-900">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="ml-4 text-lg text-gray-600 dark:text-gray-50 leading-7 font-semibold">Content Creator</div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-3 inline-flex items-center text-sm font-semibold text-purple-600 dark:text-purple-400">
                                    You have been granted access to the Content Creator perks!
                                </div>

                                <ul class="mt-2 text-sm text-gray-500 dark:text-gray-50 list-disc list-outside lg:list-inside">
                                    <li>Custom 4 or 6 letter Among Us lobby codes</li>
                                    <li>Exclusive ability to host Among Us lobbies with up to 25 players</li>
                                    <li>Access to servers exclusive to Content Creators</li>
                                </ul>
                            </div>
                        </div>

                        <div class="hidden md:block p-6 border-t border-gray-200 dark:border-gray-900 md:border-l">
                            <div class="flex flex-col h-full justify-center items-center text-xs font-bold">
                                <p class="p-3 text-transparent hover:text-gray-400 transition cursor-default select-none">69</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
