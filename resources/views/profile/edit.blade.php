@extends('layouts.app')

@section('title', 'Edit Profil - ' . config('app.name', 'KUMAR'))

@section('content')
<div class="min-h-screen bg-cream-bg py-8 px-4 max-w-lg mx-auto">

    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('profile.show') }}" class="text-dark hover:text-muted transition-colors no-underline">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-xl font-bold text-dark">Edit Profil</h1>
    </div>

    {{-- Update Profile Info --}}
    <div id="name" class="bg-white rounded-2xl shadow-card p-5 mb-4">
        <h2 class="text-sm font-bold text-muted uppercase tracking-wider mb-4">Informasi Profil</h2>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            {{-- Nama Lengkap --}}
            <div>
                <label for="name" class="block text-xs font-bold text-muted uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    autocomplete="name"
                    class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark placeholder:text-gray-400 transition-all"
                />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Username --}}
            <div id="username">
                <label for="username" class="block text-xs font-bold text-muted uppercase tracking-wider mb-2">Username</label>
                <input
                    id="username"
                    type="text"
                    name="username"
                    value="{{ old('username', $user->username) }}"
                    required
                    autocomplete="username"
                    class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark placeholder:text-gray-400 transition-all"
                />
                @error('username')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div id="email">
                <label for="email" class="block text-xs font-bold text-muted uppercase tracking-wider mb-2">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="email"
                    class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark placeholder:text-gray-400 transition-all"
                />
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-600 font-medium">Profil berhasil diperbarui!</p>
            @endif

            <button type="submit"
                    class="w-full bg-secondary hover:bg-secondary-dark text-white font-bold py-3 rounded-xl transition-all border-none cursor-pointer">
                Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- Update Password --}}
    <div id="password" class="bg-white rounded-2xl shadow-card p-5 mb-4">
        <h2 class="text-sm font-bold text-muted uppercase tracking-wider mb-4">Ubah Password</h2>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')

            <div>
                <label for="current_password" class="block text-xs font-bold text-muted uppercase tracking-wider mb-2">Password Saat Ini</label>
                <input
                    id="current_password"
                    type="password"
                    name="current_password"
                    autocomplete="current-password"
                    class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark placeholder:text-gray-400 transition-all"
                />
                @error('current_password', 'updatePassword')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="new_password" class="block text-xs font-bold text-muted uppercase tracking-wider mb-2">Password Baru</label>
                <input
                    id="new_password"
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark placeholder:text-gray-400 transition-all"
                />
                @error('password', 'updatePassword')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-muted uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark placeholder:text-gray-400 transition-all"
                />
                @error('password_confirmation', 'updatePassword')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600 font-medium">Password berhasil diperbarui!</p>
            @endif

            <button type="submit"
                    class="w-full bg-secondary hover:bg-secondary-dark text-white font-bold py-3 rounded-xl transition-all border-none cursor-pointer">
                Ubah Password
            </button>
        </form>
    </div>

</div>
@endsection
