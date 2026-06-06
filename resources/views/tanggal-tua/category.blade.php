<section class="px-5 mt-4 mb-6">
    
    <h2 class="text-[16px] font-bold text-dark mb-3">
        Semua Makanan Hanya Dibawah 15rb
    </h2>

    {{-- Filter Chips --}}
    <div class="flex gap-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden mb-5">
        
        {{-- Icon Filter Box --}}
        <button class="flex items-center justify-center w-8 h-8 rounded-md border border-[#F5A623] text-[#F5A623] flex-shrink-0 bg-transparent">
            <i class="fas fa-sliders-h text-[13px]"></i>
        </button>

        {{-- Chips --}}
        <button class="px-3 py-1 rounded-full border border-[#F5A623] text-[#F5A623] text-[12px] font-bold flex-shrink-0 bg-transparent">
            Dibawah 10k
        </button>
        <button class="px-3 py-1 rounded-full border border-[#F5A623] text-[#F5A623] text-[12px] font-bold flex-shrink-0 bg-transparent">
            Terdekat
        </button>
        <button class="px-3 py-1 rounded-full border border-[#F5A623] text-[#F5A623] text-[12px] font-bold flex-shrink-0 bg-transparent">
            Populer
        </button>
        <button class="px-3 py-1 rounded-full border border-[#F5A623] text-[#F5A623] text-[12px] font-bold flex-shrink-0 bg-transparent">
            Penilaian
        </button>
        
    </div>

    {{-- Circle Categories --}}
    <div class="flex gap-4 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden px-1">

        <div class="flex flex-col items-center gap-1 cursor-pointer">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-[#F5A623] shadow-sm flex items-center justify-center p-1 bg-white">
                <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=150" class="w-full h-full object-cover rounded-full">
            </div>
            <span class="font-extrabold text-[10px] text-dark">Nasi</span>
        </div>

        <div class="flex flex-col items-center gap-1 cursor-pointer">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-[#F5A623] shadow-sm flex items-center justify-center p-1 bg-white">
                <img src="https://images.unsplash.com/photo-1585032226651-759b368d7246?w=150" class="w-full h-full object-cover rounded-full">
            </div>
            <span class="font-extrabold text-[10px] text-dark">Mie</span>
        </div>

        <div class="flex flex-col items-center gap-1 cursor-pointer">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-[#F5A623] shadow-sm flex items-center justify-center p-1 bg-white">
                <img src="https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=150" class="w-full h-full object-cover rounded-full">
            </div>
            <span class="font-extrabold text-[10px] text-dark">Jajanan</span>
        </div>

        <div class="flex flex-col items-center gap-1 cursor-pointer">
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-[#F5A623] shadow-sm flex items-center justify-center p-1 bg-white">
                <img src="https://images.unsplash.com/photo-1563805042-7684c8a9e9cb?w=150" class="w-full h-full object-cover rounded-full">
            </div>
            <span class="font-extrabold text-[10px] text-dark">Makanan Manis</span>
        </div>

    </div>

</section>