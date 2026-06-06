@extends('layouts.app')
@section('title', 'Hidden Gem - KUMAR')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
@endpush

@section('content')
    @include('hidden-gem.search')
    @include('hidden-gem.kampus')
    @include('hidden-gem.map')
    @include('hidden-gem.rating')

    {{-- ═══════════════════════════════════════════════════════════
         FULLSCREEN MAP MODAL
    ═══════════════════════════════════════════════════════════ --}}
    <div id="fs-map-modal"
         class="hidden fixed inset-0 z-[3000] bg-white flex flex-col"
         style="padding-top:env(safe-area-inset-top)">

        {{-- Map + Side Panel container --}}
        <div class="flex-1 relative flex flex-row w-full h-full" style="overflow: clip;">

            {{-- ── PETA ── --}}
            <div id="fs-leaflet-map" class="flex-1 h-full z-0"></div>

            {{-- ── FLOATING UI ELEMENTS (Absolute on top of map) ── --}}
            <div class="absolute top-4 left-0 right-0 z-[1000] pointer-events-none flex flex-col items-center">
                
                {{-- Header (Floating Search-like Bar) --}}
                <div class="w-[calc(100%-2rem)] md:w-[calc(100%-4rem)] pointer-events-auto bg-white rounded-full shadow-[0_4px_24px_rgba(0,0,0,0.12)] flex items-center px-4 py-3 gap-3">
                    <button onclick="closeFullscreenMap()"
                            class="w-8 h-8 rounded-full bg-transparent flex items-center
                                   justify-center hover:bg-black/5 active:scale-90 transition-all duration-150 flex-shrink-0">
                        <i class="fas fa-arrow-left text-[15px] text-dark"></i>
                    </button>
                    
                    <div class="flex-1 min-w-0 flex items-center justify-center">
                        <h3 id="fs-campus-name" class="text-[14px] font-bold text-dark truncate">
                            Pilih kampus terlebih dahulu
                        </h3>
                    </div>

                    <button class="w-8 h-8 rounded-full bg-transparent flex items-center
                                   justify-center hover:bg-black/5 active:scale-90 transition-all duration-150 flex-shrink-0 text-dark">
                        <i class="fas fa--h text-[14px]"></i>
                    </button>
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
            {{-- ════════════════════════════════════════════
                 MOBILE: Bottom Sheet
                 DESKTOP Left Panel
            ═════════════════════════════════════════════ --}}
            <div id="fs-bottom-sheet"
                 class="hidden z-[500] bg-white overflow-y-auto
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
                            sticky top-0 bg-white z-10">
                    <p class="text-[11px] font-bold text-muted uppercase tracking-wider">Info Tempat</p>
                    <button onclick="fsCloseBottomSheet()"
                            class="w-8 h-8 bg-black/[0.05] rounded-full flex items-center justify-center
                                   hover:bg-black/10 transition-colors">
                        <i class="fas fa-xmark text-[13px] text-dark"></i>
                    </button>
                </div>

                {{-- Close button (mobile) --}}
                <button onclick="fsCloseBottomSheet()"
                        class="md:hidden absolute top-4 right-4 w-8 h-8 bg-black/10
                               rounded-full flex items-center justify-center
                               hover:bg-black/20 transition-colors z-10">
                    <i class="fas fa-xmark text-[13px] text-dark"></i>
                </button>

                {{-- Hero image --}}
                <div class="relative w-full h-[160px] overflow-hidden flex-shrink-0">
                    <img id="fs-bs-image" src="" alt=""
                         class="w-full h-full object-cover"
                         onerror="this.src='/assets/img/resto/default.png'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/25 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <h2 id="fs-bs-name" class="text-white text-[17px] font-extrabold leading-tight mb-[6px]"></h2>
                        <div class="flex items-center gap-3 flex-wrap">
                            <span id="fs-bs-rating" class="text-[#FFD700] text-[13px] font-bold"></span>
                            <span id="fs-bs-distance" class="text-white/80 text-[12px]"></span>
                            <a id="fs-bs-detail-btn" href="#"
                                    class="ml-auto flex items-center gap-2 bg-[#F5A623] text-white
                                           px-4 py-[7px] rounded-full text-[12px] font-extrabold
                                           hover:brightness-110 active:scale-95 transition-all duration-150">
                                <i class="fas fa-arrow-up-right-from-square text-[11px]"></i>
                                Detail
                            </a>
                            <button id="fs-bs-nav-btn"
                                    class="flex items-center gap-2 bg-[#02b176] text-white
                                           px-4 py-[7px] rounded-full text-[12px] font-extrabold
                                           hover:brightness-110 active:scale-95 transition-all duration-150">
                                <i class="fas fa-diamond-turn-right text-[11px]"></i>
                                Navigasi
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Content body --}}
                <div class="px-5 py-4 space-y-4">

                    {{-- About --}}
                    <div>
                        <h3 class="text-[14px] font-extrabold text-dark mb-[6px]">About</h3>
                        <p id="fs-bs-desc" class="text-[12px] text-muted leading-[1.75]"></p>
                    </div>

                    <hr class="border-black/[0.06]">

                    {{-- Info Detail --}}
                    <div>
                        <h3 class="text-[14px] font-extrabold text-dark mb-3">Info Detail</h3>
                        <div class="space-y-3">

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-[10px] bg-[#F5EDE0] flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-location-dot text-[#C07A2A] text-[13px]"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-muted font-bold uppercase tracking-wider mb-[2px]">Alamat</p>
                                    <p id="fs-bs-address" class="text-[12px] text-dark font-medium leading-[1.55]"></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-[10px] bg-[#F5EDE0] flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-[#C07A2A] text-[13px]"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-muted font-bold uppercase tracking-wider mb-[2px]">Jam Buka</p>
                                    <p id="fs-bs-hours" class="text-[12px] text-dark font-medium"></p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-[10px] bg-[#F5EDE0] flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-tag text-[#C07A2A] text-[13px]"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-muted font-bold uppercase tracking-wider mb-[2px]">Kisaran Harga</p>
                                    <p id="fs-bs-price" class="text-[12px] text-dark font-medium"></p>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Google Maps link --}}
                    <a id="fs-bs-gmaps" href="#" target="_blank" rel="noopener"
                       class="flex items-center justify-center gap-2 w-full py-3 rounded-full
                              border-2 border-[#02b176] text-[#02b176] text-[13px] font-bold
                              hover:bg-[#02b176] hover:text-white transition-all duration-200">
                        <i class="fas fa-map text-[13px]"></i>
                        Lihat di Google Maps
                    </a>

                </div>
            </div>

        </div>{{-- end map+panel container --}}
    </div>

@endsection

@push('styles_extra')
<style>
    /* ── Panel kiri desktop (Google Maps style) ── */
    @media (min-width: 768px) {
        #fs-bottom-sheet {
            max-height: 100% !important;
            overflow-y: auto !important;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 380px;
            z-index: 500;
        }
        #fs-bottom-sheet.fs-panel-open {
            transform: translateX(0);
        }
    }

    /* ── Bottom sheet mobile ── */
    @media (max-width: 767px) {
        #fs-bottom-sheet {
            max-height: 72vh;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1);
        }
        #fs-bottom-sheet.fs-panel-open {
            transform: translateY(0);
        }
        
        /* Hide leaflet zoom control on mobile */
        .leaflet-control-zoom {
            display: none !important;
        }
    }
</style>
@endpush


