<section class="px-4 md:px-8 lg:px-0 pb-8 max-w-[720px] mx-auto">

    <h2 class="text-[19px] font-extrabold text-dark text-center mb-4">
        Hidden Gem Hari Ini
    </h2>

    {{-- Loading skeleton --}}
    <div id="cards-loading" class="hidden flex-col gap-3 mb-4">
        <div class="grid grid-cols-2 gap-3">
            @for ($i = 0; $i < 2; $i++)
            <div class="bg-white rounded-[16px] h-[90px] animate-pulse border border-black/[0.04]"></div>
            @endfor
        </div>
        <div class="grid grid-cols-3 gap-3">
            @for ($i = 0; $i < 3; $i++)
            <div class="bg-white rounded-[16px] h-[130px] animate-pulse border border-black/[0.04]"></div>
            @endfor
        </div>
    </div>

    {{-- Cards (diisi JS) --}}
    <div id="resto-cards" class="grid grid-cols-2 gap-3 transition-opacity duration-300">
        {{-- Top 2 --}}
        <div class="col-span-2 grid grid-cols-2 gap-3">
            @foreach ($restaurants->take(2) as $r)
            <div class="bg-white rounded-[16px] overflow-hidden border border-black/[0.05]
                        shadow-[0_2px_8px_rgba(0,0,0,0.08)] cursor-pointer
                        transition-all duration-200 hover:-translate-y-[3px]
                        hover:shadow-[0_8px_24px_rgba(0,0,0,0.10)] active:scale-[0.98]">
                <div class="flex items-stretch">
                    <img src="{{ asset('assets/img/' . $r->image) }}" alt="{{ $r->name }}"
                         class="w-[90px] h-[90px] object-cover flex-shrink-0">
                    <div class="flex-1 flex flex-col justify-between p-3">
                        <p class="text-[11px] font-extrabold text-[#6B4423] leading-[1.35] mb-1">{{ $r->name }}</p>
                        <div class="flex gap-1 flex-wrap mb-1">
                            <span class="bg-[#F5EDE0] text-[#C07A2A] text-[9px] font-bold px-2 py-[2px] rounded-full">{{ $r->category }}</span>
                            <span class="bg-[#F5EDE0] text-[#C07A2A] text-[9px] font-bold px-2 py-[2px] rounded-full">{{ $r->distance }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[#F5A623] text-[11px]">★ {{ $r->rating }}</span>
                            <span class="text-[10px] text-muted">{{ $r->price_range }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bottom 3 --}}
        <div class="col-span-2 grid grid-cols-3 gap-3">
            @foreach ($restaurants->skip(2)->take(3) as $r)
            <div class="flex flex-col bg-white rounded-[16px] overflow-hidden
                        border border-black/[0.05] shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                        cursor-pointer transition-all duration-200
                        hover:-translate-y-[3px] hover:shadow-[0_8px_24px_rgba(0,0,0,0.10)]
                        active:scale-[0.98]">
                <img src="{{ asset('assets/img/' . $r->image) }}" alt="{{ $r->name }}"
                     class="w-full h-[75px] object-cover">
                <div class="p-2 flex flex-col flex-1">
                    <p class="text-[10px] font-extrabold text-[#6B4423] mb-1 leading-[1.35]">{{ $r->name }}</p>
                    <span class="bg-[#F5EDE0] text-[#C07A2A] text-[9px] font-bold px-2 py-[2px] rounded-full w-fit mb-1">{{ $r->category }}</span>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-[#F5A623] text-[10px]">★ {{ $r->rating }}</span>
                        <span class="text-[9px] text-muted">{{ $r->distance }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="text-center mt-6">
        <a href="#">
            <button class="bg-secondary text-white font-extrabold text-[14px]
                           px-10 py-3 rounded-full
                           shadow-[0_4px_16px_rgba(2,177,118,0.35)]
                           transition-all duration-200
                           hover:brightness-110 hover:scale-[1.02] active:scale-[0.98]">
                Lihat Semua Resto
            </button>
        </a>
    </div>

</section>

{{-- Modal Detail Restoran --}}
<div id="resto-detail-modal"
     class="hidden fixed inset-0 z-[1000] flex items-end md:items-center justify-center"
     onclick="if(event.target===this) closeDetail()">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    {{-- Sheet --}}
    <div class="relative bg-white w-full max-w-[480px] rounded-t-[28px] md:rounded-[28px]
                shadow-2xl overflow-hidden z-10
                animate-[slideUp_0.3s_ease-out]">

        <button onclick="closeDetail()"
                class="absolute top-4 right-4 z-10 w-8 h-8 bg-black/10 rounded-full
                       flex items-center justify-center text-dark hover:bg-black/20
                       transition-colors duration-150">
            <i class="fas fa-xmark text-[14px]"></i>
        </button>

        <img id="detail-image" src="" alt=""
             class="w-full h-[200px] object-cover">

        <div class="p-5">
            <h3 id="detail-name"
                class="text-[17px] font-extrabold text-dark mb-1"></h3>
            <div class="flex items-center gap-2 mb-3 flex-wrap">
                <span id="detail-category"
                      class="bg-[#F5EDE0] text-[#C07A2A] text-[11px] font-bold
                             px-3 py-1 rounded-full"></span>
                <span id="detail-rating"
                      class="text-[#F5A623] text-[13px] font-bold"></span>
                <span id="detail-distance"
                      class="text-muted text-[12px]"></span>
            </div>
            <p id="detail-desc"
               class="text-[12px] text-muted leading-[1.7] mb-3"></p>
            <p id="detail-price"
               class="text-[13px] font-bold text-dark mb-4"></p>

            <a id="detail-nav-btn" href="#" target="_blank"
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
    from { transform: translateY(100%); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}
</style>