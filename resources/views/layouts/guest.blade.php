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
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .bg-overlay {
                background-image: url('/images/guest-bg.jpg'); /* Optional custom background */
                background-size: cover;
                background-position: center;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12 bg-overlay bg-gray-50 dark:bg-gray-900">
            <!-- Logo -->
            <div class="mb-6">
                <a href="/" class="flex items-center space-x-2">
                    <x-application-logo class="w-16 h-16 text-gray-700 dark:text-gray-300" />
                    <span class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ config('app.name', 'Recipe Guru') }}</span>
                </a>
            </div>

            <!-- Auth Box -->
            <div class="w-full sm:max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-8">
                {{ $slot }}
            </div>

            <!-- Footer (optional) -->
            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                © {{ now()->year }} Recipe Guru. All rights reserved.
            </div>
        </div>
    </body>
</html>