@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script>
        // ═══════════════════════════════════════════════════════════
        // CONFIG
        // ═══════════════════════════════════════════════════════════
        const CAMPUSES = @json($campusesData);
        const API_URL = '{{ url("/hidden-gem/restaurants") }}';
        const NOMINATIM = 'https://nominatim.openstreetmap.org';

        // Format category name (e.g. "makanan_berat" to "Makanan Berat")
        function formatCategory(str) {
            if (!str) return '—';
            return str.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
        }
        // ═══════════════════════════════════════════════════════════
        // STATE
        // ═══════════════════════════════════════════════════════════
        const State = {
            map: null,
            markerLayer: null,
            userMarker: null,
            accuracyCircle: null,
            activeCampusId: null,
            userLat: null,
            userLng: null,
            searchTimer: null,
            isDropdownOpen: false,
            routingControl: null,
            currentCampus: null,
            currentRestaurants: [],
        };

        // ═══════════════════════════════════════════════════════════
        // HAVERSINE
        // ═══════════════════════════════════════════════════════════
        function haversine(lat1, lng1, lat2, lng2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) ** 2
                + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180)
                * Math.sin(dLng / 2) ** 2;
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        }

        // ═══════════════════════════════════════════════════════════
        // HITUNG JARAK RESTO DARI LOKASI USER (DINAMIS)
        // ═══════════════════════════════════════════════════════════
        function calcRestoDistance(rLat, rLng, fallback) {
            let baseLat = null;
            let baseLng = null;

            if (State.userLat != null && State.userLng != null) {
                baseLat = State.userLat;
                baseLng = State.userLng;
            } else if (State.currentCampus != null) {
                baseLat = State.currentCampus.latitude;
                baseLng = State.currentCampus.longitude;
            }

            if (baseLat != null && baseLng != null) {
                const km = haversine(baseLat, baseLng, rLat, rLng);
                if (km < 1)  return `${Math.round(km * 1000)} m`;
                if (km < 10) return `${km.toFixed(1)} km`;
                return `${Math.round(km)} km`;
            }

            return fallback || '—';
        }

        // ═══════════════════════════════════════════════════════════
        // DETECT NEAREST CAMPUS
        // ═══════════════════════════════════════════════════════════
        function detectNearestCampus(lat, lng) {
            return CAMPUSES.reduce((nearest, campus) => {
                const dist = haversine(lat, lng, campus.latitude, campus.longitude);
                return dist < nearest.dist ? { ...campus, dist } : nearest;
            }, { dist: Infinity });
        }

        // ═══════════════════════════════════════════════════════════
        // INIT MAP
        // ═══════════════════════════════════════════════════════════
        function initMap() {
            State.map = L.map('leaflet-map', {
                center: [-6.9, 107.61],
                zoom: 12,
                zoomControl: true,
                scrollWheelZoom: false,
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(State.map);

            State.markerLayer = L.layerGroup().addTo(State.map);
        }

        // ═══════════════════════════════════════════════════════════
        // CAROUSEL
        // ═══════════════════════════════════════════════════════════
        // ════════════════════════════════════════════
        // CAROUSEL FEATURED
        // ════════════════════════════════════════════
        (function initCarousel() {
            const track = document.getElementById('featured-carousel');
            const dots = document.querySelectorAll('.carousel-dot');
            const btnPrev = document.getElementById('carousel-prev');
            const btnNext = document.getElementById('carousel-next');

            if (!track) return;

            function getActiveIndex() {
                const slides = track.querySelectorAll('.featured-slide');
                let minDist = Infinity;
                let idx = 0;
                slides.forEach((s, i) => {
                    const d = Math.abs(s.offsetLeft - track.scrollLeft);
                    if (d < minDist) { minDist = d; idx = i; }
                });
                return idx;
            }

            function updateDots() {
                const active = getActiveIndex();
                dots.forEach((dot, i) => {
                    const isActive = i === active;
                    dot.classList.toggle('w-5', isActive);
                    dot.classList.toggle('bg-[#F5A623]', isActive);
                    dot.classList.toggle('w-[5px]', !isActive);
                    dot.classList.toggle('bg-black/15', !isActive);
                });
                if (btnPrev) btnPrev.disabled = track.scrollLeft <= 0;
                if (btnNext) btnNext.disabled =
                    track.scrollLeft >= track.scrollWidth - track.clientWidth - 10;
            }

            function scrollToSlide(index) {
                const slides = track.querySelectorAll('.featured-slide');
                if (slides[index]) {
                    track.scrollTo({ left: slides[index].offsetLeft, behavior: 'smooth' });
                }
            }

            dots.forEach((dot, i) => dot.addEventListener('click', () => scrollToSlide(i)));

            btnPrev?.addEventListener('click', () => track.scrollBy({ left: -380, behavior: 'smooth' }));
            btnNext?.addEventListener('click', () => track.scrollBy({ left: 380, behavior: 'smooth' }));

            track.addEventListener('scroll', updateDots, { passive: true });

            // Klik featured slide → langsung ke detail resto
            track.querySelectorAll('.featured-slide').forEach(slide => {
                slide.addEventListener('click', () => {
                    try {
                        const r = JSON.parse(slide.dataset.resto);
                        window.location.href = `/restoran/${r.id}`;
                    } catch { }
                });
            });

            updateDots();
        })();

        // ════════════════════════════════════════════
        // TOP RESTO CARD CLICK (static dari server)
        // ════════════════════════════════════════════
        document.querySelectorAll('.top-resto-card').forEach(card => {
            card.addEventListener('click', () => {
                try {
                    const r = JSON.parse(card.dataset.resto);
                    window.location.href = `/restoran/${r.id}`;
                } catch { }
            });
        });

        // ═══════════════════════════════════════════════════════════
        // UPDATE LOCATION BAR
        // ═══════════════════════════════════════════════════════════
        function updateLocationBar({ label, value, loading = false, error = false }) {
            const spinner = document.getElementById('loc-spinner');
            const icon = document.getElementById('loc-icon');
            const labelEl = document.getElementById('loc-label');
            const input = document.getElementById('loc-input');

            if (loading) {
                spinner.classList.remove('hidden');
                icon.classList.add('hidden');
            } else {
                spinner.classList.add('hidden');
                icon.classList.remove('hidden');
            }

            if (label) labelEl.textContent = label;
            if (value !== undefined && value !== null) input.value = value;

            icon.style.color = error ? '#f87171' : '#F5A623';
        }

        // ═══════════════════════════════════════════════════════════
        // REVERSE GEOCODE (Nominatim)
        // ═══════════════════════════════════════════════════════════
        async function reverseGeocode(lat, lng) {
            try {
                const res = await fetch(
                    `${NOMINATIM}/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=id`
                );
                const data = await res.json();
                const addr = data.address;

                // Prioritas: neighbourhood > suburb > city_district > city
                return addr.neighbourhood
                    || addr.suburb
                    || addr.city_district
                    || addr.city
                    || addr.state
                    || 'Lokasi Ditemukan';
            } catch {
                return null;
            }
        }

        // ═══════════════════════════════════════════════════════════
        // SEARCH LOCATION (Nominatim autocomplete)
        // ═══════════════════════════════════════════════════════════
        async function searchLocation(query) {
            try {
                const res = await fetch(
                    `${NOMINATIM}/search?q=${encodeURIComponent(query)}&format=json` +
                    `&countrycodes=id&limit=5&accept-language=id`
                );
                return await res.json();
            } catch {
                return [];
            }
        }

        // ═══════════════════════════════════════════════════════════
        // RENDER USER LOCATION ON MAP
        // ═══════════════════════════════════════════════════════════
        function renderUserLocation(lat, lng, accuracy = 50, popupLabel = '<b>Lokasi Kamu</b>') {
            // Hapus marker lama
            if (State.userMarker) State.userMarker.remove();
            if (State.accuracyCircle) State.accuracyCircle.remove();

            // Lingkaran akurasi
            State.accuracyCircle = L.circle([lat, lng], {
                radius: accuracy,
                color: '#3B82F6',
                fillColor: '#3B82F6',
                fillOpacity: 0.08,
                weight: 1,
            }).addTo(State.map);

            // Titik biru user
            const userIcon = L.divIcon({
                className: '',
                html: `
                                                <div style="position:relative;width:16px;height:16px;">
                                                    <div style="position:absolute;inset:0;background:#3B82F6;border-radius:50%;
                                                                border:2.5px solid #fff;box-shadow:0 2px 6px rgba(59,130,246,0.5);
                                                                animation:userPulse 2s ease-in-out infinite;"></div>
                                                </div>
                                                <style>
                                                    @keyframes userPulse {
                                                        0%,100%{box-shadow:0 0 0 0 rgba(59,130,246,0.4);}
                                                        50%{box-shadow:0 0 0 8px rgba(59,130,246,0);}
                                                    }
                                                </style>`,
                iconSize: [16, 16],
                iconAnchor: [8, 8],
            });

            State.userMarker = L.marker([lat, lng], { icon: userIcon })
                .addTo(State.map)
                .bindPopup(popupLabel);
        }
        

        /// ═══════════════════════════════════════════════════════════
        // RENDER RESTAURANT MARKERS
        // ═══════════════════════════════════════════════════════════
        function renderRestaurantMarkers(campus, restaurants) {
            State.markerLayer.clearLayers();

            // Marker kampus
            const campusIcon = L.divIcon({
                className: '',
                html: `<div style="width:36px;height:36px;background:#F5A623;border-radius:12px;
                                border:2.5px solid #fff;box-shadow:0 3px 10px rgba(245,166,35,0.4);
                                display:flex;align-items:center;justify-content:center;font-size:18px;">
                        🏫
                    </div>`,
                iconSize: [36, 36],
                iconAnchor: [18, 18],
            });

            L.marker([campus.latitude, campus.longitude], { icon: campusIcon })
                .addTo(State.markerLayer)
                .bindPopup(`<b style="font-size:13px;">${campus.name}</b>`)
                .openPopup();

            // Cache data restoran secara global agar bisa diakses dari popup onclick
            if (!window.__restoCache) window.__restoCache = {};

            // Marker restoran
            restaurants.forEach(r => {
                // Simpan data ke cache global dengan key id restoran
                window.__restoCache[r.id] = r;

                const restoIcon = L.divIcon({
                    className: '',
                    html: `<div style="width:32px;height:32px;background:#02b176;border-radius:50%;
                                    border:2.5px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.18);
                                    display:flex;align-items:center;justify-content:center;font-size:15px;">
                            🍜
                        </div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -34],
                });

                const ratingVal = r.rating != null ? parseFloat(r.rating).toFixed(1) : '—';
                const distanceVal = calcRestoDistance(r.latitude, r.longitude, r.distance);

                // Navigasi selalu aktif — startNavigation() sudah punya
                // fallback ke kampus aktif jika GPS/lokasi belum dipilih
                const popupHTML = `
                    <div style="width:220px;font-family:'Plus Jakarta Sans',sans-serif;">
                        <img src="${r.image}" alt="${r.name}"
                            style="width:100%;height:90px;object-fit:cover;
                                    border-radius:10px;margin-bottom:8px;display:block;"
                            onerror="this.src='/assets/img/resto/default.png'">

                        <div style="font-weight:800;font-size:13px;color:#040818;margin-bottom:2px;
                                    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            ${r.name}
                        </div>
                        <div style="font-size:11px;color:#5d6e86;margin-bottom:5px;">
                            ${formatCategory(r.category)} &middot; ${distanceVal}
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;
                                    margin-bottom:10px;">
                            <span style="color:#F5A623;font-size:12px;font-weight:700;">
                                &#9733; ${ratingVal}
                            </span>
                            <span style="font-size:11px;color:#5d6e86;">${r.price_range || '—'}</span>
                        </div>

                        <div style="display:flex;gap:6px;">
                            <a href="javascript:void(0)"
                               onclick="openModal(window.__restoCache[${r.id}])"
                               style="flex:1;display:flex;align-items:center;justify-content:center;
                                      gap:4px;background:#F5EDE0;color:#C07A2A;
                                      padding:7px 4px;border-radius:99px;
                                      font-size:11px;font-weight:700;text-decoration:none;
                                      cursor:pointer;">
                                &#128196; Detail
                            </a>
                            <a href="javascript:void(0)"
                               onclick="startNavigation(${r.latitude}, ${r.longitude})"
                               style="flex:2;display:flex;align-items:center;justify-content:center;
                                      gap:4px;background:#02b176;color:#fff;
                                      padding:7px 4px;border-radius:99px;
                                      font-size:11px;font-weight:700;text-decoration:none;
                                      cursor:pointer;">
                                &#128507; Navigasi
                            </a>
                        </div>
                    </div>`;

                L.marker([r.latitude, r.longitude], { icon: restoIcon })
                    .addTo(State.markerLayer)
                    .bindPopup(popupHTML, { maxWidth: 240 });
            });
        }

        // ═══════════════════════════════════════════════════════════
        // NAVIGATION (ROUTING)
        // ═══════════════════════════════════════════════════════════
        function startNavigation(destLat, destLng) {
            let fromLat = null;
            let fromLng = null;
            let fromLabel = '';

            if (State.userLat && State.userLng) {
                // GPS aktif atau lokasi manual yang sudah dipilih
                fromLat = State.userLat;
                fromLng = State.userLng;
                fromLabel = '<b>Posisi Kamu</b>';

            } else {
                // Fallback ke koordinat kampus aktif
                const campus = CAMPUSES.find(c => c.id === State.activeCampusId);
                if (!campus) {
                    alert('Pilih kampus atau masukkan lokasi kamu terlebih dahulu.');
                    return;
                }
                fromLat = campus.latitude;
                fromLng = campus.longitude;
                fromLabel = `<b>Titik Awal: ${campus.name}</b>`;
            }

            // Hapus rute lama
            if (State.routingControl) {
                State.map.removeControl(State.routingControl);
                State.routingControl = null;
            }

            State.routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(fromLat, fromLng),
                    L.latLng(destLat, destLng)
                ],
                routeWhileDragging: false,
                addWaypoints: false,
                fitSelectedRoutes: true,
                showAlternatives: false,
                show: false,
                collapsible: false,
                lineOptions: {
                    styles: [{ color: '#02b176', opacity: 0.85, weight: 6 }]
                },
                createMarker: function() { return null; },
                router: L.Routing.osrmv1({
                    language: 'id',
                    profile: 'car',
                    serviceUrl: 'https://router.project-osrm.org/route/v1'
                })
            }).addTo(State.map);

            // Render titik awal di peta
            renderUserLocation(fromLat, fromLng, 30, fromLabel);

            // Scroll ke peta
            document.getElementById('map-section')
                .scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // ═══════════════════════════════════════════════════════════
        // UPDATE MAP
        // ═══════════════════════════════════════════════════════════
        function updateMap(campus, restaurants) {
            State.map.flyTo([campus.latitude, campus.longitude], campus.zoom, {
                duration: 1.2,
                easeLinearity: 0.25,
            });
            renderRestaurantMarkers(campus, restaurants);
        }

        // ═══════════════════════════════════════════════════════════
        // UPDATE RESTAURANT CARDS
        // ═══════════════════════════════════════════════════════════
        function updateRestaurants(restaurants, featuredRestaurants = []) {
            const grid = document.getElementById('resto-cards');
            const skeleton = document.getElementById('cards-loading');

            if (!restaurants.length) {
                grid.innerHTML = `
                                    <div class="col-span-2 md:col-span-3 lg:col-span-4
                                                text-center py-8 text-muted text-[13px]">
                                        Belum ada restoran di kampus ini.
                                    </div>`;
                return;
            }

            const cardHTML = (r) => {
                const ratingStr = r.rating != null ? parseFloat(r.rating).toFixed(1) : '—';
                const distStr = calcRestoDistance(r.latitude, r.longitude, r.distance);
                const priceStr = r.price_range || '—';
                return `
                                <div class="top-resto-card bg-white rounded-[16px] overflow-hidden
                                            border border-black/[0.05]
                                            shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                                            cursor-pointer
                                            transition-all duration-200
                                            hover:-translate-y-[3px]
                                            hover:shadow-[0_8px_24px_rgba(0,0,0,0.12)]
                                            active:scale-[0.98]"
                                     data-resto='${JSON.stringify(r).replace(/'/g, "&#39;")}'>

                                    <div class="relative w-full h-[130px] overflow-hidden">
                                        <img src="${r.image}"
                                             alt="${r.name}"
                                             class="w-full h-full object-cover
                                                    transition-transform duration-300"
                                             onerror="this.src='/assets/img/resto/default.png'">

                                        <div class="absolute top-2 right-2">
                                            <span style="
                                                display:inline-flex;align-items:center;gap:3px;
                                                background:rgba(0,0,0,0.3);color:#fff;
                                                font-size:10px;font-weight:700;
                                                padding:3px 7px;border-radius:99px;
                                                backdrop-filter:blur(4px);
                                            ">
                                                ★ ${ratingStr}
                                            </span>
                                        </div>

                                        ${r.is_featured ? `
                                        <div class="absolute top-2 left-2">
                                            <span style="
                                                background:#F5A623;color:#fff;
                                                font-size:9px;font-weight:700;
                                                padding:2px 6px;border-radius:99px;
                                            ">Unggulan</span>
                                        </div>` : ''}
                                    </div>

                                    <div style="padding:10px 12px 12px;">
                                        <p style="
                                            font-size:12px;font-weight:800;
                                            color:#040818;line-height:1.4;
                                            margin-bottom:3px;
                                            display:-webkit-box;-webkit-line-clamp:2;
                                            -webkit-box-orient:vertical;overflow:hidden;
                                        ">${r.name}</p>

                                        <p style="font-size:11px;color:#5d6e86;margin-bottom:7px;">
                                            ${formatCategory(r.category)}
                                        </p>

                                        <div style="display:flex;align-items:center;justify-content:space-between;">
                                            <span style="font-size:11px;color:#02b176;font-weight:700;">
                                                <i class="fas fa-location-dot text-[9px]"></i> ${distStr}
                                            </span>
                                            <span style="font-size:10px;color:#5d6e86;">
                                                ${priceStr}
                                            </span>
                                        </div>
                                    </div>
                                </div>`;
            };

            grid.innerHTML = `
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    ${restaurants.map(r => cardHTML(r)).join('')}
                                </div>`;

            // Attach click listeners — langsung ke halaman detail
            grid.querySelectorAll('.top-resto-card').forEach(card => {
                card.addEventListener('click', () => {
                    try {
                        const r = JSON.parse(card.dataset.resto);
                        window.location.href = `/restoran/${r.id}`;
                    } catch (e) {
                        console.error('Parse error:', e);
                    }
                });
            });
        }

        // ═══════════════════════════════════════════════════════════
        // UPDATE FEATURED CAROUSEL
        // ═══════════════════════════════════════════════════════════
        function updateFeaturedCarousel(restaurants) {

            const track = document.getElementById('featured-carousel');
            const dots = document.getElementById('carousel-dots');

            if (!track) return;

            if (!restaurants.length) {
                track.innerHTML = `
                        <div class="w-full bg-white rounded-[20px]
                                    border border-black/[0.06]
                                    p-8 text-center">
                            <p class="text-[13px] text-muted">
                                Belum ada hidden gem unggulan.
                            </p>
                        </div>
                    `;

                dots.innerHTML = '';
                return;
            }

            track.innerHTML = restaurants.map((r, index) => {
                const ratingStr = r.rating != null ? parseFloat(r.rating).toFixed(1) : '—';
                const distStr = calcRestoDistance(r.latitude, r.longitude, r.distance);
                const descStr = r.description || '';
                return `
                    <div class="featured-slide flex-shrink-0 snap-start
                    w-[calc(100vw-48px)] md:w-[760px] max-w-none">

                    <div onclick='window.location.href="/restoran/${r.id}"'
                        class="bg-gradient-to-br from-[#D08700] to-[#EFB100]
                            rounded-[22px] overflow-hidden cursor-pointer">

                    <div class="relative w-full h-[160px] md:h-[220px] overflow-hidden">
                        <img src="${r.image}"
                         class="w-full h-full object-cover"
                         onerror="this.src='/assets/img/resto/default.png'">

                                <div class="absolute inset-0
                                            bg-gradient-to-t
                                            from-black/40
                                            to-transparent">
                                </div>

                                <div class="absolute top-3 left-3">
                                    <span class="bg-white/90 text-[#C07A2A]
                                                 text-[10px] font-bold
                                                 px-2 py-1 rounded-full">
                                        Rekomendasi
                                    </span>
                                </div>

                                <div class="absolute top-3 right-3">
                                    <span class="bg-black/30 text-white
                                                 text-[11px] font-bold
                                                 px-2 py-1 rounded-full">
                                        ★ ${ratingStr}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4">
                                <h3 class="text-white text-[16px]
                                           font-extrabold mb-1">
                                    ${r.name}
                                </h3>

                                <p class="text-white/80 text-[12px]
                                          line-clamp-2 mb-3">
                                    ${descStr}
                                </p>

                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="bg-white/20 text-white
                                                 text-[10px] font-bold
                                                 px-2 py-1 rounded-full">
                                        📍 ${distStr}
                                    </span>

                                    <span class="bg-white/20 text-white
                                                 text-[10px] font-bold
                                                 px-2 py-1 rounded-full">
                                        ${formatCategory(r.category)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            dots.innerHTML = restaurants.map((_, i) => `
                    <button class="carousel-dot
                                   ${i === 0
                    ? 'w-5 bg-[#F5A623]'
                    : 'w-[5px] bg-black/15'}
                                   h-[5px] rounded-full">
                    </button>
                `).join('');
        }

        // ═══════════════════════════════════════════════════════════
        // SELECT CAMPUS
        // ═══════════════════════════════════════════════════════════
        async function selectCampus(campusId, scroll = true, updateSearchText = true) {
            if (State.activeCampusId === campusId) {
                // Jika kampus yang sama diklik lagi, batalkan pemilihan (reset ke default)
                window.location.reload();
                return;
            }
            State.activeCampusId = campusId;

            // ← Tambah ini: update location bar saat kampus diklik
            if (updateSearchText) {
                const campus = CAMPUSES.find(c => c.id === campusId);
                if (campus) {
                    updateLocationBar({
                        label: 'Kampus dipilih',
                        value: campus.name,
                    });
                }
            }

            // Update active state UI kampus
            document.querySelectorAll('.kampus-item').forEach(el => {
                const isActive = parseInt(el.dataset.id) === campusId;
                const icon = el.querySelector('.kampus-icon-wrap');
                const label = el.querySelector('.kampus-label');

                icon.classList.toggle('ring-4', isActive);
                icon.classList.toggle('ring-[#F5A623]', isActive);
                icon.classList.toggle('ring-offset-2', isActive);
                icon.classList.toggle('scale-110', isActive);
                icon.classList.toggle('opacity-60', !isActive);
                label.classList.toggle('text-[#6B4423]', isActive);
                label.classList.toggle('font-extrabold', isActive);
                label.classList.toggle('text-muted', !isActive);
            });

            setLoading(true);

            try {
                const res = await fetch(`${API_URL}/${campusId}`);
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const data = await res.json();

                updateMap(data.campus, data.restaurants);
                updateRestaurants(data.restaurants);
                if (data.featuredRestaurants) {
                    updateFeaturedCarousel(data.featuredRestaurants);
                }

                // Simpan data aktif untuk dipakai fullscreen map
                State.currentCampus      = data.campus;
                State.currentRestaurants = data.restaurants;

                // Sync fullscreen map jika sedang terbuka
                if (!document.getElementById('fs-map-modal').classList.contains('hidden')) {
                    fsOpenWithData(data.campus, data.restaurants);
                }

                document.getElementById('map-subtitle').textContent =
                    `${data.campus.name} · ${data.restaurants.length} hidden gem`;

            } catch (err) {
                console.error('selectCampus error:', err);
                document.getElementById('resto-cards').innerHTML = `
                <p class="text-center text-red-400 text-[13px] py-8">
                    Gagal memuat data. Coba lagi.
                </p>`;
            } finally {
                setLoading(false);
            }

            if (scroll) {
                setTimeout(() => {
                    document.getElementById('map-section')
                        .scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 200);
            }
        }

        // ═══════════════════════════════════════════════════════════
        // GEOLOCATION
        // ═══════════════════════════════════════════════════════════
        function detectUserLocation() {
            updateLocationBar({ label: 'Mendeteksi lokasi...', value: '', loading: true });

            if (!navigator.geolocation) {
                handleGPSFallback('GPS tidak didukung');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                async (pos) => {
                    const { latitude: lat, longitude: lng, accuracy } = pos.coords;
                    State.userLat = lat;
                    State.userLng = lng;

                    // Render titik user di map
                    renderUserLocation(lat, lng, accuracy);

                    // Reverse geocode
                    const placeName = await reverseGeocode(lat, lng);

                    // Nearest campus
                    const nearest = detectNearestCampus(lat, lng);
                    const distText = nearest.dist < 1
                        ? `${Math.round(nearest.dist * 1000)}m`
                        : `${nearest.dist.toFixed(1)}km`;

                    updateLocationBar({
                        label: `Dekat ${nearest.name.split(' ').slice(0, 2).join(' ')} · ${distText}`,
                        value: placeName || nearest.name,
                    });

                    await selectCampus(nearest.id, false, false);
                },
                (err) => {
                    const msgs = { 1: 'Izin ditolak', 2: 'Lokasi tidak tersedia', 3: 'Timeout' };
                    handleGPSFallback(msgs[err.code] || 'GPS gagal');
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
            );
        }

        function handleGPSFallback(reason) {
            updateLocationBar({
                label: reason + ' — ketik lokasi atau pilih kampus',
                value: '',
                error: true,
            });

            // Buka dropdown supaya user bisa ketik atau pilih kampus
            const input = document.getElementById('loc-input');
            input.placeholder = 'Ketik nama jalan, kelurahan, atau kampus...';
            input.focus();
            openDropdown();
        }

        // ═══════════════════════════════════════════════════════════
        // AUTOCOMPLETE DROPDOWN
        // ═══════════════════════════════════════════════════════════
        function renderDropdownCampus(query = '') {
            const list = document.getElementById('dropdown-campus-list');
            const filtered = query
                ? CAMPUSES.filter(c => c.name.toLowerCase().includes(query.toLowerCase()))
                : CAMPUSES;

            if (!filtered.length) {
                document.getElementById('dropdown-campus-section').classList.add('hidden');
                return;
            }

            document.getElementById('dropdown-campus-section').classList.remove('hidden');
            list.innerHTML = filtered.map(c => `
                                            <div class="dropdown-item flex items-center gap-3 px-4 py-3
                                                        hover:bg-black/[0.03] cursor-pointer transition-colors duration-100"
                                                 data-type="campus" data-id="${c.id}"
                                                 data-lat="${c.latitude}" data-lng="${c.longitude}" data-name="${c.name}">
                                                <div class="w-8 h-8 rounded-[10px] bg-[#F5A623] flex items-center
                                                            justify-center flex-shrink-0 overflow-hidden">
                                                    <img src="${c.logo}" alt="${c.name}"
                                                         class="w-6 h-6 object-contain"
                                                         onerror="this.style.display='none'">
                                                </div>
                                                <div>
                                                    <p class="text-[12px] font-bold text-dark">${c.name}</p>
                                                    <p class="text-[10px] text-muted">Kampus</p>
                                                </div>
                                            </div>`).join('');
        }

        function renderDropdownSearch(results) {
            const section = document.getElementById('dropdown-search-section');
            const list = document.getElementById('dropdown-search-list');

            if (!results.length) {
                section.classList.add('hidden');
                return;
            }

            section.classList.remove('hidden');
            list.innerHTML = results.map(r => `
                                            <div class="dropdown-item flex items-center gap-3 px-4 py-3
                                                        hover:bg-black/[0.03] cursor-pointer transition-colors duration-100"
                                                 data-type="location" data-lat="${r.lat}" data-lng="${r.lon}"
                                                 data-name="${r.display_name.split(',').slice(0, 2).join(',')}">
                                                <div class="w-8 h-8 rounded-full bg-[#F5EDE0] flex items-center
                                                            justify-center flex-shrink-0">
                                                    <i class="fas fa-map-pin text-[#C07A2A] text-[13px]"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[12px] font-bold text-dark truncate">
                                                        ${r.display_name.split(',')[0]}
                                                    </p>
                                                    <p class="text-[10px] text-muted truncate">
                                                        ${r.display_name.split(',').slice(1, 3).join(',')}
                                                    </p>
                                                </div>
                                            </div>`).join('');
        }

        function openDropdown() {
            const dd = document.getElementById('loc-dropdown');
            dd.classList.remove('hidden');
            State.isDropdownOpen = true;
            renderDropdownCampus();
            document.getElementById('dropdown-empty').classList.add('hidden');
        }

        function closeDropdown() {
            document.getElementById('loc-dropdown').classList.add('hidden');
            State.isDropdownOpen = false;
        }

        async function handleSearchInput(query) {
            const clearBtn = document.getElementById('loc-clear');
            clearBtn.classList.toggle('hidden', !query);

            if (!query) {
                renderDropdownCampus();
                document.getElementById('dropdown-search-section').classList.add('hidden');
                document.getElementById('dropdown-empty').classList.add('hidden');
                document.getElementById('dropdown-loading').classList.add('hidden');
                return;
            }

            // Filter kampus dulu
            renderDropdownCampus(query);

            // Debounce search Nominatim
            clearTimeout(State.searchTimer);
            State.searchTimer = setTimeout(async () => {
                document.getElementById('dropdown-loading').classList.remove('hidden');
                document.getElementById('dropdown-empty').classList.add('hidden');

                const results = await searchLocation(query);

                document.getElementById('dropdown-loading').classList.add('hidden');

                if (!results.length) {
                    const campusSection = document.getElementById('dropdown-campus-section');
                    if (campusSection.classList.contains('hidden')) {
                        document.getElementById('dropdown-empty').classList.remove('hidden');
                    }
                } else {
                    renderDropdownSearch(results);
                }
            }, 500);
        }



        // ═══════════════════════════════════════════════════════════
        // MODAL
        // ═══════════════════════════════════════════════════════════

        // Mini-map instance tracker
        let _modalMiniMap = null;
        let _modalMiniMarker = null;

        function openModal(r) {
            // ── Basic fields ──
            document.getElementById('modal-image').src = r.image;
            document.getElementById('modal-name').textContent = r.name;
            document.getElementById('modal-category').textContent = formatCategory(r.category);

            const modalRating = r.rating != null
                ? `★ ${parseFloat(r.rating).toFixed(1)}`
                : '★ —';
            const modalDist = calcRestoDistance(r.latitude, r.longitude, r.distance);
            document.getElementById('modal-rating').textContent   = modalRating;
            document.getElementById('modal-distance').textContent = modalDist
                ? `📍 ${modalDist}` : '';
            document.getElementById('modal-desc').textContent  = r.description || 'Tidak ada deskripsi.';
            document.getElementById('modal-price').textContent = r.price_range || '—';
            document.getElementById('modal-address').textContent = r.address || '—';
            document.getElementById('modal-hours').textContent   = r.open_hours || '—';

            // ── Google Maps link ──
            const gmapsEl = document.getElementById('modal-gmaps');
            const gmapsHref = r.gmaps_link
                || `https://www.google.com/maps?q=${r.latitude},${r.longitude}`;
            gmapsEl.href = gmapsHref;

            // ── Detail btn ──
            const detailBtn = document.getElementById('modal-detail-btn');
            if (detailBtn) detailBtn.href = `/restoran/${r.id}`;

            // ── Tulis Ulasan btn ──
            const reviewBtn = document.getElementById('modal-review-btn');
            if (reviewBtn) reviewBtn.href = `/restoran/${r.id}#ulasan`;

            // ── Navigasi btn ──
            const navBtn = document.getElementById('modal-nav-btn');
            navBtn.onclick = function (e) {
                e.preventDefault();
                closeModal();
                startNavigation(r.latitude, r.longitude);
            };

            // ── Fasilitas chips ──
            const facWrap = document.getElementById('modal-facilities');
            const facilities = buildFacilities(r);
            if (facilities.length) {
                facWrap.innerHTML = facilities.map(f =>
                    `<span class="flex items-center gap-2
                                  bg-white border border-black/[0.08]
                                  text-dark text-[12px] font-semibold
                                  px-3 py-[6px] rounded-full
                                  shadow-[0_1px_4px_rgba(0,0,0,0.06)]">
                        <i class="${f.icon} text-[#C07A2A] text-[11px]"></i>
                        ${f.label}
                    </span>`
                ).join('');
            } else {
                facWrap.innerHTML = '<p class="text-[12px] text-muted">—</p>';
            }

            // ── Mini Map ──
            renderModalMiniMap(r.latitude, r.longitude, r.name);

            // ── Reviews ──
            fetchAndRenderReviews(r.id);

            // ── Show modal ──
            document.getElementById('resto-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Scroll sheet ke atas
            const sheet = document.getElementById('modal-sheet');
            if (sheet) {
                const scrollable = sheet.querySelector('.overflow-y-auto');
                if (scrollable) scrollable.scrollTop = 0;
            }
        }

        // Build fasilitas dari data restoran yang tersedia
        function buildFacilities(r) {
            const chips = [];
            const ft = (r.food_type || '').toLowerCase();
            const cat = (r.category || '').toLowerCase();

            // Dari food_type
            if (ft.includes('halal') || cat.includes('halal')) {
                chips.push({ icon: 'fas fa-check-circle', label: 'Halal' });
            }
            if (ft.includes('outdoor') || ft.includes('lesehan')) {
                chips.push({ icon: 'fas fa-umbrella-beach', label: 'Outdoor' });
            }
            if (ft.includes('indoor')) {
                chips.push({ icon: 'fas fa-store', label: 'Indoor' });
            }
            if (ft.includes('parkir') || ft.includes('parking')) {
                chips.push({ icon: 'fas fa-square-parking', label: 'Parkir' });
            }
            if (ft.includes('wifi') || ft.includes('wi-fi')) {
                chips.push({ icon: 'fas fa-wifi', label: 'Gratis WiFi' });
            }
            if (ft.includes('ac') || ft.includes('ber-ac')) {
                chips.push({ icon: 'fas fa-snowflake', label: 'Ber-AC' });
            }
            if (ft.includes('vegetarian') || ft.includes('vegan')) {
                chips.push({ icon: 'fas fa-leaf', label: 'Vegetarian' });
            }
            if (ft.includes('delivery') || ft.includes('go-jek') || ft.includes('grab')) {
                chips.push({ icon: 'fas fa-motorcycle', label: 'Delivery' });
            }

            // Jika tidak ada apapun, tampilkan food_type mentah
            if (!chips.length && r.food_type) {
                const raw = r.food_type.split(',').map(s => s.trim()).filter(Boolean);
                raw.slice(0, 4).forEach(t =>
                    chips.push({ icon: 'fas fa-utensils', label: t })
                );
            }

            return chips;
        }

        // Render mini-map di dalam modal
        function renderModalMiniMap(lat, lng, name) {
            if (!lat || !lng) {
                document.getElementById('modal-mini-map').innerHTML =
                    '<div class="w-full h-full bg-black/[0.04] flex items-center justify-center">' +
                    '<p class="text-[12px] text-muted">Koordinat tidak tersedia</p></div>';
                return;
            }

            const container = document.getElementById('modal-mini-map');

            // Hapus map lama
            if (_modalMiniMap) {
                _modalMiniMap.remove();
                _modalMiniMap = null;
                _modalMiniMarker = null;
                container.innerHTML = '';
            }

            // Beri waktu DOM render
            setTimeout(() => {
                _modalMiniMap = L.map('modal-mini-map', {
                    center: [lat, lng],
                    zoom: 16,
                    zoomControl: false,
                    dragging: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    boxZoom: false,
                    keyboard: false,
                    attributionControl: false,
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(_modalMiniMap);

                const icon = L.divIcon({
                    className: '',
                    html: `<div style="width:28px;height:28px;background:#02b176;border-radius:50%;
                                      border:2.5px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.22);
                                      display:flex;align-items:center;justify-content:center;font-size:13px;">🍜</div>`,
                    iconSize: [28, 28],
                    iconAnchor: [14, 14],
                });

                _modalMiniMarker = L.marker([lat, lng], { icon })
                    .addTo(_modalMiniMap)
                    .bindPopup(`<b style="font-size:12px;">${name}</b>`)
                    .openPopup();

                _modalMiniMap.invalidateSize();
            }, 80);
        }

        // Fetch dan render ulasan
        async function fetchAndRenderReviews(restoId) {
            const listEl    = document.getElementById('modal-reviews-list');
            const emptyEl   = document.getElementById('modal-reviews-empty');
            const loadingEl = document.getElementById('modal-reviews-loading');

            listEl.innerHTML    = '';
            emptyEl.classList.add('hidden');
            loadingEl.classList.remove('hidden');

            try {
                const res  = await fetch(`/api/restoran/${restoId}/reviews`);
                const data = await res.json();
                loadingEl.classList.add('hidden');

                if (!data.length) {
                    emptyEl.classList.remove('hidden');
                    return;
                }

                listEl.innerHTML = data.map(rv => {
                    const stars = Array.from({ length: 5 }, (_, i) =>
                        `<i class="fas fa-star text-[10px] ${i < rv.rating ? 'text-[#F5A623]' : 'text-black/15'}"></i>`
                    ).join('');

                    const initials = rv.user_name
                        .split(' ').slice(0, 2)
                        .map(w => w[0]).join('').toUpperCase();

                    return `
                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#F5A623] to-[#C07A2A]
                                        flex items-center justify-center flex-shrink-0
                                        text-white text-[13px] font-extrabold shadow-sm">
                                ${initials}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-[3px]">
                                    <p class="text-[13px] font-extrabold text-dark leading-none">${rv.user_name}</p>
                                    <span class="text-[11px] text-muted">${rv.created_at}</span>
                                </div>
                                <div class="flex gap-[2px] mb-1">${stars}</div>
                                <p class="text-[12px] text-muted leading-[1.6]">${rv.comment || ''}</p>
                            </div>
                        </div>`;
                }).join('');

            } catch (err) {
                console.error('fetchReviews error:', err);
                loadingEl.classList.add('hidden');
                listEl.innerHTML = '<p class="text-[12px] text-red-400 text-center py-3">Gagal memuat ulasan.</p>';
            }
        }

        function closeModal() {
            document.getElementById('resto-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }


        // ═══════════════════════════════════════════════════════════
        // LOADING
        // ═══════════════════════════════════════════════════════════
        function setLoading(show) {
            const overlay = document.getElementById('map-loading');
            const skeleton = document.getElementById('cards-loading');
            const cards = document.getElementById('resto-cards');

            overlay.style.opacity = show ? '1' : '0';
            overlay.style.pointerEvents = show ? 'all' : 'none';
            skeleton.style.display = show ? 'flex' : 'none';
            cards.style.opacity = show ? '0.3' : '1';
        }

        // ═══════════════════════════════════════════════════════════
        // FULLSCREEN MAP
        // ═══════════════════════════════════════════════════════════
        const FsState = {
            map: null,
            markerLayer: null,
            userMarker: null,
            accuracyCircle: null,
            routingControl: null,
            activeFilter: 'all',
            currentResto: null,
            initialized: false,
        };

        // Buka fullscreen map
        function openFullscreenMap() {
            const modal = document.getElementById('fs-map-modal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Lazy-init Leaflet map
            if (!FsState.initialized) {
                setTimeout(() => {
                    FsState.map = L.map('fs-leaflet-map', {
                        center: State.currentCampus
                            ? [State.currentCampus.latitude, State.currentCampus.longitude]
                            : [-6.9, 107.61],
                        zoom: State.currentCampus ? (State.currentCampus.zoom || 15) : 12,
                        zoomControl: true,
                        scrollWheelZoom: true,
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap',
                        maxZoom: 19,
                    }).addTo(FsState.map);

                    FsState.markerLayer = L.layerGroup().addTo(FsState.map);
                    FsState.initialized = true;

                    if (State.currentCampus && State.currentRestaurants.length) {
                        fsOpenWithData(State.currentCampus, State.currentRestaurants);
                    }
                }, 80);
            } else {
                setTimeout(() => FsState.map.invalidateSize(), 100);
                if (State.currentCampus && State.currentRestaurants.length) {
                    fsOpenWithData(State.currentCampus, State.currentRestaurants);
                }
            }
        }

        // Tutup fullscreen map
        function closeFullscreenMap() {
            document.getElementById('fs-map-modal').classList.add('hidden');
            document.body.style.overflow = '';
            fsCloseBottomSheet();
        }

        // Sync fullscreen map dengan data kampus
        function fsOpenWithData(campus, restaurants) {
            document.getElementById('fs-campus-name').textContent = campus.name;

            fsBuildFilterChips(restaurants);
            fsRenderMarkers(restaurants, FsState.activeFilter);

            if (FsState.map) {
                FsState.map.flyTo([campus.latitude, campus.longitude], campus.zoom || 15, { duration: 0.8 });
            }

            // Tampilkan user marker jika ada
            if (State.userLat && State.userLng) {
                fsPlaceUserMarker(State.userLat, State.userLng);
            }
        }

        // Buat filter chip dari kategori restoran
        function fsBuildFilterChips(restaurants) {
            const bar = document.getElementById('fs-filter-bar');
            const categories = [...new Set(restaurants.map(r => r.category).filter(Boolean))];

            bar.innerHTML = `
                <button class="fs-chip flex-shrink-0 px-4 py-[6px] rounded-full text-[12px]
                               font-bold transition-all duration-150 border
                               ${FsState.activeFilter === 'all'
                                   ? 'bg-[#F5A623] text-white border-transparent shadow-[0_2px_8px_rgba(245,166,35,0.4)]'
                                   : 'bg-white text-dark border-black/[0.1] shadow-sm hover:bg-black/[0.02]'}"
                        data-filter="all">All</button>
                ${categories.map(cat => `
                    <button class="fs-chip flex-shrink-0 px-4 py-[6px] rounded-full text-[12px]
                                   font-bold transition-all duration-150 border
                                   ${FsState.activeFilter === cat
                                       ? 'bg-[#F5A623] text-white border-transparent shadow-[0_2px_8px_rgba(245,166,35,0.4)]'
                                       : 'bg-white text-dark border-black/[0.1] shadow-sm hover:bg-black/[0.02]'}"
                            data-filter="${cat}">${formatCategory(cat)}</button>
                `).join('')}
            `;

            bar.querySelectorAll('.fs-chip').forEach(btn => {
                btn.addEventListener('click', () => {
                    FsState.activeFilter = btn.dataset.filter;
                    fsBuildFilterChips(State.currentRestaurants);
                    fsRenderMarkers(State.currentRestaurants, FsState.activeFilter);
                });
            });
        }

        // Render marker di fullscreen map (dengan filter)
        function fsRenderMarkers(restaurants, filter) {
            if (!FsState.map || !FsState.markerLayer) return;
            FsState.markerLayer.clearLayers();

            // Campus marker
            if (State.currentCampus) {
                const campusIcon = L.divIcon({
                    className: '',
                    html: `<div style="width:34px;height:34px;background:#F5A623;border-radius:10px;
                                      border:2.5px solid #fff;box-shadow:0 3px 10px rgba(245,166,35,0.4);
                                      display:flex;align-items:center;justify-content:center;font-size:17px;">
                               🏫
                           </div>`,
                    iconSize: [34, 34],
                    iconAnchor: [17, 17],
                });
                L.marker([State.currentCampus.latitude, State.currentCampus.longitude],
                    { icon: campusIcon })
                    .addTo(FsState.markerLayer)
                    .bindPopup(`<b style="font-size:13px;">${State.currentCampus.name}</b>`);
            }

            // Restaurant markers
            const filtered = filter === 'all'
                ? restaurants
                : restaurants.filter(r => r.category === filter);

            filtered.forEach(r => {
                const icon = L.divIcon({
                    className: '',
                    html: `<div style="width:32px;height:32px;background:#02b176;border-radius:50%;
                                      border:2.5px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.2);
                                      display:flex;align-items:center;justify-content:center;font-size:15px;">
                               🍜
                           </div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -36],
                });

                L.marker([r.latitude, r.longitude], { icon })
                    .addTo(FsState.markerLayer)
                    .on('click', () => fsOpenBottomSheet(r));
            });
        }

        // Buka bottom sheet dengan data restoran
        function fsOpenBottomSheet(r) {
            FsState.currentResto = r;

            const ratingStr = r.rating != null ? `★ ${parseFloat(r.rating).toFixed(1)}` : '★ —';
            const distStr   = calcRestoDistance(r.latitude, r.longitude, r.distance);

            document.getElementById('fs-bs-image').src           = r.image;
            document.getElementById('fs-bs-image').alt           = r.name;
            document.getElementById('fs-bs-name').textContent    = r.name;
            document.getElementById('fs-bs-rating').textContent  = ratingStr;
            document.getElementById('fs-bs-distance').textContent = distStr;
            document.getElementById('fs-bs-desc').textContent    = r.description || 'Tidak ada deskripsi.';
            document.getElementById('fs-bs-address').textContent = r.address || '—';
            document.getElementById('fs-bs-hours').textContent   = r.open_hours || '—';
            document.getElementById('fs-bs-price').textContent   = r.price_range || '—';

            const detailBtn = document.getElementById('fs-bs-detail-btn');
            if (detailBtn) {
                detailBtn.href = `/restoran/${r.id}`;
            }

            // Google Maps link
            const gmapsEl = document.getElementById('fs-bs-gmaps');
            if (r.gmaps_link) {
                gmapsEl.href = r.gmaps_link;
                gmapsEl.classList.remove('hidden');
            } else {
                gmapsEl.href = `https://www.google.com/maps?q=${r.latitude},${r.longitude}`;
                gmapsEl.classList.remove('hidden');
            }

            // Navigasi button
            document.getElementById('fs-bs-nav-btn').onclick = () => {
                fsStartNavigation(r.latitude, r.longitude);
            };

            const sheet = document.getElementById('fs-bottom-sheet');
            sheet.classList.remove('hidden'); // In case it has hidden initially
            // Pakai setTimeout supaya transisi CSS jalan
            setTimeout(() => {
                sheet.classList.add('fs-panel-open');
            }, 10);

            // Geser peta sedikit ke atas (mobile) atau ke kanan (desktop) supaya marker tidak tertutup
            if (FsState.map) {
                if (window.innerWidth >= 768) {
                    // Desktop: pan ke kanan sedikit
                    FsState.map.panBy([-180, 0], { animate: true });
                } else {
                    // Mobile: pan ke bawah sedikit
                    FsState.map.panBy([0, 150], { animate: true });
                }
            }
        }

        // Navigasi khusus Fullscreen Map
        function fsStartNavigation(destLat, destLng) {
            let fromLat = null;
            let fromLng = null;
            let fromLabel = '';

            if (State.userLat && State.userLng) {
                fromLat = State.userLat;
                fromLng = State.userLng;
                fromLabel = '<b>Posisi Kamu</b>';
            } else {
                const campus = CAMPUSES.find(c => c.id === State.activeCampusId);
                if (!campus) {
                    alert('Pilih kampus atau masukkan lokasi kamu terlebih dahulu.');
                    return;
                }
                fromLat = campus.latitude;
                fromLng = campus.longitude;
                fromLabel = `<b>Titik Awal: ${campus.name}</b>`;
            }

            if (FsState.routingControl) {
                FsState.map.removeControl(FsState.routingControl);
                FsState.routingControl = null;
            }

            FsState.routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(fromLat, fromLng),
                    L.latLng(destLat, destLng)
                ],
                routeWhileDragging: false,
                addWaypoints: false,
                fitSelectedRoutes: true,
                showAlternatives: false,
                show: false,
                collapsible: false,
                lineOptions: {
                    styles: [{ color: '#02b176', opacity: 0.8, weight: 6 }]
                },
                // Let Leaflet Routing Machine draw default markers for start/end so they don't look "lost"
                router: L.Routing.osrmv1({
                    language: 'id',
                    profile: 'car',
                    serviceUrl: 'https://router.project-osrm.org/route/v1'
                })
            }).addTo(FsState.map);

            // Jangan tutup bottom sheet agar info resto tetap terlihat
            // fsCloseBottomSheet();
        }

        // Tutup bottom sheet
        function fsCloseBottomSheet() {
            const sheet = document.getElementById('fs-bottom-sheet');
            sheet.classList.remove('fs-panel-open');
            // Hide element setelah transisi selesai (opsional, tapi bagus untuk layout)
            setTimeout(() => {
                if (!sheet.classList.contains('fs-panel-open')) {
                    sheet.classList.add('hidden');
                }
            }, 350); 
            FsState.currentResto = null;
        }

        // Tempatkan user marker di fullscreen map
        function fsPlaceUserMarker(lat, lng) {
            if (!FsState.map) return;

            if (FsState.userMarker) FsState.userMarker.remove();
            if (FsState.accuracyCircle) FsState.accuracyCircle.remove();

            FsState.accuracyCircle = L.circle([lat, lng], {
                radius: 60, color: '#3B82F6', fillColor: '#3B82F6', fillOpacity: 0.08, weight: 1,
            }).addTo(FsState.map);

            const userIcon = L.divIcon({
                className: '',
                html: `<div style="width:16px;height:16px;background:#3B82F6;border-radius:50%;
                                   border:2.5px solid #fff;box-shadow:0 2px 6px rgba(59,130,246,0.5);
                                   animation:userPulse 2s ease-in-out infinite;"></div>`,
                iconSize: [16, 16],
                iconAnchor: [8, 8],
            });

            FsState.userMarker = L.marker([lat, lng], { icon: userIcon })
                .addTo(FsState.map)
                .bindPopup('<b>Lokasi Kamu</b>');
        }

        // GPS di fullscreen map
        function fsDetectGPS() {
            if (!navigator.geolocation) {
                alert('GPS tidak didukung di perangkat ini.');
                return;
            }
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const { latitude: lat, longitude: lng } = pos.coords;
                    State.userLat = lat;
                    State.userLng = lng;
                    fsPlaceUserMarker(lat, lng);
                    if (FsState.map) FsState.map.flyTo([lat, lng], 16, { duration: 0.8 });
                },
                () => alert('Tidak dapat mendeteksi GPS. Coba izinkan akses lokasi.'),
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }

        // ═══════════════════════════════════════════════════════════
        // EVENT LISTENERS
        // ═══════════════════════════════════════════════════════════
        document.addEventListener('DOMContentLoaded', () => {

            initMap();

            // ── Kampus click ──
            document.querySelectorAll('.kampus-item').forEach(el => {
                el.addEventListener('click', () => selectCampus(parseInt(el.dataset.id), true, true));
            });

            // ── Search input ──
            const input = document.getElementById('loc-input');

            input.addEventListener('focus', () => openDropdown());

            input.addEventListener('input', (e) => handleSearchInput(e.target.value.trim()));

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') { 
                    closeDropdown(); 
                    input.blur(); 
                } else if (e.key === 'Enter') {
                    e.preventDefault(); // Mencegah reload halaman
                    const firstItem = document.querySelector('.dropdown-item:not(.hidden)');
                    if (firstItem) {
                        firstItem.click();
                    }
                }
            });

            // ── Clear button ──
            document.getElementById('loc-clear').addEventListener('click', () => {
                input.value = '';
                document.getElementById('loc-clear').classList.add('hidden');
                renderDropdownCampus();
                document.getElementById('dropdown-search-section').classList.add('hidden');
                input.focus();
            });

            // ── GPS button ──
            document.getElementById('loc-gps-btn').addEventListener('click', detectUserLocation);

            // ── Dropdown item click ──
            document.getElementById('loc-dropdown').addEventListener('click', async (e) => {
            const item = e.target.closest('.dropdown-item');
            if (!item) return;

            const { type, id, lat, lng, name } = item.dataset;
            input.value = name;
            document.getElementById('loc-clear').classList.remove('hidden');
            closeDropdown();

            if (type === 'campus') {
                updateLocationBar({ label: 'Kampus dipilih', value: name });

                // Reset dulu supaya tidak ter-skip
                State.activeCampusId = null;
                await selectCampus(parseInt(id), true, false);

            } else {
                const fLat = parseFloat(lat);
                const fLng = parseFloat(lng);

                State.userLat = fLat;
                State.userLng = fLng;

                const nearest = detectNearestCampus(fLat, fLng);
                const distText = nearest.dist < 1
                    ? `${Math.round(nearest.dist * 1000)}m ke ${nearest.name.split(' ')[0]}`
                    : `${nearest.dist.toFixed(1)}km ke ${nearest.name.split(' ')[0]}`;

                updateLocationBar({ label: distText, value: name });
                renderUserLocation(fLat, fLng, 100, '<b>Lokasi Kamu</b>');
                State.map.flyTo([fLat, fLng], 15, { duration: 1 });

                // Reset dulu supaya tidak ter-skip
                State.activeCampusId = null;
                await selectCampus(nearest.id, false, false);
            }
        });

            // ── Close dropdown on outside click ──
            document.addEventListener('click', (e) => {
                if (!e.target.closest('#search-section')) closeDropdown();
            });

            // ── Modal close ──
            document.getElementById('modal-close').addEventListener('click', closeModal);
            document.getElementById('modal-backdrop').addEventListener('click', closeModal);

            // ── Lihat semua ──
            document.getElementById('btn-lihat-semua').addEventListener('click', () => {
                window.location.href = '{{ route("semua-resto") }}';
            });

            // GPS tidak dijalankan otomatis;
            // user klik tombol GPS atau pilih kampus secara manual
        });
    </script>
@endpush