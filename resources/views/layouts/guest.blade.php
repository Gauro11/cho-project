<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CHO') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('image/dag_logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased flex flex-col items-center min-h-screen justify-center">
            
            <!-- 🔹 Logo -->
            <div class="mb-6">
                <img src="{{ asset('image/dag_logo.png') }}" alt="CHO Logo" class="w-24 h-24 rounded-full shadow">
            </div>

            <!-- Page Content -->
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
