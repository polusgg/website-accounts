<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="py-10 px-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="text-2xl flex flex-shrink-0 items-center justify-center">
                        <p>Welcome to your Polus.gg account</p>
                    </div>

                    @if (auth()->user()->is_discord_connected)
                        @if (!auth()->user()->is_in_polus_discord)
                            <div class="mt-6 flex items-center justify-center">
                                <a href="{{ route('discord.join') }}" class="inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-sm font-bold text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-600 focus:outline-none focus:border-green-600 focus:ring focus:ring-green-500 disabled:opacity-25 transition shadow-lg">
                                    {{ __('Join the Polus.gg Discord') }}
                                </a>
                            </div>
                            <div class="mt-6 text-gray-500 text-center">
                                To unlock the full experience of Polus.gg, we highly recommend connecting your Discord account. Connecting your Discord account is a requirement in order to access all of your exclusive in-game perks if you are a Content Creator or a Patreon subscriber. If you are not already supporting Polus.gg and would like to unlock some of these perks, you can subscribe to our <a href="https://patreon.com/polus" target="_blank" class="font-semibold underline hover:text-red-500 focus:text-red-700">Patreon</a>.
                            </div>
                        @endif
                    @else
                        <div class="mt-6 flex items-center justify-center">
                            <a href="{{ route('discord.connect') }}" class="inline-flex items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-sm font-bold text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-600 focus:outline-none focus:border-green-600 focus:ring focus:ring-green-500 disabled:opacity-25 transition shadow-lg">
                                {{ __('Connect your Discord account') }}
                            </a>
                        </div>
                        <div class="mt-6 text-gray-500 text-center">
                            To unlock the full experience of Polus.gg, we highly recommend connecting your Discord account. Connecting your Discord account is a requirement in order to access all of your exclusive in-game perks if you are a Content Creator or a Patreon subscriber. If you are not already supporting Polus.gg and would like to unlock some of these perks, you can subscribe to our <a href="https://patreon.com/polus" target="_blank" class="font-semibold underline hover:text-red-500 focus:text-red-700">Patreon</a>
                        </div>
                    @endif
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('Supporter', 'VIP Donator', 'Elite', 'Legend', 'Impostor'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(252, 165, 165, 1);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942972" target="_blank">Supporter</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('Supporter', 'VIP Donator', 'Elite', 'Legend', 'Impostor'))
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                    You have unlocked the Supporter perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942972" target="_blank">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                          <div>Become a Supporter</div>

                                          <div class="ml-1 text-indigo-500">
                                              <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                          </div>
                                    </div>
                                </a>
                            @endif

                            <ul class="mt-2 text-sm text-gray-500 list-disc list-outside lg:list-inside">
                                <li>Access to VIP channels on Discord</li>
                                <li>Ability to change your nickname on Discord</li>
                                <li>Exclusive content on Patreon and Discord</li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('VIP Donator', 'Elite', 'Legend', 'Impostor'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(248, 113, 113, 1);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942976" target="_blank">VIP Donator</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('VIP Donator', 'Elite', 'Legend', 'Impostor'))
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                    You have unlocked the VIP Donator perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942976" target="_blank">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                            <div>Become a VIP Donator</div>

                                            <div class="ml-1 text-indigo-500">
                                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </div>
                                    </div>
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-gray-500">
                                Everything from <span class="font-bold">Supporter</span> and more:
                            </p>

                            <ul class="mt-2 text-sm text-gray-500 list-disc list-outside lg:list-inside">
                                <li>Ability to post images / GIFs to Discord</li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('Elite', 'Legend', 'Impostor'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(239, 68, 68, 1);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942983" target="_blank">Elite</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('Elite', 'Legend', 'Impostor'))
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                    You have unlocked the Elite perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942983" target="_blank">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                            <div>Become an Elite</div>

                                            <div class="ml-1 text-indigo-500">
                                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </div>
                                    </div>
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-gray-500">
                                Everything from <span class="font-bold">VIP Donator</span> and more:
                            </p>

                            <ul class="mt-2 text-sm text-gray-500 list-disc list-outside lg:list-inside">
                                <li>Gold player name in all Among Us lobbies (can be turned off)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 md:border-l">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('Legend', 'Impostor'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(220, 38, 38, 1);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942984" target="_blank">Legend</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('Legend', 'Impostor'))
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                    You have unlocked the Legend perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942984" target="_blank">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                            <div>Become a Legend</div>

                                            <div class="ml-1 text-indigo-500">
                                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </div>
                                    </div>
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-gray-500">
                                Everything from <span class="font-bold">Elite</span> and more:
                            </p>

                            <ul class="mt-2 text-sm text-gray-500 list-disc list-outside lg:list-inside">
                                <li>Sneak peaks at future ideas and releases</li>
                                <li>Access to a Discord channel with staff members to pitch ideas and concepts</li>
                                <li>Among Us player name matches player color in all lobbies (can be turned off)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200">
                        <div class="flex items-center">
                            @if (auth()->user()->hasAnyDiscordRoles('Impostor'))
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8" style="color: rgba(185, 28, 28);">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                            </svg>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://www.patreon.com/join/polus/checkout?rid=6942986" target="_blank">Impostor</a></div>
                        </div>

                        <div class="ml-12">
                            @if (auth()->user()->hasAnyDiscordRoles('Impostor'))
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                    You have unlocked the Impostor perks!
                                </div>
                            @else
                                <a href="https://www.patreon.com/join/polus/checkout?rid=6942986" target="_blank">
                                    <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                            <div>Become an Impostor</div>

                                            <div class="ml-1 text-indigo-500">
                                                <svg viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </div>
                                    </div>
                                </a>
                            @endif

                            <p class="mt-2 text-sm text-gray-500">
                                Everything from <span class="font-bold">Legend</span> and more:
                            </p>

                            <ul class="mt-2 text-sm text-gray-500 list-disc list-outside lg:list-inside">
                                <li>Voting power on future updates</li>
                                <li>An emote of your choice in our Discord server; it must follow Discord ToS as well as our server rules, and you must provide the emote</li>
                                <li>Custom 4 or 6 letter Among Us lobby codes</li>
                                <li>Exclusive ability to host Among Us lobbies with up to 25 players</li>
                            </ul>
                        </div>
                    </div>

                    @if (auth()->user()->hasAnyDiscordRoles('Creator', 'Creator Manager'))
                        <div class="p-6 border-gray-200 border-t md:border-l">
                            <div class="flex items-center">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-8 h-8 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Content Creator</div>
                            </div>

                            <div class="ml-12">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
                                    You have been granted access to the Content Creator perks!
                                </div>

                                <ul class="mt-2 text-sm text-gray-500 list-disc list-outside lg:list-inside">
                                    <li>Custom 4 or 6 letter Among Us lobby codes</li>
                                    <li>Exclusive ability to host Among Us lobbies with up to 25 players</li>
                                    <li>Access to servers exclusive to Content Creators</li>
                                </ul>
                            </div>

                            <div class="hidden md:flex flex-col mt-3 justify-center items-center text-xs font-bold">
                                <p class="p-2 text-transparent hover:text-gray-400">69</p>
                            </div>
                        </div>
                    @else
                        <div class="hidden md:block border-gray-200 border-t-0 md:border-t border-l-0 md:border-l">
                            <div class="flex flex-col h-full justify-center items-center text-xs font-bold">
                                <p class="p-3 text-transparent hover:text-gray-400">69</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col w-full justify-center mt-10 px-10 text-sm text-center text-gray-400 font-semibold">
                <p>I'm sorry about your eyes&mdash;I was rushed&mdash;but dark mode is coming soon</p>
                <p class="italic">&ndash; codyphobe</p>
            </div>
        </div>
    </div>
</x-app-layout>
