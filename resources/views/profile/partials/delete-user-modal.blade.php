{{-- Modal: Hapus Akun --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-end sm:items-center justify-center z-50 px-4 pb-4 sm:pb-0">
    <div class="bg-white rounded-2xl w-full max-w-sm shadow-card">
        <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-dark">Hapus Akun?</h3>
            <button onclick="closeModal('deleteModal')" class="text-muted hover:text-dark bg-transparent border-none cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('profile.destroy') }}" class="p-5 space-y-4">
            @csrf
            @method('delete')

            <p class="text-sm text-muted">
                Setelah akun dihapus, semua data akan hilang permanen. Masukkan password untuk konfirmasi.
            </p>

            <div>
                <label class="block text-xs font-bold text-dark tracking-wider mb-2">Password</label>
                <input type="password" name="password" placeholder="Masukkan password Anda" required
                       class="w-full px-4 py-3 rounded-xl border-2 border-muted-light focus:border-red-400 focus:ring-0 text-dark placeholder:text-gray-400 transition-all"/>
                @if($errors->userDeletion->get('password'))
                    <p class="mt-1 text-xs text-red-600">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('deleteModal')"
                        class="flex-1 py-3 rounded-xl border-2 border-gray-200 text-dark font-semibold hover:bg-gray-50 transition-colors bg-transparent cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition-colors border-none cursor-pointer">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>
