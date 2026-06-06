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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased">
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

        @auth
            <script>
                document.addEventListener('alpine:init', () => {
                    const unreadNotifs = @json(auth()->user()->unreadNotifications->take(3)->map(function($n) {
                        return ['id' => $n->id, 'message' => $n->data['message'] ?? 'Ada notifikasi baru'];
                    }));
                    
                    if (unreadNotifs.length > 0) {
                        // Wait a bit to ensure Alpine store is initialized and user is not bombarded instantly
                        setTimeout(() => {
                            const store = Alpine.store('notif');
                            if (store && store.canSend()) {
                                let notified = JSON.parse(localStorage.getItem('kumar_notified_ids') || '[]');
                                let hasNew = false;
                                
                                unreadNotifs.forEach(n => {
                                    if (!notified.includes(n.id)) {
                                        new Notification('KUMAR', {
                                            body: n.message,
                                            icon: '/assets/img/icon-kumar.png',
                                        });
                                        notified.push(n.id);
                                        hasNew = true;
                                    }
                                });
                                
                                if (hasNew) {
                                    // Keep array size manageable
                                    if (notified.length > 50) notified = notified.slice(-50);
                                    localStorage.setItem('kumar_notified_ids', JSON.stringify(notified));
                                }
                            }
                        }, 1500);
                    }
                });
            </script>
        @endauth

        @stack('scripts')
    </body>
</html>