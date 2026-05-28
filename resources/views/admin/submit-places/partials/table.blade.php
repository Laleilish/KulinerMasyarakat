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
                                    <img src="{{ Storage::url($place->photo) }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
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
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
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
                            <a href="{{ route('admin.submit-places.show', $place) }}" class="text-gray-500 hover:text-gray-900 transition-colors" title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                            
                            @if($place->status === 'pending')
                                <form action="{{ route('admin.submit-places.approve', $place) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Setujui usulan ini?')" class="text-emerald-500 hover:text-emerald-700 transition-colors bg-transparent border-none cursor-pointer" title="Setujui">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.submit-places.reject', $place) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Tolak usulan ini?')" class="text-gray-500 hover:text-rose-600 transition-colors bg-transparent border-none cursor-pointer" title="Tolak">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
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
