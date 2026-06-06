<section class="pb-8 w-full max-w-[1200px] mx-auto overflow-hidden">

    {{-- ════════════════════════════════════════
         HIDDEN GEM HARI INI — Featured Carousel
    ═════════════════════════════════════════ --}}
    <div class="px-4 md:px-8 lg:px-0 mb-8">

        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-[20px] font-extrabold text-dark leading-tight">
                    Hidden Gem Hari Ini
                </h2>
                <p class="text-[12px] text-muted mt-[2px]">
                    Rekomendasi terbaik pilihan pengguna
                </p>
            </div>
            {{-- Tombol scroll desktop --}}
            <div class="hidden md:flex items-center gap-2">
                <button id="carousel-prev"
                        class="w-8 h-8 rounded-full bg-white border border-black/[0.08]
                               flex items-center justify-center shadow-[var(--shadow-card)]
                               hover:bg-[#FFF8EE] hover:border-[#F5A623]/30
                               transition-all duration-200 active:scale-95 disabled:opacity-30">
                    <i class="fas fa-chevron-left text-[11px] text-dark"></i>
                </button>
                <button id="carousel-next"
                        class="w-8 h-8 rounded-full bg-white border border-black/[0.08]
                               flex items-center justify-center shadow-[var(--shadow-card)]
                               hover:bg-[#FFF8EE] hover:border-[#F5A623]/30
                               transition-all duration-200 active:scale-95 disabled:opacity-30">
                    <i class="fas fa-chevron-right text-[11px] text-dark"></i>
                </button>
            </div>
        </div>

        @if($featuredRestaurants->isEmpty())
        <div class="bg-white rounded-[20px] border border-black/[0.06] p-8 text-center">
            <i class="fas fa-map-pin text-muted/30 text-[32px] mb-3 block"></i>
            <p class="text-[13px] text-muted">Belum ada restoran unggulan.</p>
        </div>
        @else

        {{-- Carousel track --}}
        <div id="featured-carousel"
             class="flex gap-3 overflow-x-auto snap-x snap-mandatory scroll-smooth
                    [scrollbar-width:none] [&::-webkit-scrollbar]:hidden pb-1">

            @foreach ($featuredRestaurants as $r)
            <div class="featured-slide flex-shrink-0 snap-start w-[calc(100vw-32px)] md:w-[680px] lg:w-[760px] group cursor-pointer"
                 data-resto="{{ json_encode($r) }}">

                {{-- Card --}}
                <div class="bg-gradient-to-br from-[#D08700] to-[#EFB100]
                            rounded-[22px] overflow-hidden
                            transition-all duration-300
                            group-hover:-translate-y-[4px]
                            group-hover:shadow-[0_16px_40px_rgba(208,135,0,0.4)]
                            shadow-[0_4px_16px_rgba(208,135,0,0.25)]">

                    {{-- Image section --}}
                    <div class="relative w-full h-[160px] md:h-[180px] overflow-hidden">
                        <img src="{{ $r['image'] }}"
                             alt="{{ $r['name'] }}"
                             class="w-full h-full object-cover
                                    transition-transform duration-500
                                    group-hover:scale-105">

                        {{-- Overlay gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t
                                    from-black/40 via-transparent to-transparent">
                        </div>

                        {{-- Badge di atas gambar --}}
                        <div class="absolute top-3 left-3 flex items-center gap-2">
                            <span class="bg-white/90 text-[#C07A2A] text-[10px] font-extrabold
                                         px-2 py-1 rounded-full flex items-center gap-1
                                         shadow-[0_2px_8px_rgba(0,0,0,0.15)]">
                                <i class="fas fa-star text-[9px] text-[#F5A623]"></i>
                                Rekomendasi
                            </span>
                            <span class="bg-black/20 text-white text-[10px] font-bold
                                         px-2 py-1 rounded-full backdrop-blur-sm">
                                #{{ $loop->iteration }}
                            </span>
                        </div>

                        {{-- Rating di pojok kanan atas --}}
                        <div class="absolute top-3 right-3">
                            <span class="bg-black/25 text-white text-[11px] font-extrabold
                                         px-2 py-1 rounded-full backdrop-blur-sm
                                         flex items-center gap-1">
                                <i class="fas fa-star text-[#FFD700] text-[9px]"></i>
                                {{ $r['rating'] !== null ? number_format($r['rating'], 1) : '—' }}
                            </span>
                        </div>
                    </div>

                    {{-- Info section --}}
                    <div class="p-4">
                        <h3 class="text-[15px] font-extrabold text-white
                                   leading-[1.3] mb-1 line-clamp-1">
                            {{ $r['name'] }}
                        </h3>
                        <p class="text-[11px] text-white/80 leading-[1.6]
                                  line-clamp-2 mb-3">
                            {{ $r['description'] }}
                        </p>

                        {{-- Meta chips --}}
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="flex items-center gap-1 bg-white/20 text-white
                                         text-[10px] font-bold px-2 py-[3px] rounded-full">
                                <i class="fas fa-location-dot text-[9px]"></i>
                                {{ $r['distance'] ?? '—' }}
                            </span>
                            <span class="flex items-center gap-1 bg-white/20 text-white
                                         text-[10px] font-bold px-2 py-[3px] rounded-full">
                                <i class="fas fa-tag text-[9px]"></i>
                                {{ $r['price_range'] ?? '—' }}
                            </span>
                            <span class="bg-white/20 text-white text-[10px] font-bold
                                         px-2 py-[3px] rounded-full ml-auto">
                                {{ $r['category'] }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach

        </div>

        {{-- Dots indicator --}}
        <div id="carousel-dots" class="flex items-center justify-center gap-[6px] mt-3">
            @foreach ($featuredRestaurants as $r)
            <button class="carousel-dot transition-all duration-300
                           {{ $loop->first
                               ? 'w-5 h-[5px] bg-[#F5A623] rounded-full'
                               : 'w-[5px] h-[5px] bg-black/15 rounded-full' }}"
                    data-index="{{ $loop->index }}">
            </button>
            @endforeach
        </div>

        @endif
    </div>

    {{-- ════════════════════════════════════════
         RATING TERTINGGI — Grid semua restoran
    ═════════════════════════════════════════ --}}
    <div class="px-4 md:px-8 lg:px-0">

        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-[18px] font-extrabold text-dark leading-tight">
                    Rating Tertinggi Dari Pengguna Lain
                </h2>
                <p class="text-[12px] text-muted mt-[2px]">
                    {{ $topRestaurants->count() }} restoran tersedia
                </p>
            </div>
        </div>

        {{-- Skeleton loading (diisi JS) --}}
        <div id="cards-loading" class="hidden">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @for ($i = 0; $i < 8; $i++)
                <div class="bg-white rounded-[16px] overflow-hidden
                            border border-black/[0.04] animate-pulse">
                    <div class="w-full h-[130px] bg-black/[0.06]"></div>
                    <div class="p-3 space-y-2">
                        <div class="h-3 bg-black/[0.06] rounded-full w-3/4"></div>
                        <div class="h-2 bg-black/[0.04] rounded-full w-1/2"></div>
                        <div class="h-2 bg-black/[0.04] rounded-full w-2/3"></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        {{-- Grid static dari server (fallback sebelum JS) --}}
        <div id="resto-cards" class="transition-opacity duration-300">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @forelse ($topRestaurants as $r)
                <div class="top-resto-card bg-white rounded-[16px] overflow-hidden
                            border border-black/[0.05]
                            shadow-[var(--shadow-card)]
                            cursor-pointer
                            transition-all duration-200
                            hover:-translate-y-[3px]
                            hover:shadow-[var(--shadow-card-hover)]
                            active:scale-[0.98]"
                     data-resto="{{ json_encode($r) }}">

                    {{-- Image --}}
                    <div class="relative w-full h-[130px] overflow-hidden">
                        <img src="{{ $r['image'] }}"
                             alt="{{ $r['name'] }}"
                             class="w-full h-full object-cover
                                    transition-transform duration-300
                                    group-hover:scale-105">

                        {{-- Rating badge --}}
                        <div class="absolute top-2 right-2">
                            <span class="flex items-center gap-[3px]
                                         bg-black/30 text-white text-[10px] font-bold
                                         px-[7px] py-[3px] rounded-full backdrop-blur-sm">
                                <i class="fas fa-star text-[#FFD700] text-[9px]"></i>
                                {{ $r['rating'] !== null ? number_format($r['rating'], 1) : '—' }}
                            </span>
                        </div>

                        {{-- Featured badge --}}
                        @if($r['is_featured'])
                        <div class="absolute top-2 left-2">
                            <span class="bg-[#F5A623] text-white text-[9px] font-bold
                                         px-[6px] py-[2px] rounded-full">
                                Unggulan
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="p-3">
                        <h3 class="text-[12px] font-extrabold text-dark
                                   leading-[1.4] mb-1 line-clamp-2">
                            {{ $r['name'] }}
                        </h3>
                        <p class="text-[11px] text-muted mb-2 truncate">
                            {{ $r['category'] }}
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] text-secondary font-bold
                                         flex items-center gap-[3px]">
                                <i class="fas fa-location-dot text-[10px]"></i>
                                {{ $r['distance'] ?? '—' }}
                            </span>
                            <span class="text-[10px] text-muted">
                                {{ $r['price_range'] ?? '—' }}
                            </span>
                        </div>
                    </div>

                </div>
                @empty
                <div class="col-span-2 md:col-span-3 lg:col-span-4
                            text-center py-8 text-muted text-[13px]">
                    Belum ada restoran tersedia.
                </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Lihat Semua --}}
    <div class="text-center mt-8 px-4">
        <button id="btn-lihat-semua"
                class="bg-secondary text-white font-extrabold text-[14px]
                       px-10 py-3 rounded-full
                       shadow-[0_4px_16px_rgba(2,177,118,0.35)]
                       transition-all duration-200
                       hover:brightness-110 hover:scale-[1.02] active:scale-[0.98]">
            Lihat Semua Resto
        </button>
    </div>
</section>

{{-- ═══════════════════════════════════════
     MODAL DETAIL RESTORAN (Bottom Sheet)
═══════════════════════════════════════ --}}
@include('hidden-gem.modal')

<style>
    @keyframes slideUp {
        from { transform: translateY(72px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }
</style>