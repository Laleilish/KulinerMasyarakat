@extends('layouts.app')
@section('title', 'Hidden Gem - KUMAR')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
    @include('hidden-gem.search')
    @include('hidden-gem.kampus')
    @include('hidden-gem.map')
    @include('hidden-gem.rating')
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // ═══════════════════════════════════════════════════════════
        // CONFIG
        // ═══════════════════════════════════════════════════════════
        const CAMPUSES = @json($campusesData);
        const API_URL = '{{ url("/hidden-gem/restaurants") }}';
        const NOMINATIM = 'https://nominatim.openstreetmap.org';

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
                center: [-6.8612798, 107.5888298],
                zoom: 15,
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

            // Klik featured slide → buka modal
            track.querySelectorAll('.featured-slide').forEach(slide => {
                slide.addEventListener('click', () => {
                    try { openModal(JSON.parse(slide.dataset.resto)); } catch { }
                });
            });

            updateDots();
        })();

        // ════════════════════════════════════════════
        // TOP RESTO CARD CLICK (static dari server)
        // ════════════════════════════════════════════
        document.querySelectorAll('.top-resto-card').forEach(card => {
            card.addEventListener('click', () => {
                try { openModal(JSON.parse(card.dataset.resto)); } catch { }
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

            spinner.classList.toggle('hidden', !loading);
            icon.classList.toggle('hidden', loading);

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
        function renderUserLocation(lat, lng, accuracy = 50) {
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
                .bindPopup('<b>Lokasi Kamu</b>');
        }

        // ═══════════════════════════════════════════════════════════
        // RENDER RESTAURANT MARKERS
        // ═══════════════════════════════════════════════════════════
        function renderRestaurantMarkers(campus, restaurants) {
            State.markerLayer.clearLayers();

            // Marker kampus
            const campusIcon = L.divIcon({
                className: '',
                html: `<div style="width:36px;height:36px;background:#F5A623;border-radius:12px;
                                       border:2.5px solid #fff;box-shadow:0 3px 10px rgba(245,166,35,0.4);
                                       display:flex;align-items:center;justify-content:center;font-size:18px;">🏫</div>`,
                iconSize: [36, 36],
                iconAnchor: [18, 18],
            });

            L.marker([campus.latitude, campus.longitude], { icon: campusIcon })
                .addTo(State.markerLayer)
                .bindPopup(`<b style="font-size:13px;">${campus.name}</b>`)
                .openPopup();

            // Marker restoran
            restaurants.forEach(r => {
                const restoIcon = L.divIcon({
                    className: '',
                    html: `<div style="width:32px;height:32px;background:#02b176;border-radius:50%;
                                           border:2.5px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.18);
                                           display:flex;align-items:center;justify-content:center;font-size:15px;">🍜</div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -34],
                });

                const popupHTML = `
                        <div style="width:210px;font-family:'Plus Jakarta Sans',sans-serif;">
                            <img src="${r.image}" alt="${r.name}"
                                 style="width:100%;height:90px;object-fit:cover;border-radius:10px;margin-bottom:8px;
                                        display:block;">
                            <div style="font-weight:800;font-size:13px;color:#040818;margin-bottom:3px;">
                                ${r.name}
                            </div>
                            <div style="font-size:11px;color:#5d6e86;margin-bottom:6px;">
                                ${r.category} · ${r.distance}
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;
                                        margin-bottom:8px;">
                                <span style="color:#F5A623;font-size:12px;font-weight:700;">★ ${r.rating}</span>
                                <span style="font-size:11px;color:#5d6e86;">${r.price_range}</span>
                            </div>
                            <a href="https://www.google.com/maps?q=${r.latitude},${r.longitude}"
                               target="_blank"
                               style="display:flex;align-items:center;justify-content:center;gap:6px;
                                      background:#02b176;color:#fff;padding:8px;border-radius:99px;
                                      font-size:12px;font-weight:700;text-decoration:none;">
                                🗺️ Navigasi
                            </a>
                        </div>`;

                L.marker([r.latitude, r.longitude], { icon: restoIcon })
                    .addTo(State.markerLayer)
                    .bindPopup(popupHTML, { maxWidth: 230 });
            });
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
        function updateRestaurants(restaurants) {
    const grid     = document.getElementById('resto-cards');
    const skeleton = document.getElementById('cards-loading');

    if (!restaurants.length) {
        grid.innerHTML = `
            <div class="col-span-2 md:col-span-3 lg:col-span-4
                        text-center py-8 text-muted text-[13px]">
                Belum ada restoran di kampus ini.
            </div>`;
        return;
    }

    const cardHTML = (r) => `
        <div class="top-resto-card bg-white rounded-[16px] overflow-hidden
                    border border-black/[0.05]
                    shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                    cursor-pointer
                    transition-all duration-200
                    hover:-translate-y-[3px]
                    hover:shadow-[0_8px_24px_rgba(0,0,0,0.12)]
                    active:scale-[0.98]"
             data-resto='${JSON.stringify(r).replace(/'/g, "&#39;")}'>

            {{-- Image --}}
            <div class="relative w-full h-[130px] overflow-hidden">
                <img src="${r.image}"
                     alt="${r.name}"
                     class="w-full h-full object-cover
                            transition-transform duration-300"
                     onerror="this.src='/assets/img/resto/default.png'">

                {{-- Rating badge --}}
                <div class="absolute top-2 right-2">
                    <span style="
                        display:inline-flex;align-items:center;gap:3px;
                        background:rgba(0,0,0,0.3);color:#fff;
                        font-size:10px;font-weight:700;
                        padding:3px 7px;border-radius:99px;
                        backdrop-filter:blur(4px);
                    ">
                        ★ ${parseFloat(r.rating).toFixed(1)}
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

            {{-- Body --}}
            <div style="padding:10px 12px 12px;">
                <p style="
                    font-size:12px;font-weight:800;
                    color:#040818;line-height:1.4;
                    margin-bottom:3px;
                    display:-webkit-box;-webkit-line-clamp:2;
                    -webkit-box-orient:vertical;overflow:hidden;
                ">${r.name}</p>

                <p style="font-size:11px;color:#5d6e86;margin-bottom:7px;">
                    ${r.category}
                </p>

                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:11px;color:#02b176;font-weight:700;">
                        📍 ${r.distance}
                    </span>
                    <span style="font-size:10px;color:#5d6e86;">
                        ${r.price_range}
                    </span>
                </div>
            </div>
        </div>`;

    grid.innerHTML = `
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            ${restaurants.map(r => cardHTML(r)).join('')}
        </div>`;

    // Attach click listeners
    grid.querySelectorAll('.top-resto-card').forEach(card => {
        card.addEventListener('click', () => {
            try {
                openModal(JSON.parse(card.dataset.resto));
            } catch(e) {
                console.error('Parse error:', e);
            }
        });
    });
}

        // ═══════════════════════════════════════════════════════════
        // SELECT CAMPUS
        // ═══════════════════════════════════════════════════════════
        async function selectCampus(campusId, scroll = true) {
            if (State.activeCampusId === campusId) return;
            State.activeCampusId = campusId;

            // Update active UI
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
                if (!res.ok) throw new Error('Fetch error');
                const data = await res.json();

                updateMap(data.campus, data.restaurants);
                updateRestaurants(data.restaurants);

                document.getElementById('map-subtitle').textContent =
                    `${data.campus.name} · ${data.restaurants.length} hidden gem`;

            } catch (err) {
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

                    await selectCampus(nearest.id, false);
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
                label: reason + ' — ketik lokasi manual',
                value: '',
                error: true,
            });
            document.getElementById('loc-input').placeholder = 'Cari lokasi atau kampus...';
            // Default ke kampus pertama
            selectCampus(CAMPUSES[0].id, false);
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
        function openModal(r) {
            document.getElementById('modal-image').src = r.image;
            document.getElementById('modal-name').textContent = r.name;
            document.getElementById('modal-category').textContent = r.category;
            document.getElementById('modal-rating').textContent = `★ ${r.rating}`;
            document.getElementById('modal-distance').textContent = r.distance;
            document.getElementById('modal-desc').textContent = r.description;
            document.getElementById('modal-price').textContent = r.price_range;
            document.getElementById('modal-nav-btn').href =
                `https://www.google.com/maps?q=${r.latitude},${r.longitude}`;

            document.getElementById('resto-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
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
        // EVENT LISTENERS
        // ═══════════════════════════════════════════════════════════
        document.addEventListener('DOMContentLoaded', () => {
            initMap();

            // ── Kampus click ──
            document.querySelectorAll('.kampus-item').forEach(el => {
                el.addEventListener('click', () => selectCampus(parseInt(el.dataset.id), true));
            });

            // ── Search input ──
            const input = document.getElementById('loc-input');

            input.addEventListener('focus', () => openDropdown());

            input.addEventListener('input', (e) => handleSearchInput(e.target.value.trim()));

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') { closeDropdown(); input.blur(); }
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
                    await selectCampus(parseInt(id), true);
                } else {
                    // Lokasi dari Nominatim
                    const fLat = parseFloat(lat);
                    const fLng = parseFloat(lng);
                    const nearest = detectNearestCampus(fLat, fLng);
                    const distText = nearest.dist < 1
                        ? `${Math.round(nearest.dist * 1000)}m ke ${nearest.name.split(' ')[0]}`
                        : `${nearest.dist.toFixed(1)}km ke ${nearest.name.split(' ')[0]}`;

                    updateLocationBar({ label: distText, value: name });

                    State.map.flyTo([fLat, fLng], 15, { duration: 1 });
                    await selectCampus(nearest.id, false);
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

            // ── Start GPS ──
            detectUserLocation();
        });
    </script>
@endpush