<section class="px-4 md:px-6 lg:px-8 pb-8
                 max-w-[720px] md:max-w-[1000px] lg:max-w-[1280px]
                 mx-auto w-full">

    <h2 class="text-[19px] md:text-[23px]
           font-extrabold text-dark text-center mb-4">
        Hidden Gem Hari Ini
    </h2>

    {{-- Featured card --}}
    <div id="featured-card" class="hidden mb-4">
        <div class="bg-gradient-to-br from-[#D08700] to-[#EFB100]
            rounded-[20px]
            p-5 md:p-6
            min-h-[170px] md:min-h-[220px]
            flex items-center gap-4
            cursor-pointer
            transition-all duration-200 hover:-translate-y-[2px]
            hover:shadow-[0_8px_24px_rgba(245,166,35,0.3)]" transition-all duration-200 hover:-translate-y-[2px]
            hover:shadow-[0_8px_24px_rgba(245,166,35,0.3)]" id="featured-card-inner">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-white/25 text-white text-[10px] font-bold
                                 px-2 py-[3px] rounded-full flex items-center gap-1">
                        <i class="fas fa-star text-[9px]"></i>
                        Rekomendasi Hari Ini
                    </span>
                </div>
                <p id="featured-name" class="text-[16px] md:text-[18px] font-extrabold text-white leading-[1.3] mb-2">
                </p>
                <p id="featured-desc" class="text-[11px] md:text-[14px] text-white/85 leading-[1.7] mb-4 line-clamp-3"></p>
                <div class="flex items-center gap-2 flex-wrap">
                    <span id="featured-rating" class="flex items-center gap-1 bg-white/20 text-white
                                 text-[10px] font-bold px-2 py-[3px] rounded-full">
                    </span>
                    <span id="featured-dist" class="flex items-center gap-1 bg-white/20 text-white
                                 text-[10px] font-bold px-2 py-[3px] rounded-full">
                    </span>
                    <span id="featured-price" class="flex items-center gap-1 bg-white/20 text-white
                                 text-[10px] font-bold px-2 py-[3px] rounded-full">
                    </span>
                </div>
            </div>
            <img id="featured-img" src="" alt=""
                class="w-[110px] h-[140px] md:w-[180px] md:h-[200px] rounded-[16px] object-cover flex-shrink-0 border-[2.5px] border-white/30">
        </div>
    </div>

    {{-- Section title --}}
    <div class="flex items-center justify-center mb-3">
        <h3 class="text-center text-[15px] md:text-[23px]
           font-extrabold text-dark mb-3">
            Rating Tertinggi Dari Pengguna Lain
        </h3>
    </div>

    {{-- Skeleton loading --}}
    <div id="cards-loading" class="hidden space-y-3">
        <div class="grid grid-cols-4 gap-2">
            <div class="bg-white rounded-[14px] h-[150px] animate-pulse"></div>
            <div class="bg-white rounded-[14px] h-[150px] animate-pulse"></div>
            <div class="bg-white rounded-[14px] h-[150px] animate-pulse"></div>
            <div class="bg-white rounded-[14px] h-[150px] animate-pulse"></div>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div class="bg-white rounded-[14px] h-[85px] animate-pulse"></div>
            <div class="bg-white rounded-[14px] h-[85px] animate-pulse"></div>
        </div>
    </div>

    {{-- Cards (diisi JS) --}}
    <div id="resto-cards" class="transition-opacity duration-300"></div>

    <div class="text-center mt-6">
        <button id="btn-lihat-semua" class="bg-secondary text-white font-extrabold text-[14px]
                       px-10 py-3 rounded-full
                       shadow-[0_4px_16px_rgba(2,177,118,0.35)]
                       transition-all duration-200
                       hover:brightness-110 hover:scale-[1.02] active:scale-[0.98]">
            Lihat Semua Resto
        </button>
    </div>
</section>

{{-- Modal Detail --}}
<div id="resto-modal" class="hidden fixed inset-0 z-[1000] flex items-end md:items-center justify-center">
    <div id="modal-backdrop" class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="relative bg-white w-full max-w-[480px]
                rounded-t-[28px] md:rounded-[28px] shadow-2xl overflow-hidden z-10
                animate-[slideUp_0.3s_ease-out]">
        <button id="modal-close" class="absolute top-4 right-4 z-10 w-8 h-8 bg-black/10 rounded-full
                       flex items-center justify-center hover:bg-black/20
                       transition-colors duration-150">
            <i class="fas fa-xmark text-[14px]"></i>
        </button>
        <img id="modal-image" src="" alt="" class="w-full h-[200px] object-cover">
        <div class="p-5">
            <h3 id="modal-name" class="text-[17px] font-extrabold text-dark mb-1"></h3>
            <div class="flex items-center gap-2 mb-3 flex-wrap">
                <span id="modal-category" class="bg-[#F5EDE0] text-[#C07A2A] text-[11px] font-bold
                             px-3 py-1 rounded-full"></span>
                <span id="modal-rating" class="text-[#F5A623] text-[13px] font-bold"></span>
                <span id="modal-distance" class="text-muted text-[12px]"></span>
            </div>
            <p id="modal-desc" class="text-[12px] text-muted leading-[1.7] mb-3"></p>
            <p id="modal-price" class="text-[13px] font-bold text-dark mb-4"></p>
            <a id="modal-nav-btn" href="#" target="_blank" class="flex items-center justify-center gap-2
                      bg-secondary text-white font-extrabold text-[14px]
                      py-3 rounded-full w-full
                      shadow-[0_4px_16px_rgba(2,177,118,0.35)]
                      transition-all duration-200 hover:brightness-110">
                <i class="fas fa-diamond-turn-right"></i>
                Navigasi ke Sini
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from {
            transform: translateY(60px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>