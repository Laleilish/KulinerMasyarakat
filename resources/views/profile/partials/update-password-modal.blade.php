{{-- Ubah Password --}}
<div id="passwordModal" class="hidden fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center z-50 px-4 pb-4 sm:pb-0">
    <div class="bg-white rounded-2xl w-full max-w-sm shadow-card">
        <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-dark">Ubah Password</h3>
            <button onclick="closeModal('passwordModal')" class="text-muted hover:text-dark bg-transparent border-none cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="p-5 space-y-4">
            @csrf
            @method('put')

            <div>
                <label class="block text-xs font-bold text-dark tracking-wider mb-2">Password Saat Ini</label>
                <input type="password" name="current_password" required autocomplete="current-password"
                       class="w-full px-4 py-3 rounded-xl border-2 border-muted-light focus:border-secondary focus:ring-0 text-dark transition-all @error('current_password', 'updatePassword') border-red-400 @enderror"/>
                @error('current_password', 'updatePassword')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-dark  tracking-wider mb-2">Password Baru</label>
                <input type="password" name="password" required autocomplete="new-password"
                       class="w-full px-4 py-3 rounded-xl border-2 border-muted-light focus:border-secondary focus:ring-0 text-dark transition-all @error('password', 'updatePassword') border-red-400 @enderror"/>
                @error('password', 'updatePassword')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-dark tracking-wider mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full px-4 py-3 rounded-xl border-2 border-muted-light focus:border-secondary focus:ring-0 text-dark transition-all"/>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('passwordModal')"
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
