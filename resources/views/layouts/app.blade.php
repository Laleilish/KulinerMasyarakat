<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title') @yield('title') - {{ config('app.name', 'KUMAR') }} @else {{ config('app.name', 'KUMAR') }} @endif</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/img/icon-kumar-logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')

        <style>
            [x-cloak] { display: none !important; }
        </style>
        
        <!-- Lottie Player for Loading Animation -->
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    </head>
    <body class="font-sans antialiased">
        <!-- Global Preloader -->
        <div id="global-loader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-[#FDF8F0] transition-opacity duration-500">
            <lottie-player 
                src="{{ asset('assets/img/Loading/Loading.json') }}" 
                background="transparent" 
                speed="1" 
                style="width: 150px; height: 150px;" 
                loop 
                autoplay>
            </lottie-player>
        </div>

        <div class="min-h-screen bg-cream-bg">
            {{-- Include Navbar  --}}
            @include('components.navbar')

    <main>
        @yield('content')
    </main>

            {{-- Include Footer --}}
            @include('components.footer')
        </div>

        {{-- Toast --}}
        <x-toast />

        {{-- Global Confirmation Modal --}}
        <x-confirm-modal />
        @stack('scripts')

        <script>
            // Hide preloader when page is fully loaded
            window.addEventListener('load', function() {
                const loader = document.getElementById('global-loader');
                if (loader) {
                    loader.style.opacity = '0';
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 500); // match transition duration
                }
            });
        </script>
    </body>
</html>