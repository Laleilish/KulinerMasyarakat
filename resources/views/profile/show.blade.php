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

            {{-- Edit Avatar  --}}
            <form id="avatarForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="hidden">
                @csrf
                @method('patch')
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="username" value="{{ $user->username }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden">
            </form>

            <button type="button" onclick="document.getElementById('avatarInput').click()"
               class="absolute bottom-0 right-0 w-8 h-8 bg-secondary rounded-full flex items-center justify-center shadow-md hover:bg-secondary-dark transition-colors border-none cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </button>
        </div>

        <h2 class="text-2xl font-bold text-dark">{{ $user->name }}</h2>
        <p class="text-muted text-sm">{{ $user->email }}</p>
    </div>

    {{-- Status Messages --}}
    @if(session('status') === 'profile-updated')
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 text-sm rounded-xl text-center">
            Profil berhasil diperbarui!
        </div>
    @endif
    @if(session('status') === 'password-updated')
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 text-sm rounded-xl text-center">
            Password berhasil diperbarui!
        </div>
    @endif

    <!-- Info Card -->
    <div class="flex items-center justify-between py-3 ">
        <p class="text-xs font-bold text-muted tracking-wider px-1 ">Informasi Profil</p>
        <button onclick="openModal('profileModal')"
                class="flex items-center gap-1 text-xs font-semibold text-secondary hover:text-secondary-dark transition-colors bg-transparent border-none cursor-pointer px-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Edit
        </button>
    </div>
    <div class="bg-white rounded-2xl shadow-card mb-6 overflow-hidden">

        {{-- Nama Lengkap --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <p class="text-xs font-bold text-dark  tracking-wider mb-1">Nama Lengkap</p>
                <p class="text-muted  font-medium">{{ $user->name }}</p>
            </div>
        </div>

        {{-- Username --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <p class="text-xs font-bold text-dark tracking-wider mb-1">Username</p>
                <p class="text-muted font-medium">{{ $user->username }}</p>
            </div>
        </div>

        {{-- Email --}}
        <div class="flex items-center justify-between px-5 py-4">
            <div>
                <p class="text-xs font-bold text-dark  tracking-wider mb-1">Email</p>
                <p class="text-muted font-medium">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <!-- Keamanan Akun -->
    <p class="text-xs font-bold text-muted tracking-wider mb-3 px-1">Keamanan Akun</p>
    <div class="bg-white rounded-2xl shadow-card mb-6 overflow-hidden">
        <button onclick="openModal('emailModal')"
                class="w-full flex items-center justify-between px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition-colors bg-transparent border-none cursor-pointer text-left">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="text-dark font-medium">Ubah Email</span>
            </div>
            <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <button onclick="openModal('passwordModal')"
                class="w-full flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors bg-transparent border-none cursor-pointer text-left">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <span class="text-dark font-medium">Ubah Password</span>
            </div>
            <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    <!-- Lainnya -->
    <p class="text-xs font-bold text-muted tracking-wider mb-3 px-1">Lainnya</p>
    <div class="bg-white rounded-2xl shadow-card overflow-hidden">
        <button onclick="openModal('deleteModal')"
                class="w-full flex items-center gap-3 px-5 py-4 text-red-500 hover:bg-red-50 transition-colors bg-transparent border-none cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span class="font-medium">Hapus Akun</span>
        </button>
    </div>
</div>

@include('profile.partials.edit-profile-modal')

@include('profile.partials.update-email-modal')

@include('profile.partials.update-password-modal')

@include('profile.partials.delete-user-modal')

@include('profile.partials.crop-image-modal')

<!-- Cropper.js CSS & JS CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close
    document.querySelectorAll('[id$="Modal"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    // Cropper instance & elements
    let cropper = null;
    const avatarInput = document.getElementById('avatarInput');
    const avatarForm = document.getElementById('avatarForm');
    const cropperImage = document.getElementById('cropperImage');
    const cropSaveBtn = document.getElementById('cropSaveBtn');

    // Intercept file selection to open cropper
    avatarInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                cropperImage.src = e.target.result;
                openModal('cropModal');

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(cropperImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                });
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle cropping on save
    cropSaveBtn.addEventListener('click', function() {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        canvas.toBlob(function(blob) {
            if (blob) {
                const dataTransfer = new DataTransfer();
                const croppedFile = new File([blob], 'avatar.jpg', { type: 'image/jpeg' });
                dataTransfer.items.add(croppedFile);
                
                avatarInput.files = dataTransfer.files;

                closeModal('cropModal');
                avatarForm.submit();
            }
        }, 'image/jpeg', 0.9);
    });

    // Auto-open modal jika ada validation error
    @if($errors->has('name') || $errors->has('username'))
        openModal('profileModal');
    @elseif($errors->has('email'))
        openModal('emailModal');
    @endif

    @if($errors->updatePassword->any())
        openModal('passwordModal');
    @endif

    @if($errors->userDeletion->isNotEmpty())
        openModal('deleteModal');
    @endif
</script>


@endsection
