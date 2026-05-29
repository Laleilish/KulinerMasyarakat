<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-cream-bg">
            <main class="py-12">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{-- Logo --}}
                    <div class="flex justify-center mb-8">
                        <a href="{{ route('home') }}" class="no-underline transition-transform hover:scale-105">
                            <img src="{{ asset('assets/img/icon-kumar.png') }}" alt="KUMAR" class="h-16">
                        </a>
                    </div>
                    
                    @yield('content')
                </div>
            </main>
        </div>

        {{-- Toast --}}
        <x-toast />
    </body>
</html>
