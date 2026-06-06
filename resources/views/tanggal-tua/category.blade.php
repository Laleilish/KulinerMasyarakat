<section class="px-5 mt-4 mb-6">

    <h2 class="text-[16px] font-bold text-dark mb-3">
        Semua Makanan Hanya Dibawah 15rb
    </h2>

    {{-- Filter Chips (Sort) --}}
    <div class="flex gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden mb-5">

        {{-- Icon Filter --}}
        <button class="flex items-center justify-center w-8 h-8 rounded-md border border-[#F5A623] text-[#F5A623] flex-shrink-0 bg-transparent">
            <i class="fas fa-sliders-h text-[13px]"></i>
        </button>

        {{-- Sort Chips --}}
        <button class="tt-sort-chip px-3 py-1 rounded-full border text-[12px] font-bold flex-shrink-0 transition-all duration-150
                       bg-[#F5A623] text-white border-transparent"
                data-sort="populer">
            Populer
        </button>
        <button class="tt-sort-chip px-3 py-1 rounded-full border text-[12px] font-bold flex-shrink-0 transition-all duration-150
                       bg-transparent text-[#F5A623] border-[#F5A623]"
                data-sort="penilaian">
            Penilaian ★
        </button>
        <button class="tt-sort-chip px-3 py-1 rounded-full border text-[12px] font-bold flex-shrink-0 transition-all duration-150
                       bg-transparent text-[#F5A623] border-[#F5A623]"
                data-sort="termurah">
            Termurah
        </button>
        <button class="tt-sort-chip px-3 py-1 rounded-full border text-[12px] font-bold flex-shrink-0 transition-all duration-150
                       bg-transparent text-[#F5A623] border-[#F5A623]"
                data-sort="bawah10k">
            Dibawah 10k 🔥
        </button>

    </div>

    {{-- Category Chips (Mengikuti desain Full Screen Map) --}}
    <div class="flex gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden px-1 pb-2">
        <button class="tt-cat-chip px-4 py-1.5 rounded-full text-[13px] font-semibold whitespace-nowrap transition-all border border-[#F5A623] text-[#F5A623] hover:bg-[#F5A623] hover:text-white" data-category="makanan">
            Makanan
        </button>
        <button class="tt-cat-chip px-4 py-1.5 rounded-full text-[13px] font-semibold whitespace-nowrap transition-all border border-[#F5A623] text-[#F5A623] hover:bg-[#F5A623] hover:text-white" data-category="minuman">
            Minuman
        </button>
        <button class="tt-cat-chip px-4 py-1.5 rounded-full text-[13px] font-semibold whitespace-nowrap transition-all border border-[#F5A623] text-[#F5A623] hover:bg-[#F5A623] hover:text-white" data-category="jajanan">
            Jajanan
        </button>
        <button class="tt-cat-chip px-4 py-1.5 rounded-full text-[13px] font-semibold whitespace-nowrap transition-all border border-[#F5A623] text-[#F5A623] hover:bg-[#F5A623] hover:text-white" data-category="manis">
            Manis
        </button>
        <button class="tt-cat-chip px-4 py-1.5 rounded-full text-[13px] font-semibold whitespace-nowrap transition-all border border-[#F5A623] text-[#F5A623] hover:bg-[#F5A623] hover:text-white" data-category="mie">
            Mie
        </button>
    </div>

    {{-- Label kampus aktif --}}
    <div id="tt-campus-badge" class="hidden mt-3 flex items-center gap-2">
        <span class="text-[11px] text-muted">Filter kampus:</span>
        <span id="tt-campus-name" class="text-[11px] font-bold text-[#C07A2A] bg-[#FFF7ED] px-3 py-1 rounded-full border border-[#F5A623]/40"></span>
        <button id="tt-campus-clear" class="text-[10px] text-muted hover:text-red-400 transition-colors">
            <i class="fas fa-xmark"></i> hapus
        </button>
    </div>

</section>