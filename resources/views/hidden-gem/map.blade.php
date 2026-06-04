<section id="map-section"
    class="px-4 md:px-6 lg:px-8 pt-3 pb-6 max-w-[720px] md:max-w-[1000px] lg:max-w-[1280px] mx-auto w-full scroll-mt-4">

    <div class="flex flex-col items-center mb-4 gap-1">
        <h2 class="text-[19px] md:text-[23px] font-extrabold text-dark text-center">
            Peta Kampus
        </h2>

        <p id="map-subtitle" class="text-[12px] md:text-[14px] font-semibold text-[#F5A623]
              transition-all duration-300 text-center">
            Klik marker untuk info restoran
        </p>
    </div>

    <div class="relative rounded-[20px] overflow-hidden
                shadow-[0_4px_24px_rgba(0,0,0,0.10)] border border-black/[0.06]">

        {{-- Loading overlay --}}
        <div id="map-loading" class="absolute inset-0 bg-cream-bg/80 backdrop-blur-sm
                    flex items-center justify-center z-[999]
                    opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="flex flex-col items-center gap-3">
                <div class="w-9 h-9 rounded-full border-[3px] border-[#F5A623]
                            border-t-transparent animate-spin"></div>
                <span class="text-[12px] text-muted font-semibold">Memuat peta...</span>
            </div>
        </div>

        <div id="leaflet-map" class="w-full h-[240px] md:h-[420px] lg:h-[520px] xl:h-[620px] z-0">
        </div>

        {{-- Tap-to-expand overlay (mobile-friendly) --}}
        <button id="map-expand-btn"
                onclick="openFullscreenMap()"
                class="absolute bottom-3 right-3 z-[100]
                       w-10 h-10 rounded-full
                       bg-white shadow-[0_2px_12px_rgba(0,0,0,0.18)]
                       flex items-center justify-center
                       hover:scale-110 transition-transform duration-200"
                title="Buka Peta Penuh">
            <i class="fas fa-expand-alt text-[14px] text-dark"></i>
        </button>
    </div>
</section>