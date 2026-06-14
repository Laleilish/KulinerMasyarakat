{{-- Edit Profil --}}
<div id="profileModal" class="hidden fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center z-50 px-4 pb-4 sm:pb-0">
    <div class="bg-white rounded-2xl w-full max-w-sm shadow-card">
        <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-dark">Edit Profil</h3>
            <button onclick="closeModal('profileModal')" class="text-muted hover:text-dark bg-transparent border-none cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="p-5 space-y-4">
            @csrf
            @method('patch')
            <input type="hidden" name="email" value="{{ $user->email }}">

            <div x-data="{ name: '{{ old('name', $user->name) }}' }">
                <label class="block text-xs font-bold text-dark tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" name="name" x-model="name" required maxlength="50" minlength="2"
                       class="w-full px-4 py-3 rounded-xl border-2 border-muted-light focus:border-secondary focus:ring-0 text-dark transition-all @error('name') border-red-400 @enderror"/>
                <p x-show="name.length > 0 && name.length < 2" class="text-amber-500 text-xs mt-1">Minimal 2 karakter</p>
                <p x-show="name.length >= 50" class="text-red-500 text-xs mt-1 font-semibold">Maksimal karakter tercapai</p>
                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div x-data="{ username: '{{ old('username', $user->username) }}' }">
                <label class="block text-xs font-bold text-dark tracking-wider mb-2">Username</label>
                <input type="text" name="username" x-model="username" required maxlength="30" minlength="3"
                       class="w-full px-4 py-3 rounded-xl border-2 border-muted-light focus:border-secondary focus:ring-0 text-dark transition-all @error('username') border-red-400 @enderror"/>
                <p x-show="username.length > 0 && username.length < 3" class="text-amber-500 text-xs mt-1">Minimal 3 karakter</p>
                <p x-show="username.length >= 30" class="text-red-500 text-xs mt-1 font-semibold">Maksimal karakter tercapai</p>
                @error('username')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('profileModal')"
                        class="flex-1 py-3 rounded-xl border-2 border-gray-200 text-dark font-semibold hover:bg-gray-50 transition-colors bg-transparent cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-secondary hover:bg-secondary-dark text-white font-semibold transition-colors border-none cursor-pointer">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
