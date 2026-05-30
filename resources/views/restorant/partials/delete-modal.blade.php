<div x-data="{ openDeleteModal: false, deleteUrl: '' }"
     @open-delete-modal.window="openDeleteModal = true; deleteUrl = $event.detail.url"
     x-show="openDeleteModal"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;">
    <div @click.away="openDeleteModal = false"
         class="bg-white rounded-3xl p-6 max-w-sm w-full shadow-2xl border border-gray-100"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="scale-95 translate-y-4"
         x-transition:enter-end="scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="scale-100 translate-y-0"
         x-transition:leave-end="scale-95 translate-y-4">

        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-50 text-red-500 rounded-full mb-4">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>

        <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Hapus Ulasan?</h3>
        <p class="text-sm text-gray-500 text-center mb-6 leading-relaxed">
            Apakah Anda yakin ingin menghapus ulasan ini? Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="flex gap-3 justify-center">
            <button @click="openDeleteModal = false"
                    class="px-5 py-2.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold transition">
                Batal
            </button>
            <form :action="deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-5 py-2.5 rounded-full bg-red-500 hover:bg-red-600 text-white text-sm font-bold transition shadow-sm shadow-red-200">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
