<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Auth Navbar -->
    <header class="flex justify-between items-center px-4 md:px-10 py-3 bg-cream-bg shadow-navbar sticky top-0 z-50">
        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
            <img src="{{ asset('assets/img/icon-kumar.png') }}" alt="KUMAR" class="h-10">
        </a>
        
        <div class="flex items-center gap-2 font-semibold text-muted cursor-pointer">
            <span class="text-dark">ID</span>
            <span>|</span>
            <span>EN</span>
        </div>
    </header>

    <div class="min-h-[calc(100vh-64px)] flex items-center justify-center bg-cream-bg py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-dark mb-2 flex start">Masuk Dengan Aman</h1>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                        Username
                    </label>
                    <input
                        id="username"
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username Anda"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-500 transition-all"
                    />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Masukkan password Anda"
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-500 transition-all"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 text-orange-500 bg-white/70 backdrop-blur-sm rounde"
                    />
                    <label for="remember_me" class="ml-2 text-sm text-gray-700">
                        Ingat saya di perangkat ini selama 60 hari
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-secondary hover:bg-secondary-dark shadow-2xs text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02]">
                    Lanjutkan
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-muted"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-cream-bg px-4 text-muted">atau</span>
                    </div>
                </div>

                <!-- Social Login Buttons -->
                <div class="space-y-3">
                    <!-- Google -->
                    <button
                        type="button"
                        class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white/70 backdrop-blur-sm shadow-2xs rounded-xl hover:bg-white hover:border-orange-300 transition-all"
                    >
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="font-medium text-dark">Lanjutkan dengan Google</span>
                    </button>

                    <!-- Facebook -->
                    <button
                        type="button"
                        class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-blue hover:bg-[#166fe5] text-white shadow-2xs rounded-xl transition-all shadow-md hover:shadow-lg"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="font-medium">Lanjutkan dengan Facebook</span>
                    </button>
                </div>
            </form>

            <!-- Footer Links -->
            <div class="mt-8 text-center space-y-3">
                <div class="text-sm text-gray-700">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue hover:text-orange-600 font-semibold">
                        Daftar di sini
                    </a>
                </div>
                
                <div class="flex items-center justify-center gap-4 text-sm">
                    <a href="#" class="text-gray-600 hover:text-gray-800">
                        Kebijakan Privasi
                    </a>
                    <span class="text-gray-400">•</span>
                    <a href="#" class="text-gray-600 hover:text-gray-800">
                        Syarat dan ketentuan
                    </a>
                </div>

                <div class="text-sm text-gray-600">
                    Butuh bantuan?
                    <a href="#" class="text-blue hover:text-orange-600 font-medium">
                        Pusat Bantuan
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
