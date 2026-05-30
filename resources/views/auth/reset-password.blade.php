@extends('layouts.auth')

@section('title', 'Buat Kata Sandi Baru - ' . config('app.name', 'KUMAR'))
    <body class="font-sans antialiased">
        @section('content')
            <div class="w-full max-w-md">
                
                <div class="mb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-dark mb-2">Buat Kata Sandi Baru</h1>
                    <p class="text-sm text-gray-600 mt-2">
                        Silakan buat kata sandi baru untuk akun Anda. Pastikan kata sandi baru Anda kuat dan mudah diingat.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                    @csrf

                    <x-auth.auth-input
                        id="password"
                        type="password"
                        name="password"
                        label="Kata Sandi Baru"
                        placeholder="Minimal 8 karakter"
                        required
                        autofocus
                    />

                    <x-auth.auth-input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        label="Konfirmasi Kata Sandi Baru"
                        placeholder="Ketik ulang kata sandi baru"
                        required
                    />

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-secondary hover:bg-secondary-dark shadow-2xs text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02]">
                        Simpan Kata Sandi
                    </button>
                </form>

            </div>
        @endsection
    </body>
