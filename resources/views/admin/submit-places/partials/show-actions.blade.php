{{-- Action Buttons --}}
    <div class="flex flex-wrap items-center gap-3 pt-6 border-t border-gray-100">
        @if ($submitPlace->status === 'pending')
            <form action="{{ route('admin.submit-places.approve', $submitPlace) }}" method="POST" class="inline" id="approve-place-{{ $submitPlace->id }}">
                @csrf
                @method('PATCH')
                <button type="button"
                        @click="$dispatch('confirm-modal', {
                            title: 'Setujui Usulan?',
                            message: 'Apakah Anda yakin ingin menyetujui usulan tempat ini?',
                            variant: 'confirm',
                            confirmText: 'Ya, Setujui',
                            formId: 'approve-place-{{ $submitPlace->id }}'
                        })"
                        class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl transition-all shadow-sm hover:shadow shrink-0 cursor-pointer border-none">
                    Setujui
                </button>
            </form>
        @endif

        @if($submitPlace->status !== 'rejected')
            <button type="button"
                    @click="$dispatch('open-reject-modal', { placeId: {{ $submitPlace->id }}, placeName: '{{ addslashes($submitPlace->name) }}' })"
                    class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm rounded-xl transition-all shadow-sm hover:shadow shrink-0 cursor-pointer border-none">
                Tolak
            </button>
        @endif

        <a href="{{ route('admin.submit-places.edit', $submitPlace) }}"
           class="px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-bold text-sm rounded-xl transition-all shadow-sm hover:shadow shrink-0 cursor-pointer border-none text-center no-underline inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            Edit Data
        </a>

        <form action="{{ route('admin.submit-places.destroy', $submitPlace) }}" method="POST" class="inline" id="destroy-place-{{ $submitPlace->id }}">
            @csrf
            @method('DELETE')
            <button type="button"
                    @click="$dispatch('confirm-modal', {
                        title: 'Hapus Permanen?',
                        message: 'Apakah Anda yakin ingin menghapus usulan tempat ini secara permanen?',
                        variant: 'danger',
                        confirmText: 'Ya, Hapus',
                        formId: 'destroy-place-{{ $submitPlace->id }}'
                    })"
                    class="px-6 py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-bold text-sm rounded-xl transition-all shadow-sm hover:shadow shrink-0 cursor-pointer border-none">
                Hapus Permanen
            </button>
        </form>
    </div>
