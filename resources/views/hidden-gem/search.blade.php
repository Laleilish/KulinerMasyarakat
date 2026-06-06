<section class="px-4 md:px-6 lg:px-8 pt-4 pb-2
                 max-w-[600px] md:max-w-[900px] lg:max-w-[1200px]
                 mx-auto w-full" id="search-section">
    <div id="location-bar-wrap" class="relative bg-white rounded-2xl shadow-[var(--shadow-card)]
                border border-black/[0.06] transition-all duration-300">

        {{-- Main bar --}}
        <div class="flex items-center gap-3 px-4 h-[54px]">

            {{-- Icon kiri --}}
            <div id="loc-icon-wrap" class="shrink-0 w-5 h-5 flex items-center justify-center gap-2">
                <div id="loc-spinner"
                    class="hidden shrink-0 w-4 h-4 rounded-full border-2 border-[#F5A623] border-t-transparent animate-spin">
                </div>

                <i id="loc-icon" class="fa-solid fa-location-dot text-[#F5A623] shrink-0 leading-none"></i>
            </div>

            {{-- Input --}}
            <div class="flex-1 flex flex-col justify-center min-w-0">
                <label id="loc-label" class="text-[9px] text-muted font-semibold uppercase
                              tracking-wider leading-none mb-[3px] transition-all duration-200">
                    Lokasi Kamu
                </label>
                <input id="loc-input" type="text" placeholder="Cari lokasi atau kampus..." autocomplete="off" class="w-full border-none outline-none bg-transparent
                              text-[13px] font-semibold text-dark
                              placeholder:text-muted/50 placeholder:font-normal
                              transition-all duration-200">
            </div>

            {{-- Tombol clear --}}
            <button id="loc-clear" class="hidden flex-shrink-0 w-7 h-7 rounded-full
                           bg-black/[0.06] flex items-center justify-center
                           hover:bg-black/10 transition-colors duration-150">
                <i class="fas fa-xmark text-[12px] text-muted"></i>
            </button>

            {{-- GPS button --}}
            <button id="loc-gps-btn" title="Gunakan lokasi saya" class="flex-shrink-0 w-8 h-8 rounded-full
                           bg-[#F5A623]/10 flex items-center justify-center
                           hover:bg-[#F5A623]/20 transition-colors duration-150">
                <i class="fas fa-crosshairs text-[#F5A623] text-[14px]"></i>
            </button>
        </div>

        {{-- Dropdown autocomplete --}}
        <div id="loc-dropdown" class="hidden absolute top-[calc(100%+6px)] left-0 right-0
                    bg-white border border-black/[0.08] rounded-2xl
                    shadow-[0_8px_32px_rgba(0,0,0,0.12)] z-[500]
                    overflow-hidden">

            {{-- Section: Kampus --}}
            <div id="dropdown-campus-section">
                <div class="px-4 py-2 text-[10px] font-bold text-muted uppercase tracking-wider
                            bg-black/[0.02] border-b border-black/[0.04]">
                    Kampus
                </div>
                <div id="dropdown-campus-list"></div>
            </div>

            {{-- Section: Hasil pencarian --}}
            <div id="dropdown-search-section" class="hidden">
                <div class="px-4 py-2 text-[10px] font-bold text-muted uppercase tracking-wider
                            bg-black/[0.02] border-b border-black/[0.04]">
                    Hasil Pencarian
                </div>
                <div id="dropdown-search-list"></div>
            </div>

            {{-- Loading state --}}
            <div id="dropdown-loading" class="hidden flex items-center gap-3 px-4 py-3">
                <div class="w-4 h-4 rounded-full border-2 border-[#F5A623]
                            border-t-transparent animate-spin flex-shrink-0"></div>
                <span class="text-[12px] text-muted">Mencari lokasi...</span>
            </div>

            {{-- Empty state --}}
            <div id="dropdown-empty" class="hidden px-4 py-4 text-center">
                <i class="fas fa-map-pin text-muted/40 text-[20px] mb-2 block"></i>
                <p class="text-[12px] text-muted">Lokasi tidak ditemukan</p>
            </div>
        </div>

    </div>
</section>