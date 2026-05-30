@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi - ' . config('app.name', 'KUMAR'))
    <body class="font-sans antialiased">
        @section('content')
            <div class="w-full max-w-md">
                
                <div class="mb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-dark mb-2">Lupa Kata Sandi?</h1>
                    <p class="text-sm text-gray-600 mt-2">
                        Jangan khawatir! Masukkan username atau email Anda, dan kami akan mengirimkan kode OTP untuk mengatur ulang kata sandi Anda.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth.auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <x-auth.auth-input
                        id="login"
                        type="text"
                        name="login"
                        label="Username atau Email"
                        placeholder="Masukkan username atau email Anda"
                        required
                        autofocus
                    />

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-secondary hover:bg-secondary-dark shadow-2xs text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02]">
                        Kirim OTP
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-blue hover:text-orange-600 font-semibold">
                        &larr; Kembali ke halaman Masuk
                    </a>
                </div>
            </div>
        @endsection
    </body>
