<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@hasSection('title') @yield('title') - {{ config('app.name', 'KUMAR') }} @else {{ config('app.name', 'KUMAR') }} @endif</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/img/icon-kumar-logo.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-dark antialiased">
        <x-loader />
        @include('components.auth.auth-navbar')
        <main class="min-h-[calc(100vh-64px)] min-h-[calc(100dvh-64px)] flex flex-col items-center justify-start pt-12 md:justify-center md:pt-8 pb-8 px-4 sm:px-6 lg:px-8 bg-cream-bg">
            @yield('content')
        </main>
        @include('components.auth.auth-footer')

        {{-- Toast --}}
        <x-toast />
    </body>

</html>
