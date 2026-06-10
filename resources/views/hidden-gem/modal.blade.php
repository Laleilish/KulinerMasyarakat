<div id="resto-modal"
     class="hidden fixed inset-0 z-[2000] flex items-end md:items-center justify-center">

    {{-- Backdrop --}}
    <div id="modal-backdrop" class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"></div>

    {{-- Sheet --}}
    <div id="modal-sheet"
         class="relative bg-white w-full max-w-[480px]
                rounded-t-[28px] md:rounded-[24px]
                shadow-[0_-8px_60px_rgba(0,0,0,0.25)]
                z-10 flex flex-col
                max-h-[92vh] md:max-h-[88vh]
                animate-[slideUp_0.32s_cubic-bezier(.22,1,.36,1)]">

        {{-- Drag handle (mobile) --}}
        <div class="flex justify-center pt-3 pb-1 flex-shrink-0 md:hidden">
            <div class="w-10 h-[4px] rounded-full bg-black/15"></div>
        </div>

        {{-- Close button --}}
        <button id="modal-close"
                class="absolute top-4 right-4 z-20 w-9 h-9 bg-black/10
                       rounded-full flex items-center justify-center
                       hover:bg-black/20 active:scale-90 transition-all duration-150">
            <i class="fas fa-xmark text-[14px] text-dark"></i>
        </button>

        {{-- Scrollable body --}}
        <div class="overflow-y-auto flex-1 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">

            {{-- ── HERO IMAGE ── --}}
            <div class="relative w-full h-[220px] md:h-[240px] flex-shrink-0 overflow-hidden">
                <img id="modal-image" src="" alt=""
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                {{-- Name + meta overlay --}}
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h2 id="modal-name"
                        class="text-white text-[20px] font-extrabold leading-tight mb-2 drop-shadow-sm"></h2>
                    <div class="flex items-center gap-3 flex-wrap">
                        {{-- Rating --}}
                        <span id="modal-rating"
                              class="flex items-center gap-1 bg-black/30 backdrop-blur-sm
                                     text-[#FFD700] text-[12px] font-bold
                                     px-3 py-[5px] rounded-full"></span>
                        {{-- Distance --}}
                        <span id="modal-distance"
                              class="text-white/80 text-[12px] font-medium"></span>
                        {{-- Navigasi btn --}}
                        <button id="modal-nav-btn"
                                class="ml-auto flex items-center gap-2 bg-[#02b176] text-white
                                       px-4 py-[7px] rounded-full text-[12px] font-extrabold
                                       shadow-[0_4px_16px_rgba(2,177,118,0.5)]
                                       hover:brightness-110 active:scale-95 transition-all duration-150">
                            <i class="fas fa-diamond-turn-right text-[11px]"></i>
                            Navigasi
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── BODY ── --}}
            <div class="px-5 pt-5 pb-6 space-y-5">

                {{-- Category chip + Detail btn --}}
                <div class="flex items-center gap-2">
                    <span id="modal-category"
                          class="bg-[#F5EDE0] text-[#C07A2A] text-[11px] font-bold
                                 px-3 py-1 rounded-full"></span>
                    <span id="modal-price"
                          class="bg-black/[0.05] text-dark text-[11px] font-bold
                                 px-3 py-1 rounded-full"></span>
                    <a id="modal-detail-btn" href="#"
                       class="ml-auto flex items-center gap-2 bg-[#F5A623] text-white
                              px-4 py-[7px] rounded-full text-[12px] font-extrabold
                              shadow-[0_4px_16px_rgba(245,166,35,0.4)]
                              hover:brightness-110 active:scale-95 transition-all duration-150">
                        <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                        Lihat Detail
                    </a>
                </div>

                <hr class="border-black/[0.06]">

                {{-- About --}}
                <div>
                    <h3 class="text-[15px] font-extrabold text-dark mb-2">About</h3>
                    <p id="modal-desc" class="text-[13px] text-muted leading-[1.75]"></p>
                </div>

                <hr class="border-black/[0.06]">

                {{-- Info Detail --}}
                <div>
                    <h3 class="text-[15px] font-extrabold text-dark mb-3">Info Detail</h3>
                    <div class="space-y-3">

                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-[12px] bg-[#F5EDE0] flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-location-dot text-[#C07A2A] text-[14px]"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-muted font-bold uppercase tracking-wider mb-[2px]">Alamat</p>
                                <p id="modal-address" class="text-[13px] text-dark font-medium leading-[1.55]"></p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-[12px] bg-[#F5EDE0] flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-[#C07A2A] text-[14px]"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-muted font-bold uppercase tracking-wider mb-[2px]">Jam Buka</p>
                                <p id="modal-hours" class="text-[13px] text-dark font-medium"></p>
                            </div>
                        </div>

                        <div id="modal-gmaps-wrap" class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-[12px] bg-[#F5EDE0] flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map text-[#C07A2A] text-[14px]"></i>
                            </div>
                            <div class="flex flex-col justify-center">
                                <p class="text-[10px] text-muted font-bold uppercase tracking-wider mb-[2px]">Google Maps</p>
                                <a id="modal-gmaps" href="#" target="_blank" rel="noopener"
                                   class="text-[13px] text-[#02b176] font-semibold hover:underline">
                                    Buka di Google Maps →
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <hr class="border-black/[0.06]">

                {{-- Fasilitas --}}
                <div>
                    <h3 class="text-[15px] font-extrabold text-dark mb-3">Fasilitas</h3>
                    <div id="modal-facilities" class="flex flex-wrap gap-2"></div>
                </div>

                <hr class="border-black/[0.06]">

                {{-- Mini Map --}}
                <div>
                    <h3 class="text-[15px] font-extrabold text-dark mb-3">Lokasi</h3>
                    <div id="modal-mini-map"
                         class="w-full h-[160px] rounded-[16px] overflow-hidden
                                border border-black/[0.07]
                                shadow-[0_2px_12px_rgba(0,0,0,0.08)]">
                    </div>
                </div>

                <hr class="border-black/[0.06]">

                {{-- Ulasan --}}
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-[15px] font-extrabold text-dark">Ulasan</h3>
                        <a id="modal-review-btn" href="#"
                           class="flex items-center gap-2 bg-[#02b176] text-white
                                  px-4 py-[7px] rounded-full text-[12px] font-extrabold
                                  hover:brightness-110 active:scale-95 transition-all duration-150">
                            <i class="fas fa-pen text-[10px]"></i>
                            Tulis Ulasan
                        </a>
                    </div>
                    <div id="modal-reviews-list" class="space-y-4">
                        {{-- diisi JS --}}
                    </div>
                    <div id="modal-reviews-empty" class="hidden text-center py-6">
                        <i class="fas fa-comment-slash text-black/20 text-[28px] mb-2 block"></i>
                        <p class="text-[12px] text-muted">Belum ada ulasan untuk restoran ini.</p>
                    </div>
                    <div id="modal-reviews-loading" class="hidden flex justify-center py-4">
                        <div class="w-6 h-6 rounded-full border-[2.5px] border-[#F5A623] border-t-transparent animate-spin"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>