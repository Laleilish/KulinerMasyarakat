<section class="px-4 pt-4 pb-2 max-w-[600px] mx-auto">
    <div class="flex items-center gap-3 px-4 bg-white rounded-full h-[46px]
                shadow-[0_2px_8px_rgba(0,0,0,0.08)] border border-black/[0.06]
                focus-within:ring-2 focus-within:ring-[#F5A623]/40 transition-all duration-200">
        <i class="fas fa-location-dot text-[#F5A623] text-[14px] flex-shrink-0"></i>
        <div class="flex-1 flex flex-col justify-center min-w-0">
            <span class="text-[9px] text-muted font-medium leading-none mb-[2px]">Lokasi Kampus</span>
            <span id="search-campus-name"
                  class="text-[13px] font-bold text-dark truncate leading-none">
                {{ $selectedCampus->name }}
            </span>
        </div>
        <button class="flex-shrink-0 text-muted hover:text-[#F5A623] transition-colors duration-150">
            <i class="fas fa-chevron-down text-[13px]"></i>
        </button>
    </div>
</section>