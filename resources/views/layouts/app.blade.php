<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <wireui:scripts />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex flex-col min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-white">
            <livewire:layouts.navigation />

            <main {{ $attributes->merge(['class' => 'w-full flex-1 mx-auto max-w-3xl px-5 mb-8']) }}>
                {{ $slot }}
            </main>

            <x-notifications />
        </div>
    </body>
</html>
