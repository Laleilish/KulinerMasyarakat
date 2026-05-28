<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Panel - {{ config('app.name', 'KUMAR') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
            ::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-800 bg-cream-light" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex overflow-hidden">
            
            <!-- Sidebar Overlay -->
            <div x-show="sidebarOpen" 
                 x-transition.opacity
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black/40 z-40 lg:hidden" 
                 x-cloak></div>

            <!-- Sidebar -->
            @include('admin.partials.sidebar')

            <!-- Main Content Container -->
            <div class="flex-1 flex flex-col min-w-0 bg-cream-light relative"> 
                
                <!-- Top Navbar -->
                @include('admin.partials.topbar')

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto px-6 py-8 lg:px-8">
                    @yield('content')
                </main>
            </div>
        </div>

        <!-- Global Toast Component -->
        <x-toast />
    </body>
</html>
