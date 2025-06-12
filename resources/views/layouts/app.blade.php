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

        <!-- Tom Select Styles -->
        @stack('styles')

        <style>
            /* Sticky top nav */
            .sticky-nav {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 50;
                background-color: white;
                border-bottom: 1px solid #e5e7eb; /* Tailwind's gray-200 */
            }

            .page-container {
                display: flex;
                margin-top: 70px; /* offset sticky navbar height */
                padding: 1rem;
            }

            .sidebar {
                position: sticky;
                top: 90px;
                width: 250px;
                height: fit-content;
                padding: 1rem;
                background-color: #f9fafb; /* Tailwind gray-50 */
                border-left: 1px solid #e5e7eb;
                flex-shrink: 0;
            }

            .main-content {
                flex: 1;
                padding-right: 2rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-white text-black">
        <div class="min-h-screen">
            <!-- Sticky Navigation -->
            <div class="sticky-nav">
                @include('layouts.navigation')
            </div>

            <!-- Optional Page Header -->
            @isset($header)
                <header class="bg-white shadow mt-[70px]">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content: Sidebar + Main -->
            <main class="page-container">
                {{ $slot }}
            </main>
        </div>

        <!-- Tom Select Scripts -->
        @stack('scripts')
    </body>
</html>
