{{-- Modal: Ubah Email --}}
<div id="emailModal" class="hidden fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center z-50 px-4 pb-4 sm:pb-0">
    <div class="bg-white rounded-2xl w-full max-w-sm shadow-card">
        <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-dark">Ubah Email</h3>
            <button onclick="closeModal('emailModal')" class="text-muted hover:text-dark bg-transparent border-none cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="p-5 space-y-4">
            @csrf
            @method('patch')
            <input type="hidden" name="name" value="{{ $user->name }}">
            <input type="hidden" name="username" value="{{ $user->username }}">

            <div>
                <label class="block text-xs font-bold text-dark tracking-wider mb-2">Email Baru</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-3 rounded-xl border-2 border-muted-light focus:border-secondary focus:ring-0 text-dark transition-all @error('email') border-red-400 @enderror"/>
                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('emailModal')"
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
