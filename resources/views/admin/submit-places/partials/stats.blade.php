<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    {{-- Total Resto Terdaftar --}}
    <div class="bg-white rounded-2xl p-4 border border-gray-100/50 shadow-sm aspect-[5/3] md:aspect-[16/9] flex flex-col items-center justify-center text-center gap-3">
        <h4 class="text-gray-900 font-semibold text-base">
            Total Resto Terdaftar
        </h4>

        <span class="text-3xl font-semibold text-gray-900 leading-none">
            {{ number_format($totalRestoTerdaftar) }}
        </span>

        <p class="text-xs text-gray-500 leading-relaxed max-w-[190px] mx-auto">
            Jumlah resto yang terdaftar dalam sistem
        </p>
    </div>

    {{-- Usulan Tertunda --}}
    <div class="bg-white rounded-2xl p-4 border border-gray-100/50 shadow-sm aspect-[5/3] md:aspect-[16/9] flex flex-col items-center justify-center text-center gap-3">
        <h4 class="text-gray-900 font-semibold text-base">
            Usulan Tertunda
        </h4>

        <div class="flex items-center justify-center gap-2">
            <span class="text-3xl font-semibold text-gray-900 leading-none">
                {{ number_format($usulanTertunda) }}
            </span>

            @if($usulanTertunda > 0)
                <span class="text-xs font-bold text-rose-500">
                    Segera
                </span>
            @endif
        </div>

        <p class="text-xs text-gray-500 leading-relaxed">
            Membutuhkan persetujuan admin
        </p>
    </div>

    {{-- Kampus Favorit --}}
    <div class="bg-white rounded-2xl p-4 border border-gray-100/50 shadow-sm aspect-[5/3] md:aspect-[16/9] flex flex-col items-center justify-center text-center gap-3">
        <h4 class="text-gray-900 font-semibold text-base">
            Kampus Favorit
        </h4>

        @if($topCampus)
            <div class="flex flex-row items-center justify-center gap-3">
                @if($topCampus->logo)
                    <div class="w-14 h-14 rounded-lg overflow-hidden shrink-0">
                        <img 
                            src="{{ asset('assets/Kampus/' . $topCampus->logo) }}" 
                            alt="{{ $topCampus->name }}" 
                            class="w-full h-full object-contain"
                        >
                    </div>
                @else
                    <div class="w-10 h-10 rounded-lg bg-[#F2E0BE] flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>
                @endif

                <span class="font-bold text-gray-800 text-sm leading-tight max-w-[95px] text-center">
                    {{ $topCampus->name }}
                </span>
            </div>

            <p class="text-xs text-gray-500 leading-relaxed">
                {{ $topCampus->restaurants_count }} resto terdaftar
            </p>
        @else
            <p class="text-sm text-gray-400">
                Belum ada data kampus
            </p>
        @endif
    </div>
</div>