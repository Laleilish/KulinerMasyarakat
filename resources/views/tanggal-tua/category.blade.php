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

    {{-- Category Circles --}}
    <div class="flex gap-4 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden px-1">

        {{-- Makanan --}}
        <div class="tt-cat-item flex flex-col items-center gap-1 cursor-pointer select-none" data-category="makanan">
            <div class="cat-ring w-16 h-16 rounded-full overflow-hidden border-2 border-[#F5A623] shadow-sm flex items-center justify-center bg-white transition-all duration-200">
                <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=150"
                     class="w-full h-full object-cover rounded-full" alt="Makanan">
            </div>
            <span class="cat-label font-bold text-[10px] text-dark transition-all duration-200">Makanan</span>
        </div>

        {{-- Minuman --}}
        <div class="tt-cat-item flex flex-col items-center gap-1 cursor-pointer select-none" data-category="minuman">
            <div class="cat-ring w-16 h-16 rounded-full overflow-hidden border-2 border-[#F5A623] shadow-sm flex items-center justify-center bg-white transition-all duration-200">
                <img src="https://images.unsplash.com/photo-1544145945-f90425340c7e?w=150"
                     class="w-full h-full object-cover rounded-full" alt="Minuman">
            </div>
            <span class="cat-label font-bold text-[10px] text-dark transition-all duration-200">Minuman</span>
        </div>

        {{-- Jajanan --}}
        <div class="tt-cat-item flex flex-col items-center gap-1 cursor-pointer select-none" data-category="jajanan">
            <div class="cat-ring w-16 h-16 rounded-full overflow-hidden border-2 border-[#F5A623] shadow-sm flex items-center justify-center bg-white transition-all duration-200">
                <img src="https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=150"
                     class="w-full h-full object-cover rounded-full" alt="Jajanan">
            </div>
            <span class="cat-label font-bold text-[10px] text-dark transition-all duration-200">Jajanan</span>
        </div>

        {{-- Manis --}}
        <div class="tt-cat-item flex flex-col items-center gap-1 cursor-pointer select-none" data-category="manis">
            <div class="cat-ring w-16 h-16 rounded-full overflow-hidden border-2 border-[#F5A623] shadow-sm flex items-center justify-center bg-white transition-all duration-200">
                <img src="https://images.unsplash.com/photo-1563805042-7684c8a9e9cb?w=150"
                     class="w-full h-full object-cover rounded-full" alt="Makanan Manis">
            </div>
            <span class="cat-label font-bold text-[10px] text-dark transition-all duration-200">Manis</span>
        </div>

        {{-- Mie --}}
        <div class="tt-cat-item flex flex-col items-center gap-1 cursor-pointer select-none" data-category="mie">
            <div class="cat-ring w-16 h-16 rounded-full overflow-hidden border-2 border-[#F5A623] shadow-sm flex items-center justify-center bg-white transition-all duration-200">
                <img src="https://images.unsplash.com/photo-1585032226651-759b368d7246?w=150"
                     class="w-full h-full object-cover rounded-full" alt="Mie">
            </div>
            <span class="cat-label font-bold text-[10px] text-dark transition-all duration-200">Mie</span>
        </div>

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