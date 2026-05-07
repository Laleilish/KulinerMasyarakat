@extends('layouts.auth')


@section('title', 'register - ' . config('app.name', 'KUMAR'))
    <body class="font-sans antialiased">
            @section('content')
                <div class="w-full max-w-md">
                    <!-- Header -->
                    
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold text-dark mb-2 flex start">Buat Akun Secara Gratis</h1>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf
                        {{-- Name --}}
                        <x-auth.auth-input
                            id="name"
                            type="text"
                            name="name"
                            label="Nama"
                            placeholder="Masukan Nama Anda"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        {{-- Usernmae --}}
                        <x-auth.auth-input
                            id="username"
                            type="text"
                            name="username"
                            label="Username"
                            placeholder="Masukan username Anda"
                            required
                            autocomplete="username"
                        />

                        {{-- Email --}}
                        <x-auth.auth-input
                            id="email"
                            type="email"
                            name="username"
                            label="Email"
                            placeholder="Masukkan alamat email Anda"
                            required
                            autocomplete="email"
                        />

                        <x-auth.auth-input
                            id="password"
                            type="password"
                            name="password"
                            label="Password"
                            placeholder="Minimal 8 karakter"
                            required
                            autocomplete="new-password"
                        />

                        <x-auth.auth-input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            label="Password"
                            placeholder="Ketik ulang password Anda"
                            required
                            autocomplete="new-password"
                        />

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
            @endsection
        </div>
    </body>
