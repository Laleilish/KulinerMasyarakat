{{-- FULLSCREEN MAP MODAL--}}
<div id="fs-map-modal"
     class="hidden fixed inset-0 z-[3000] bg-white flex flex-col"
     style="padding-top:env(safe-area-inset-top)">

    {{-- Map + Side Panel container --}}
    <div class="flex-1 relative flex flex-row w-full h-full" style="overflow: clip;">

        {{-- ── PETA ── --}}
        <div id="fs-leaflet-map" class="flex-1 h-full z-0"></div>

        {{-- ── FLOATING UI ELEMENTS (Absolute on top of map) ── --}}
        <div class="absolute top-4 left-0 right-0 z-[1000] pointer-events-none flex flex-col items-center">
            
            {{-- Wrapper relative --}}
            <div class="relative w-[calc(100%-2rem)] md:w-[calc(100%-4rem)] pointer-events-auto">
                {{-- Header (Floating Search-like Bar) --}}
                <div class="bg-white rounded-full shadow-[0_4px_24px_rgba(0,0,0,0.12)] border border-black/[0.06] flex items-center px-3 py-2 gap-2">
                    <button onclick="closeFullscreenMap()"
                            class="w-8 h-8 rounded-full bg-transparent flex items-center justify-center hover:bg-black/5 active:scale-90 transition-all duration-150 flex-shrink-0">
                        <i class="fas fa-arrow-left text-[15px] text-dark"></i>
                    </button>
                    
                    {{-- Input --}}
                    <div class="flex-1 flex flex-col justify-center min-w-0">
                        <label id="fs-loc-label" class="text-[9px] text-muted font-semibold tracking-wider leading-none mb-[3px] transition-all duration-200">
                            Lokasi / Kampus
                        </label>
                        <input id="fs-loc-input" type="text" placeholder="Cari lokasi atau kampus..." autocomplete="off"
                               class="w-full border-none outline-none bg-transparent p-0 h-4
                                      text-[13px] font-semibold text-dark
                                      placeholder:text-muted/50 placeholder:font-normal focus:ring-0
                                      transition-all duration-200">
                    </div>

                    {{-- Tombol clear --}}
                    <button id="fs-loc-clear" class="hidden flex-shrink-0 w-7 h-7 rounded-full
                                   bg-black/[0.06] flex items-center justify-center
                                   hover:bg-black/10 transition-colors duration-150">
                        <i class="fas fa-xmark text-[12px] text-muted"></i>
                    </button>

                    {{-- GPS button --}}
                    <button id="fs-loc-gps-btn" title="Gunakan lokasi saya" class="flex-shrink-0 w-8 h-8 rounded-full
                                   bg-[#F5A623]/10 flex items-center justify-center
                                   hover:bg-[#F5A623]/20 transition-colors duration-150">
                        <i class="fas fa-crosshairs text-[#F5A623] text-[14px]"></i>
                    </button>
                </div>

                {{-- Dropdown autocomplete --}}
                <div id="fs-loc-dropdown" class="hidden absolute top-[calc(100%+6px)] left-0 right-0
                            bg-white border border-black/[0.08] rounded-2xl
                            shadow-[0_8px_32px_rgba(0,0,0,0.12)] z-[1500]
                            overflow-hidden">

                    {{-- Section: Kampus --}}
                    <div id="fs-dropdown-campus-section">
                        <div class="px-4 py-2 text-[10px] font-bold text-muted uppercase tracking-wider
                                    bg-black/[0.02] border-b border-black/[0.04]">
                            Kampus
                        </div>
                        <div id="fs-dropdown-campus-list"></div>
                    </div>

                    {{-- Section: Hasil pencarian --}}
                    <div id="fs-dropdown-search-section" class="hidden">
                        <div class="px-4 py-2 text-[10px] font-bold text-muted uppercase tracking-wider
                                    bg-black/[0.02] border-b border-black/[0.04]">
                            Hasil Pencarian
                        </div>
                        <div id="fs-dropdown-search-list"></div>
                    </div>

                    {{-- Loading state --}}
                    <div id="fs-dropdown-loading" class="hidden flex items-center gap-3 px-4 py-3">
                        <div class="w-4 h-4 rounded-full border-2 border-[#F5A623]
                                    border-t-transparent animate-spin flex-shrink-0"></div>
                        <span class="text-[12px] text-muted">Mencari lokasi...</span>
                    </div>

                    {{-- Empty state --}}
                    <div id="fs-dropdown-empty" class="hidden px-4 py-4 text-center">
                        <i class="fas fa-map-pin text-muted/40 text-[20px] mb-2 block"></i>
                        <p class="text-[12px] text-muted">Lokasi tidak ditemukan</p>
                    </div>
                </div>
            </div>

            {{-- Category filter chips (Floating below Header) --}}
            <div id="fs-filter-bar"
                 class="w-[calc(100%-1rem)] md:w-[calc(100%-4rem)] mt-3 pointer-events-auto flex gap-2 px-2 overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                <button class="fs-chip flex-shrink-0 px-4 py-2 rounded-full text-[12px]
                               font-bold bg-[#F5A623] text-white shadow-sm border border-transparent transition-all duration-150"
                        data-filter="all">All</button>
            </div>
        </div>

        {{-- GPS floating button --}}
        <button onclick="fsDetectGPS()"
                class="absolute bottom-5 right-4 z-[400]
                       w-[48px] h-[48px] rounded-full
                       bg-[#F5A623] shadow-[0_4px_20px_rgba(245,166,35,0.4)]
                       flex items-center justify-center
                       hover:scale-110 active:scale-95 transition-transform duration-150">
            <i class="fas fa-crosshairs text-white text-[18px]"></i>

        </button>
            <div id="fs-bottom-sheet"
             class="hidden z-[500] bg-[#FDF8F0] overflow-y-auto
                    [scrollbar-width:none] [&::-webkit-scrollbar]:hidden
                    {{-- Mobile: absolute bottom sheet --}}
                    absolute bottom-0 left-0 right-0
                    rounded-t-[28px]
                    shadow-[0_-8px_40px_rgba(0,0,0,0.18)]
                    {{-- Desktop: absolute left panel, full height --}}
                    md:bottom-auto md:left-0 md:right-auto md:top-0
                    md:rounded-none
                    md:shadow-[4px_0_32px_rgba(0,0,0,0.12)]
                    md:w-[380px] md:h-full
                    md:border-r md:border-black/[0.06]"
             style="">

            {{-- Mobile drag handle --}}
            <div class="flex justify-center pt-3 pb-1 flex-shrink-0 md:hidden">
                <div class="w-10 h-[4px] rounded-full bg-black/15"></div>
            </div>

            {{-- Desktop top bar --}}
            <div class="hidden md:flex items-center justify-between
                        px-4 py-3 border-b border-black/[0.06] flex-shrink-0
                        sticky top-0 bg-[#FDF8F0] z-10">
                <p class="text-[11px] font-bold text-muted uppercase tracking-wider">Info Tempat</p>
                <button onclick="fsCloseBottomSheet()"
                        class="w-8 h-8 bg-black/[0.05] rounded-full flex items-center justify-center
                                hover:bg-black/10 transition-colors">
                    <i class="fas fa-xmark text-[13px] text-dark"></i>
                </button>
            </div>

            {{-- Close button (mobile) --}}
            <button onclick="fsCloseBottomSheet()"
                    class="md:hidden absolute top-4 right-4 w-8 h-8 bg-black/30 backdrop-blur-sm
                           rounded-full flex items-center justify-center
                           hover:bg-black/50 transition-colors z-10 text-white">
                <i class="fas fa-xmark text-[13px]"></i>
            </button>

            {{-- Hero image --}}
            <div class="relative w-full h-[220px] md:h-[250px] overflow-hidden flex-shrink-0">
                <img id="fs-bs-image" src="" alt=""
                     class="w-full h-full object-cover"
                     onerror="this.src='/assets/img/resto/default.png'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-6 left-4 right-4">
                    <h2 id="fs-bs-name" class="text-3xl font-extrabold text-white mb-3 drop-shadow-md leading-tight"></h2>
                    <div class="flex items-center text-xs text-gray-200 gap-2 flex-wrap">
                        <div class="flex items-center gap-1 bg-white/20 px-3 py-1 rounded-full backdrop-blur-md text-white font-semibold border border-white/10">
                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span id="fs-bs-rating"></span>
                        </div>
                        <div class="w-1 h-1 rounded-full bg-gray-400"></div>
                        <span id="fs-bs-category" class="font-medium drop-shadow text-white"></span>
                        <div class="w-1 h-1 rounded-full bg-gray-400"></div>
                        <span id="fs-bs-distance" class="text-teal-400 font-bold drop-shadow"></span>
                    </div>
                </div>
            </div>

            {{-- Content body --}}
            <div class="px-5 py-5 space-y-5">

                {{-- Action Buttons --}}
                <div class="flex gap-3">
                    <a id="fs-bs-detail-btn" href="#"
                        class="flex-1 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-800 text-sm font-bold rounded-full flex items-center justify-center gap-2 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Detail
                    </a>
                    <button id="fs-bs-nav-btn"
                        class="flex-1 py-2.5 bg-[#00A896] hover:bg-[#028c7d] text-white text-sm font-bold rounded-full flex items-center justify-center gap-2 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Navigasi
                    </button>
                </div>

                {{-- About --}}
                <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">About</h3>
                    <p id="fs-bs-desc" class="text-gray-600 text-[15px] leading-relaxed"></p>
                </div>

                {{-- Info Detail --}}
                <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 text-base">Info Detail</h3>
                    
                    <div class="flex gap-4 mb-5">
                        <div class="mt-0.5 text-teal-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-800 mb-0.5">Alamat</p>
                            <p id="fs-bs-address" class="text-sm text-gray-500 leading-snug"></p>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-5">
                        <div class="mt-0.5 text-teal-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-800 mb-0.5">Jam Buka</p>
                            <p id="fs-bs-hours" class="text-sm text-gray-500"></p>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-5">
                        <div class="mt-0.5 text-teal-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-800 mb-0.5">Kisaran Harga</p>
                            <p id="fs-bs-price" class="text-sm text-gray-500"></p>
                        </div>
                    </div>

                </div>

                {{-- Ulasan Section --}}
                <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Ulasan</h3>
                    
                    <div id="fs-bs-reviews-loading" class="hidden text-center py-6">
                        <i class="fas fa-spinner fa-spin text-teal-600 text-2xl"></i>
                    </div>

                    <div id="fs-bs-reviews-empty" class="hidden bg-white rounded-3xl border border-gray-100 p-8 text-center shadow-sm">
                        <p class="text-gray-500 text-sm">Belum ada ulasan. Jadilah yang pertama!</p>
                    </div>

                    <div id="fs-bs-reviews-list" class="flex flex-col gap-4">
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>