<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Total Resto Terdaftar --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm flex flex-col justify-between aspect-[4/3] sm:aspect-auto sm:h-44">
        <h4 class="text-gray-900 font-bold text-lg mb-4">Total Resto Terdaftar</h4>
        <div>
            <div class="flex items-baseline gap-2 mb-2">
                <span class="text-4xl font-bold text-gray-900">{{ number_format($totalRestoTerdaftar) }}</span>
            </div>
            <p class="text-xs text-gray-500 leading-relaxed">Jumlah resto yang terdaftar dalam sistem</p>
        </div>
    </div>

    {{-- Usulan Tertunda --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm flex flex-col justify-between aspect-[4/3] sm:aspect-auto sm:h-44">
        <h4 class="text-gray-900 font-bold text-lg mb-4">Usulan Tertunda</h4>
        <div>
            <div class="flex items-baseline gap-2 mb-2">
                <span class="text-4xl font-bold text-gray-900">{{ number_format($usulanTertunda) }}</span>
                @if($usulanTertunda > 0)
                    <span class="text-xs font-bold text-rose-500">Segera</span>
                @endif
            </div>
            <p class="text-xs text-gray-500 leading-relaxed">Membutuhkan persetujuan admin</p>
        </div>
    </div>

    {{-- Kampus Favorit --}}
    <div class="bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm flex flex-col justify-between aspect-[4/3] sm:aspect-auto sm:h-44">
        <h4 class="text-gray-900 font-bold text-lg mb-4">Kampus Favorit</h4>
        <div>
            @if($topCampus)
                <div class="flex items-center gap-3 mb-3">
                    @if($topCampus->logo)
                        <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 border border-gray-100">
                            <img src="{{ asset('assets/Kampus/' . $topCampus->logo) }}" alt="{{ $topCampus->name }}" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-lg bg-[#F2E0BE] flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                    @endif
                    <span class="font-bold text-gray-800 text-sm">{{ $topCampus->name }}</span>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $topCampus->restaurants_count }} resto terdaftar</p>
            @else
                <p class="text-sm text-gray-400">Belum ada data kampus</p>
            @endif
        </div>
    </div>
</div>
