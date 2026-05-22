@extends('layouts.app')

@section('title', 'Profil - ' . config('app.name', 'KUMAR'))

@section('content')
<div class="min-h-screen bg-cream-bg py-8 px-4 max-w-lg mx-auto">

    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('home') }}" class="text-dark hover:text-muted transition-colors no-underline">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h1 class="text-xl font-bold text-dark">Profil</h1>
    </div>

    <!-- Avatar & Name -->
    <div class="flex flex-col items-center mb-6">
        <div class="relative mb-3">
            @if($user->avatar)
                <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                     class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-card">
            @else
                <div class="w-24 h-24 rounded-full bg-secondary flex items-center justify-center border-4 border-white shadow-card">
                    <span class="text-white text-2xl font-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                </div>
            @endif

            {{-- Edit Avatar Button --}}
            <a href="{{ route('profile.edit') }}"
               class="absolute bottom-0 right-0 w-8 h-8 bg-secondary rounded-full flex items-center justify-center shadow-md no-underline hover:bg-secondary-dark transition-colors">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </a>
        </div>

        <h2 class="text-2xl font-bold text-dark">{{ $user->name }}</h2>
        <p class="text-muted text-sm">{{ $user->email }}</p>
    </div>

    {{-- Success Message --}}
    @if(session('status') === 'profile-updated')
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 text-sm rounded-xl text-center">
            Profil berhasil diperbarui!
        </div>
    @endif

    <!-- Info Card -->
    <div class="bg-white rounded-2xl shadow-card mb-6 overflow-hidden">
        {{-- Nama Lengkap --}}
        <a href="{{ route('profile.edit') }}#name" class="flex items-center justify-between px-5 py-4 border-b border-gray-100 no-underline hover:bg-gray-50 transition-colors">
            <div>
                <p class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Nama Lengkap</p>
                <p class="text-dark font-medium">{{ $user->name }}</p>
            </div>
            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
        </a>

        {{-- Username --}}
        <a href="{{ route('profile.edit') }}#username" class="flex items-center justify-between px-5 py-4 border-b border-gray-100 no-underline hover:bg-gray-50 transition-colors">
            <div>
                <p class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Username</p>
                <p class="text-dark font-medium">@{{ $user->username }}</p>
            </div>
            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
        </a>

        {{-- Email --}}
        <a href="{{ route('profile.edit') }}#email" class="flex items-center justify-between px-5 py-4 no-underline hover:bg-gray-50 transition-colors">
            <div>
                <p class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Email</p>
                <p class="text-dark font-medium">{{ $user->email }}</p>
            </div>
            <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
        </a>
    </div>

    <!-- Keamanan Akun -->
    <p class="text-xs font-bold text-muted uppercase tracking-wider mb-3 px-1">Keamanan Akun</p>
    <div class="bg-white rounded-2xl shadow-card mb-6 overflow-hidden">
        {{-- Ubah Email --}}
        <a href="{{ route('profile.edit') }}#email" class="flex items-center justify-between px-5 py-4 border-b border-gray-100 no-underline hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="text-dark font-medium">Ubah Email</span>
            </div>
            <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        {{-- Ubah Password --}}
        <a href="{{ route('profile.edit') }}#password" class="flex items-center justify-between px-5 py-4 no-underline hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <span class="text-dark font-medium">Ubah Password</span>
            </div>
            <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    <!-- Lainnya -->
    <p class="text-xs font-bold text-muted uppercase tracking-wider mb-3 px-1">Lainnya</p>
    <div class="bg-white rounded-2xl shadow-card overflow-hidden">
        {{-- Hapus Akun --}}
        <button
            onclick="document.getElementById('deleteModal').classList.remove('hidden')"
            class="w-full flex items-center gap-3 px-5 py-4 text-red-500 hover:bg-red-50 transition-colors bg-transparent border-none cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span class="font-medium">Hapus Akun</span>
        </button>
    </div>
</div>

{{-- Delete Account Modal --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-card">
        <h3 class="text-lg font-bold text-dark mb-2">Hapus Akun?</h3>
        <p class="text-sm text-muted mb-6">
            Setelah akun dihapus, semua data akan hilang permanen. Masukkan password untuk konfirmasi.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-4">
                <label for="del_password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input
                    id="del_password"
                    type="password"
                    name="password"
                    placeholder="Masukkan password Anda"
                    required
                    class="w-full px-4 py-3 rounded-xl border-2 border-muted-light bg-white focus:border-red-400 focus:ring-0 text-dark placeholder:text-gray-400 transition-all"
                />
                @if($errors->userDeletion->get('password'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="flex gap-3">
                <button
                    type="button"
                    onclick="document.getElementById('deleteModal').classList.add('hidden')"
                    class="flex-1 py-3 rounded-xl border-2 border-gray-200 text-dark font-semibold hover:bg-gray-50 transition-colors bg-transparent cursor-pointer">
                    Batal
                </button>
                <button
                    type="submit"
                    class="flex-1 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition-colors border-none cursor-pointer">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.getElementById('deleteModal').classList.remove('hidden');
</script>
@endif
@endsection
