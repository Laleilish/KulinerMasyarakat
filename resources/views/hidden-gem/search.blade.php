<section class="px-4 pt-4 pb-2 max-w-[600px] mx-auto">
    <div id="location-bar"
         class="flex items-center gap-3 px-4 bg-white rounded-full h-[52px]
                shadow-[var(--shadow-card)] border border-black/[0.06]
                transition-all duration-300">

        {{-- Icon lokasi --}}
        <div id="loc-icon-wrap" class="flex-shrink-0">
            <div id="loc-spinner"
                 class="w-5 h-5 rounded-full border-2 border-[#F5A623] border-t-transparent animate-spin hidden">
            </div>
            <i id="loc-icon"
               class="fas fa-location-dot text-[#F5A623] text-[16px]"></i>
        </div>

        {{-- Teks --}}
        <div class="flex-1 flex flex-col justify-center min-w-0">
            <span id="loc-label"
                  class="text-[9px] text-muted font-semibold leading-none mb-[3px] uppercase tracking-wide">
                Mendeteksi lokasi...
            </span>
            <span id="loc-value"
                  class="text-[13px] font-bold text-dark truncate leading-none">
                Mohon tunggu sebentar
            </span>
        </div>

        {{-- Status badge --}}
        <div id="loc-badge"
             class="flex-shrink-0 hidden">
            <span class="flex items-center gap-1 bg-[#F5A623]/10 text-[#C07A2A]
                         text-[10px] font-bold px-2 py-1 rounded-full">
                <i class="fas fa-circle text-[6px]"></i>
                <span id="loc-badge-text">GPS</span>
            </span>
        </div>

    </div>
</section>