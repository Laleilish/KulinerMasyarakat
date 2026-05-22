@extends('layouts.app')

@section('title', 'Edit Profil - ' . config('app.name', 'KUMAR'))

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-dark">Edit Profil</h1>
            <p class="text-muted mt-2">Perbarui informasi profil Anda</p>
        </div>

        <!-- Edit Form -->
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Avatar Upload Card -->
            <div class="bg-white rounded-xl shadow-2xs p-6">
                <h2 class="text-lg font-bold text-dark mb-4">Foto Profil</h2>

                <div class="flex flex-col md:flex-row items-center gap-6">
                    <!-- Current Avatar Preview -->
                    <div class="relative">
                        <div id="avatar-preview-container">
                            @if($user->avatar)
                                @if($user->provider)
                                    <!-- OAuth Avatar -->
                                    <img id="avatar-preview"
                                         src="{{ $user->avatar }}"
                                         alt="{{ $user->name }}"
                                         class="w-32 h-32 rounded-full border-4 border-gray-200 shadow-lg object-cover">
                                @else
                                    <!-- Uploaded Avatar -->
                                    <img id="avatar-preview"
                                         src="{{ $user->avatar }}"
                                         alt="{{ $user->name }}"
                                         class="w-32 h-32 rounded-full border-4 border-gray-200 shadow-lg object-cover">
                                @endif
                            @else
                                <!-- Default Avatar -->
                                <div id="avatar-preview" class="w-32 h-32 rounded-full border-4 border-gray-200 shadow-lg bg-gray-100 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        @if($user->provider)
                            <div class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg">
                                @if($user->provider === 'google')
                                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                @elseif($user->provider === 'facebook')
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Upload Input -->
                    <div class="flex-1 w-full">
                        <label for="avatar" class="block text-sm font-medium text-dark mb-2">
                            Pilih Foto Baru
                        </label>
                        <input type="file"
                               id="avatar"
                               name="avatar"
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-white hover:file:bg-secondary-dark cursor-pointer">

                        @error('avatar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <p class="mt-2 text-xs text-muted">
                            JPG, PNG, atau GIF. Maksimal 2MB.
                            @if($user->provider)
                                <br><span class="text-orange-600 font-medium">Note: Mengganti foto akan menimpa foto dari {{ ucfirst($user->provider) }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="bg-white rounded-xl shadow-2xs p-6">
                <h2 class="text-lg font-bold text-dark mb-4">Informasi Profil</h2>

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-dark mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary focus:border-transparent transition-all">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-dark mb-2">
                            Username
                        </label>
                        <input type="text"
                               id="username"
                               name="username"
                               value="{{ old('username', $user->username) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary focus:border-transparent transition-all">
                        @error('username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-muted">Hanya huruf, angka, underscore (_), dan dash (-)</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-dark mb-2">
                            Email
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-secondary focus:border-transparent transition-all">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($user->email_verified_at)
                            <p class="mt-1 text-xs text-green-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Email terverifikasi
                            </p>
                        @else
                            <p class="mt-1 text-xs text-orange-600">Email belum terverifikasi. Ubah email akan memerlukan verifikasi ulang.</p>
                        @endif
                    </div>

                    <!-- Provider Info (Read-only) -->
                    @if($user->provider)
                        <div>
                            <label class="block text-sm font-medium text-dark mb-2">
                                Login Method
                            </label>
                            <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-600">
                                Login via {{ ucfirst($user->provider) }} OAuth
                            </div>
                        </div>
                    @endif

                    <!-- Role (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-dark mb-2">
                            Role
                        </label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <span class="inline-flex items-center gap-2">
                                @if($user->role === 'admin')
                                    <span class="text-red-600 font-semibold">👑 Admin</span>
                                @elseif($user->role === 'owner')
                                    <span class="text-blue font-semibold">🏪 Owner</span>
                                @else
                                    <span class="text-gray-600 font-semibold">👤 Customer</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit"
                        class="flex-1 bg-secondary hover:bg-secondary-dark text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg hover:shadow-xl hover:scale-[1.02]">
                    Simpan Perubahan
                </button>

                <a href="{{ route('profile.show') }}"
                   class="flex-1 bg-white hover:bg-gray-50 text-dark font-bold py-3 px-6 rounded-xl text-center transition-all shadow-2xs border border-gray-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Avatar Preview -->
<script>
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');

            // If it's a div (default avatar), replace with img
            if (preview.tagName === 'DIV') {
                const newImg = document.createElement('img');
                newImg.id = 'avatar-preview';
                newImg.className = 'w-32 h-32 rounded-full border-4 border-gray-200 shadow-lg object-cover';
                newImg.src = e.target.result;
                newImg.alt = 'Preview';
                preview.parentNode.replaceChild(newImg, preview);
            } else {
                // Just update the src if it's already an img
                preview.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
