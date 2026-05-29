{{-- Action Buttons --}}
@if ($submitPlace->status === 'pending')
    <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
        <form action="{{ route('admin.submit-places.approve', $submitPlace) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit"
                    onclick="return confirm('Apakah Anda yakin ingin menyetujui usulan tempat ini?')"
                    class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-xl transition-all shadow-sm hover:shadow shrink-0 cursor-pointer border-none">
                Setujui
            </button>
        </form>
        <form action="{{ route('admin.submit-places.reject', $submitPlace) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit"
                    onclick="return confirm('Apakah Anda yakin ingin menolak usulan tempat ini?')"
                    class="px-6 py-2.5 bg-red-400 hover:bg-red-600 text-white font-bold text-sm rounded-xl transition-all shadow-sm hover:shadow shrink-0 cursor-pointer border-none">
                Tolak
            </button>
        </form>
    </div>
@endif
