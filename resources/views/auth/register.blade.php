<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'Laravel') }}</title>
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
                <h1 class="text-4xl font-bold text-dark mb-2 flex start">Buat Akun Secara Gratis</h1>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap Anda"
                        required
                        autofocus
                        autocomplete="name"
                        class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-500 transition-all"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

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
                        placeholder="Pilih username unik Anda"
                        required
                        autocomplete="username"
                        class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-500 transition-all"
                    />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan alamat email Anda"
                        required
                        autocomplete="email"
                        class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-500 transition-all"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
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
                        placeholder="Minimal 8 karakter"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-500 transition-all"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Ketik ulang password Anda"
                        required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-500 transition-all"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <input
                        id="terms"
                        type="checkbox"
                        name="terms"
                        required
                        class="w-4 h-4 mt-1 text-orange-500 bg-white/70 backdrop-blur-sm rounde"
                    />
                    <label for="terms" class="ml-2 text-sm text-gray-700">
                        Saya setuju dengan
                        <a href="#" class="text-blue hover:text-orange-600 font-semibold">Syarat dan Ketentuan</a>
                        serta
                        <a href="#" class="text-blue hover:text-orange-600 font-semibold">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-secondary hover:bg-secondary-dark shadow-2xs text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02]"
                >
                    Daftar Sekarang
                </button>


            <!-- Footer Links -->
            <div class="mt-8 text-center space-y-3">
                <div class="text-sm text-gray-700">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue hover:text-orange-600 font-semibold">
                        Masuk di sini
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
