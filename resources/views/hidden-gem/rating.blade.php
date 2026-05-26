<section class="px-4 md:px-8 lg:px-0 pb-8 max-w-[720px] mx-auto">

    <h2 class="text-[19px] font-extrabold text-dark text-center mb-4">
        Hidden Gem Hari Ini
    </h2>

    {{-- Skeleton loading --}}
    <div id="cards-loading" class="hidden flex-col gap-3 mb-4">
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-white rounded-[16px] h-[90px] animate-pulse"></div>
            <div class="bg-white rounded-[16px] h-[90px] animate-pulse"></div>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div class="bg-white rounded-[16px] h-[130px] animate-pulse"></div>
            <div class="bg-white rounded-[16px] h-[130px] animate-pulse"></div>
            <div class="bg-white rounded-[16px] h-[130px] animate-pulse"></div>
        </div>
    </div>

    {{-- Cards container (diisi JS) --}}
    <div id="resto-cards" class="transition-opacity duration-300">
        <p class="text-center text-muted text-[13px] py-8">
            Mendeteksi lokasi...
        </p>
    </div>

    <div class="text-center mt-6">
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

{{-- Modal Detail Restoran --}}
<div id="resto-modal"
     class="hidden fixed inset-0 z-[1000] flex items-end md:items-center justify-center">
    <div id="modal-backdrop"
         class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    <div class="relative bg-white w-full max-w-[480px]
                rounded-t-[28px] md:rounded-[28px] shadow-2xl overflow-hidden z-10
                animate-[slideUp_0.3s_ease-out]">

        <button id="modal-close"
                class="absolute top-4 right-4 z-10 w-8 h-8 bg-black/10
                       rounded-full flex items-center justify-center
                       text-dark hover:bg-black/20 transition-colors duration-150">
            <i class="fas fa-xmark text-[14px]"></i>
        </button>

        <img id="modal-image" src="" alt=""
             class="w-full h-[200px] object-cover">

        <div class="p-5">
            <h3 id="modal-name"
                class="text-[17px] font-extrabold text-dark mb-1"></h3>
            <div class="flex items-center gap-2 mb-3 flex-wrap">
                <span id="modal-category"
                      class="bg-[#F5EDE0] text-[#C07A2A] text-[11px] font-bold
                             px-3 py-1 rounded-full"></span>
                <span id="modal-rating"
                      class="text-[#F5A623] text-[13px] font-bold"></span>
                <span id="modal-distance"
                      class="text-muted text-[12px]"></span>
            </div>
            <p id="modal-desc"
               class="text-[12px] text-muted leading-[1.7] mb-3"></p>
            <p id="modal-price"
               class="text-[13px] font-bold text-dark mb-4"></p>

            <a id="modal-nav-btn" href="#" target="_blank"
               class="flex items-center justify-center gap-2
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
    from { transform: translateY(60px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}
</style>