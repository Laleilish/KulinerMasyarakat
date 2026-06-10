<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-white border-b border-gray-100/50 text-gray-900 font-bold text-sm">
                <th class="px-6 py-5">Detail Resto</th>
                <th class="px-6 py-5">Kampus Terdekat</th>
                <th class="px-6 py-5">Kategori</th>
                <th class="px-6 py-5">Rating</th>
                <th class="px-6 py-5">Status</th>
                <th class="px-6 py-5">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100/50 text-sm">
            @forelse ($submitPlaces as $place)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4 max-w-[250px]">
                            <div class="w-14 h-14 rounded-lg bg-gray-100 overflow-hidden shrink-0">
                                @if($place->photo)
                                    <img src="{{ str_starts_with($place->photo, 'http') ? $place->photo : Storage::url($place->photo) }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold bg-gray-50">
                                        KMR
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 leading-tight mb-1">{{ $place->name }}</p>
                                <span class="text-xs text-gray-500 line-clamp-1">{{ $place->address }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700">{{ $place->campus->name ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-gray-700">
                            {{ str_replace('_', ' ', ucwords($place->category, '_')) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1.5 text-gray-900 font-medium">
                            {{ $place->initial_rating ?? '-' }}
                            @if($place->initial_rating)
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($place->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                <span class="w-1.5 h-1.5 bg-orange rounded-full"></span>
                                Pending
                            </span>
                        @elseif($place->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Terbit
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">
                                <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            {{-- Edit / Detail --}}
                            <a href="{{ route('admin.submit-places.edit', $place) }}" 
                                class="p-2 text-blue-500 hover:text-white bg-blue-50 hover:bg-blue-500 rounded-xl transition-all border border-blue-100 hover:border-blue-500 cursor-pointer" 
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>

                            {{-- Tolak --}}
                            @if($place->status !== 'rejected')
                                <button type="button"
                                        @click="$dispatch('open-reject-modal', { placeId: {{ $place->id }}, placeName: '{{ addslashes($place->name) }}' })"
                                        class="p-2 text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-500 rounded-xl transition-all border border-rose-100 hover:border-rose-500 cursor-pointer" 
                                        title="Tolak Usulan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636L5.636 18.364M5.636 5.636l12.728 12.728"/></svg>
                                </button>
                            @else
                                <span class="p-2 text-gray-300 bg-gray-50 rounded-xl border border-gray-100 cursor-not-allowed" title="Sudah ditolak">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636L5.636 18.364M5.636 5.636l12.728 12.728"/></svg>
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="w-16 h-16 bg-[#F8F4EC] rounded-full flex items-center justify-center text-2xl mx-auto mb-3 text-gray-400">
                            📬
                        </div>
                        <h5 class="font-bold text-gray-700">Belum ada usulan tempat</h5>
                        <p class="text-xs text-gray-400 mt-1">Data akan muncul di sini.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Alasan Penolakan --}}
<div x-data="{
        open: false,
        placeId: null,
        placeName: '',
        reason: '',
        init() {
            window.addEventListener('open-reject-modal', (e) => {
                this.placeId = e.detail.placeId;
                this.placeName = e.detail.placeName;
                this.reason = '';
                this.open = true;
            });
        }
    }"
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
    @keydown.escape.window="open = false"
    @click.self="open = false"
>
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Tolak Usulan Tempat</h3>
                <p class="text-xs text-gray-500 mt-0.5">Isi alasan penolakan yang akan dikirim ke pengguna.</p>
            </div>
            <button type="button" @click="open = false" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors bg-transparent border-none cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <form :action="`{{ url('admin/submit-places') }}/${placeId}/reject`" method="POST">
            @csrf
            @method('PATCH')

            <div class="px-6 py-5">
                {{-- Info nama usulan --}}
                <div class="mb-4 px-3 py-2.5 bg-rose-50 border border-rose-100 rounded-xl">
                    <p class="text-xs text-rose-700">
                        Kamu akan menolak usulan: <span class="font-bold" x-text="placeName"></span>
                    </p>
                </div>

                {{-- Textarea alasan --}}
                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                    Alasan Penolakan <span class="text-rose-500">*</span>
                </label>
                <textarea
                    name="rejection_reason"
                    x-model="reason"
                    rows="4"
                    placeholder="Contoh: Foto kurang jelas, alamat tidak lengkap, dll."
                    class="w-full border border-gray-200 rounded-xl text-sm text-gray-700 p-3 focus:ring-[#B87A29] focus:border-[#B87A29] resize-none"
                    required
                ></textarea>
                <p class="text-xs text-gray-400 mt-1" x-text="`${reason.length}/1000 karakter`"></p>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" @click="open = false"
                        class="px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                        :disabled="reason.trim().length === 0"
                        class="px-4 py-2 text-sm font-semibold text-white bg-rose-500 border border-rose-500 rounded-xl hover:bg-rose-600 transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                    Tolak Usulan
                </button>
            </div>
        </form>
    </div>
</div>
