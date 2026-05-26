<section id="map-section"
         class="px-4 md:px-8 lg:px-0 pt-3 pb-6 max-w-[720px] mx-auto scroll-mt-4">

    <div class="flex flex-col items-center mb-4 gap-1">
        <h2 class="text-[19px] font-extrabold text-dark">Peta Kampus</h2>
        <p id="map-subtitle"
           class="text-[12px] font-semibold text-[#F5A623] transition-all duration-300">
            Klik marker untuk info restoran
        </p>
    </div>

    <div class="relative rounded-[20px] overflow-hidden
                shadow-[0_4px_24px_rgba(0,0,0,0.10)] border border-black/[0.06]">

        {{-- Loading overlay --}}
        <div id="map-loading"
             class="absolute inset-0 bg-cream-bg/80 backdrop-blur-sm
                    flex items-center justify-center z-[999]
                    opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="flex flex-col items-center gap-3">
                <div class="w-9 h-9 rounded-full border-[3px] border-[#F5A623]
                            border-t-transparent animate-spin"></div>
                <span class="text-[12px] text-muted font-semibold">Memuat peta...</span>
            </div>
        </div>

        <div id="leaflet-map"
             class="w-full h-[240px] md:h-[320px] lg:h-[380px] z-0">
        </div>
    </div>
</section> 