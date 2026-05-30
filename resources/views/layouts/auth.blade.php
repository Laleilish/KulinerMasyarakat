<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-dark antialiased">
        @include('components.auth.auth-navbar')
        <main class="min-h-[calc(100vh-64px)] flex items-center justify-center bg-cream-bg py-8 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </main>
        @include('components.auth.auth-footer')

        {{-- Toast --}}
        <x-toast />
    </body>

</html>
