{{-- Crop Foto Profil Modal --}}
<style>
    /* Mengubah area crop menjadi lingkaran */
    .cropper-view-box,
    .cropper-face {
        border-radius: 50%;
    }
</style>
<div id="cropModal" class="hidden fixed inset-0 bg-black/60 flex items-end sm:items-center justify-center z-50 px-4 pb-4 sm:pb-0">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-card overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 pt-5 pb-3 border-b border-gray-100">
            <h3 class="text-base font-bold text-dark">Sesuaikan Foto Profil</h3>
            <button type="button" onclick="closeModal('cropModal')" class="text-muted hover:text-dark bg-transparent border-none cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-5">
            <div class="w-full max-h-[320px] bg-cream-bg rounded-xl overflow-hidden flex items-center justify-center mb-4">
                <img id="cropperImage" src="" alt="Pratinjau Gambar" class="max-w-full max-h-[320px] block">
            </div>

            {{-- Footer Buttons --}}
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal('cropModal')"
                        class="flex-1 py-3 rounded-xl border-2 border-gray-200 text-dark font-semibold hover:bg-gray-50 transition-colors bg-transparent cursor-pointer">
                    Batal
                </button>
                <button type="button" id="cropSaveBtn"
                        class="flex-1 py-3 rounded-xl bg-secondary hover:bg-secondary-dark text-white font-semibold transition-colors border-none cursor-pointer">
                    Potong & Simpan
                </button>
            </div>
        </div>
    </div>
</div>
