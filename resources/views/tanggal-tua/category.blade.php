<section class="px-5 md:px-10 mt-4 mb-6 max-w-[1400px] mx-auto w-full">

    <h2 class="text-[18px] md:text-[22px] font-extrabold text-dark mb-4 md:text-center">
        Semua Makanan Hanya Dibawah 15rb
    </h2>

    {{-- Filter Chips (Sort) - GoFood Style --}}
    <div class="flex gap-2 overflow-x-auto md:justify-start mb-6 px-1 py-1 pb-2">
        <button id="tt-btn-filter-modal" class="flex items-center justify-center px-4 py-2 rounded-full border border-gray-300 text-dark flex-shrink-0 bg-white hover:bg-gray-50 transition-colors shadow-sm">
            <i class="fas fa-sliders-h text-[13px] text-gray-500 tt-btn-filter-icon"></i>
        </button>
        <button class="tt-sort-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark flex-shrink-0 transition-all bg-white hover:bg-gray-50 shadow-sm" data-sort="populer">
            Populer
        </button>
        <button class="tt-sort-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark flex-shrink-0 transition-all bg-white hover:bg-gray-50 shadow-sm" data-sort="penilaian">
            Penilaian 4.5+
        </button>
        <button class="tt-sort-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark flex-shrink-0 transition-all bg-white hover:bg-gray-50 shadow-sm" data-sort="termurah">
            Termurah
        </button>
        <button class="tt-sort-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark flex-shrink-0 transition-all bg-white hover:bg-gray-50 shadow-sm" data-sort="bawah10k">
            Dibawah 10k 🔥
        </button>
    </div>

    {{-- Category Circles - GoFood Style --}}
    <div class="flex gap-4 md:gap-8 overflow-x-auto md:justify-start border-b border-gray-200 pb-2">

        {{-- Semua --}}
        <div class="tt-cat-item flex flex-col items-center gap-2 cursor-pointer select-none group min-w-[80px] flex-shrink-0 pb-3 border-b-[3px] border-[#F5A623] transition-colors" data-category="semua">
            <div class="w-[75px] h-[75px] rounded-full overflow-hidden flex items-center justify-center bg-amber-50 group-hover:bg-amber-100 transition-colors shadow-sm">
                <i class="fas fa-utensils text-[#F5A623] text-2xl"></i>
            </div>
            <span class="cat-label font-bold text-[13px] text-dark">Semua</span>
        </div>

        {{-- Makanan Berat --}}
        <div class="tt-cat-item flex flex-col items-center gap-2 cursor-pointer select-none group min-w-[80px] flex-shrink-0 pb-3 border-b-[3px] border-transparent hover:border-gray-300 transition-colors" data-category="makanan_berat">
            <div class="w-[75px] h-[75px] rounded-full overflow-hidden flex items-center justify-center bg-gray-100 shadow-sm">
                <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=150" class="w-full h-full object-cover" alt="Makanan Berat">
            </div>
            <span class="cat-label font-medium text-[13px] text-muted">Makanan Berat</span>
        </div>

        {{-- Jajanan --}}
        <div class="tt-cat-item flex flex-col items-center gap-2 cursor-pointer select-none group min-w-[80px] flex-shrink-0 pb-3 border-b-[3px] border-transparent hover:border-gray-300 transition-colors" data-category="jajanan">
            <div class="w-[75px] h-[75px] rounded-full overflow-hidden flex items-center justify-center bg-gray-100 shadow-sm">
                <img src="https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=150" class="w-full h-full object-cover" alt="Jajanan">
            </div>
            <span class="cat-label font-medium text-[13px] text-muted">Jajanan</span>
        </div>

        {{-- Minuman --}}
        <div class="tt-cat-item flex flex-col items-center gap-2 cursor-pointer select-none group min-w-[80px] flex-shrink-0 pb-3 border-b-[3px] border-transparent hover:border-gray-300 transition-colors" data-category="minuman">
            <div class="w-[75px] h-[75px] rounded-full overflow-hidden flex items-center justify-center bg-gray-100 shadow-sm">
                <img src="https://images.unsplash.com/photo-1544145945-f90425340c7e?w=150" class="w-full h-full object-cover" alt="Minuman">
            </div>
            <span class="cat-label font-medium text-[13px] text-muted">Minuman</span>
        </div>

    </div>

    {{-- Label kampus aktif --}}
    <div id="tt-campus-badge" class="hidden mt-4 items-center gap-2">
        <span class="text-[12px] text-muted">Menampilkan promo di:</span>
        <span id="tt-campus-name" class="text-[12px] font-bold text-dark bg-gray-100 px-3 py-1 rounded-full border border-gray-200"></span>
        <button id="tt-campus-clear" class="text-[11px] text-muted hover:text-red-500 transition-colors ml-1">
            <i class="fas fa-xmark"></i> hapus
        </button>
    </div>

</section>