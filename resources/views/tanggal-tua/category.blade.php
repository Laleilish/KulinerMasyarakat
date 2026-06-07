<section class="px-5 md:px-10 mt-6 mb-8 max-w-[1400px] mx-auto w-full">

    {{-- Category Circles --}}
    <div class="flex gap-3 md:gap-10 overflow-x-auto justify-center pb-2 no-scrollbar">

        {{-- Semua --}}
        <div class="tt-cat-item flex flex-col items-center gap-3 cursor-pointer select-none group min-w-[60px] flex-shrink-0 transition-all" data-category="semua">
            <div class="tt-cat-icon w-[64px] h-[64px] rounded-full overflow-hidden flex items-center justify-center bg-[#FFF3E0] border-2 border-[#F5A623] transition-all">
                <img src="{{ asset('assets/img/Tanggal Tua/semua-makanan.png') }}" class="w-full h-full object-cover scale-[1.3]" alt="Semua Makanan">
            </div>
            <span class="cat-label font-bold text-[13px] text-dark">Semua</span>
        </div>

        {{-- Makanan Berat --}}
        <div class="tt-cat-item flex flex-col items-center gap-3 cursor-pointer select-none group min-w-[60px] flex-shrink-0 transition-all" data-category="makanan_berat">
            <div class="tt-cat-icon w-[64px] h-[64px] rounded-full overflow-hidden border-2 border-transparent group-hover:border-[#F5A623] transition-all bg-[#F3F4F6]">
                <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=150" class="w-full h-full object-cover" alt="Makanan Berat">
            </div>
            <span class="cat-label font-medium text-[13px] text-muted group-hover:text-[#F5A623] transition-colors">Makanan Berat</span>
        </div>

        {{-- Jajanan --}}
        <div class="tt-cat-item flex flex-col items-center gap-3 cursor-pointer select-none group min-w-[60px] flex-shrink-0 transition-all" data-category="jajanan">
            <div class="tt-cat-icon w-[64px] h-[64px] rounded-full overflow-hidden border-2 border-transparent group-hover:border-[#F5A623] transition-all bg-[#F3F4F6]">
                <img src="https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=150" class="w-full h-full object-cover" alt="Jajanan">
            </div>
            <span class="cat-label font-medium text-[13px] text-muted group-hover:text-[#F5A623] transition-colors">Jajanan</span>
        </div>

        {{-- Minuman --}}
        <div class="tt-cat-item flex flex-col items-center gap-3 cursor-pointer select-none group min-w-[60px] flex-shrink-0 transition-all" data-category="minuman">
            <div class="tt-cat-icon w-[64px] h-[64px] rounded-full overflow-hidden border-2 border-transparent group-hover:border-[#F5A623] transition-all bg-[#F3F4F6]">
                <img src="https://images.unsplash.com/photo-1544145945-f90425340c7e?w=150" class="w-full h-full object-cover" alt="Minuman">
            </div>
            <span class="cat-label font-medium text-[13px] text-muted group-hover:text-[#F5A623] transition-colors">Minuman</span>
        </div>

    </div>

    {{-- Label kampus aktif --}}
    <div id="tt-campus-badge" class="hidden mt-4 justify-center items-center gap-2">
        <span class="text-[12px] text-muted">Menampilkan promo di:</span>
        <span id="tt-campus-name" class="text-[12px] font-bold text-dark bg-gray-100 px-3 py-1 rounded-full border border-gray-200"></span>
        <button id="tt-campus-clear" class="text-[11px] text-muted hover:text-red-500 transition-colors ml-1">
            <i class="fas fa-xmark"></i> hapus
        </button>
    </div>

</section>