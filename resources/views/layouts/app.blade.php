<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="title" content="{{ config('app.name', 'Laravel') }}">
        <meta name="description" content="Play with your friends on the world's best modded Among Us server!">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://polus.gg/">
        <meta property="og:title" content="{{ config('app.name', 'Laravel') }}">
        <meta property="og:description" content="Play with your friends on the world's best modded Among Us server!">
        <meta property="og:image" content="https://static.polus.gg/images/banners/banner_plain.png">
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="https://polus.gg/">
        <meta property="twitter:title" content="{{ config('app.name', 'Laravel') }}">
        <meta property="twitter:description" content="Play with your friends on the world's best modded Among Us server!">
        <meta property="twitter:image" content="https://static.polus.gg/images/banners/banner_plain.png">

        <link rel="icon" href="https://static.polus.gg/images/logos/polus/favicon.ico">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
