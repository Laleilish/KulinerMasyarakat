<section class="bg-[#EF950F] rounded-3xl px-5 py-10 md:px-10 md:py-[30px] flex flex-col md:flex-row items-center justify-between min-h-[200px] relative m-4">

    <div class="z-10 w-full">
        <img
            class="hidden md:block w-20 h-auto"
            style="margin: 0 13%"
            src="{{ asset('assets/img/Header/icon-kumar-white.png') }}"
            alt="Icon Kumar"
        >
        <h1 class="text-2xl md:text-5xl font-bold text-dark leading-tight">Bingung Mau Makan Apa?</h1>
        <h1 class="text-2xl md:text-5xl font-bold text-dark leading-tight">KU<span class="text-red-logo">MAR</span>-in Aja</h1>
        <p class="text-dark text-sm md:text-base leading-relaxed mt-2 mb-4">
            Temukan tempat makan hidden gem, yang pas dengan dompetmu.<br>
            Cepat, hemat, dan banyak pilihan!
        </p>

        {{-- Dynamic Location Bar --}}
        <div id="home-location-bar-wrap" class="relative bg-white rounded-xl w-full md:max-w-[50%] p-3 shadow-md">
            <label id="home-loc-label" class="text-xs font-semibold text-dark block mb-2 transition-all duration-200">
                Lokasi Kamu
            </label>
            <div class="flex flex-row gap-2 md:gap-3 items-center">
                <div class="flex items-center gap-2 border border-gray-300 rounded-xl flex-1 px-3 py-2 bg-white">
                    <div id="home-loc-spinner" class="hidden w-4 h-4 rounded-full border-2 border-[#F5A623] border-t-transparent animate-spin"></div>
                    <i id="home-loc-icon" class="fa-solid fa-location-dot text-[#F5A623] shrink-0"></i>
                    <input
                        id="home-loc-input"
                        type="text"
                        placeholder="Cari lokasi atau kampus..."
                        autocomplete="off"
                        class="border-none outline-none flex-1 text-sm text-dark bg-transparent placeholder:text-muted-light"
                    >
                    <button id="home-loc-clear" class="hidden text-muted hover:text-dark transition-colors">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
                
                {{-- GPS button --}}
                <button id="home-loc-gps-btn" title="Gunakan lokasi saya" class="bg-[#F5A623]/10 hover:bg-[#F5A623]/20 text-[#F5A623] border-none rounded-xl flex items-center justify-center shrink-0 w-10 h-10 transition-colors">
                    <i class="fas fa-crosshairs text-lg"></i>
                </button>
            </div>

            {{-- Dropdown autocomplete --}}
            <div id="home-loc-dropdown" class="hidden absolute top-[calc(100%+6px)] left-0 right-0 bg-white border border-black/[0.08] rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.12)] z-[500] overflow-hidden">
                <div id="home-dropdown-campus-section">
                    <div class="px-4 py-2 text-[10px] font-bold text-muted uppercase tracking-wider bg-black/[0.02] border-b border-black/[0.04]">Kampus</div>
                    <div id="home-dropdown-campus-list"></div>
                </div>
                <div id="home-dropdown-search-section" class="hidden">
                    <div class="px-4 py-2 text-[10px] font-bold text-muted uppercase tracking-wider bg-black/[0.02] border-b border-black/[0.04]">Hasil Pencarian</div>
                    <div id="home-dropdown-search-list"></div>
                </div>
                <div id="home-dropdown-loading" class="hidden flex items-center gap-3 px-4 py-3">
                    <div class="w-4 h-4 rounded-full border-2 border-[#F5A623] border-t-transparent animate-spin flex-shrink-0"></div>
                    <span class="text-[12px] text-muted">Mencari lokasi...</span>
                </div>
                <div id="home-dropdown-empty" class="hidden px-4 py-4 text-center">
                    <i class="fas fa-map-pin text-muted/40 text-[20px] mb-2 block"></i>
                    <p class="text-[12px] text-muted">Lokasi tidak ditemukan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute inset-0 rounded-3xl overflow-hidden pointer-events-none z-0">
        <img
            class="hidden md:block absolute rounded-full object-cover w-[20%] aspect-square top-[-20%] left-[-2%]"
            src="{{ asset('assets/img/Header/image1.png') }}"
            alt="food"
            loading="lazy"
        >
        <img
            class="hidden md:block absolute rounded-full object-cover w-[20%] aspect-square top-[-10%] right-[16%]"
            src="{{ asset('assets/img/Header/image2.png') }}"
            alt="food"
            loading="lazy"
        >
        <img
            class="hidden md:block absolute rounded-full object-cover w-[22%] aspect-square top-[10%] right-[-5%]"
            src="{{ asset('assets/img/Header/image3.png') }}"
            alt="food"
            loading="lazy"
        >
        <img
            class="hidden md:block absolute rounded-full object-cover w-[25%] aspect-square bottom-[8%] right-[20%]"
            src="{{ asset('assets/img/Header/image4.png') }}"
            alt="food"
            loading="lazy"
        >
        <img
            class="hidden md:block absolute rounded-full object-cover w-[20%] aspect-square bottom-[-13%] right-[-2%]"
            src="{{ asset('assets/img/Header/image6.png') }}"
            alt="food"
            loading="lazy"
        >
    </div>

</section>

@push('scripts')
<script>
(function() {
    // Pastikan data campuses dikirim dari controller
    const CAMPUSES    = @json($campusesData ?? []);
    const NOMINATIM   = 'https://nominatim.openstreetmap.org';
    let   searchTimer = null;
    let   isDropdownOpen = false;

    function updateLocationBar({ label, value, loading = false, error = false }) {
        const spinner = document.getElementById('home-loc-spinner');
        const icon    = document.getElementById('home-loc-icon');
        const labelEl = document.getElementById('home-loc-label');
        const input   = document.getElementById('home-loc-input');

        if (loading) {
            spinner.classList.remove('hidden');
            icon.classList.add('hidden');
        } else {
            spinner.classList.add('hidden');
            icon.classList.remove('hidden');
        }
        if (label !== undefined) labelEl.textContent = label;
        if (value !== undefined && value !== null) input.value = value;
        
        // Colors mapping
        if (error) {
            icon.classList.remove('text-[#F5A623]');
            icon.classList.add('text-red-400');
        } else {
            icon.classList.add('text-[#F5A623]');
            icon.classList.remove('text-red-400');
        }
    }

    function selectCampus(campusId, campusName) {
        updateLocationBar({ label: 'Kampus dipilih', value: campusName });
        closeDropdown();

        if (typeof window.HOME_selectCampus === 'function') {
            window.HOME_selectCampus(campusId, campusName);
        }
    }

    function clearCampus() {
        updateLocationBar({ label: 'Lokasi Kamu', value: '' });
        document.getElementById('home-loc-clear').classList.add('hidden');
        if (typeof window.HOME_clearCampus === 'function') {
            window.HOME_clearCampus();
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // NOMINATIM
    // ─────────────────────────────────────────────────────────────────
    async function reverseGeocode(lat, lng) {
        try {
            const res  = await fetch(`${NOMINATIM}/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=id`);
            const data = await res.json();
            const addr = data.address;
            return addr.neighbourhood || addr.suburb || addr.city_district || addr.city || addr.state || 'Lokasi Ditemukan';
        } catch { return null; }
    }

    async function searchLocation(query) {
        try {
            const res = await fetch(`${NOMINATIM}/search?q=${encodeURIComponent(query)}&format=json&countrycodes=id&limit=5&accept-language=id`);
            return await res.json();
        } catch { return []; }
    }

    // ─────────────────────────────────────────────────────────────────
    // HAVERSINE
    // ─────────────────────────────────────────────────────────────────
    function haversine(lat1, lng1, lat2, lng2) {
        const R    = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a    = Math.sin(dLat/2)**2 + Math.cos(lat1*Math.PI/180)*Math.cos(lat2*Math.PI/180)*Math.sin(dLng/2)**2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    }

    function detectNearestCampus(lat, lng) {
        return CAMPUSES.reduce((nearest, c) => {
            const dist = haversine(lat, lng, c.latitude, c.longitude);
            return dist < nearest.dist ? { ...c, dist } : nearest;
        }, { dist: Infinity });
    }

    // ─────────────────────────────────────────────────────────────────
    // DROPDOWN
    // ─────────────────────────────────────────────────────────────────
    function renderDropdownCampus(query = '') {
        const list    = document.getElementById('home-dropdown-campus-list');
        const section = document.getElementById('home-dropdown-campus-section');
        const filtered = query
            ? CAMPUSES.filter(c => c.name.toLowerCase().includes(query.toLowerCase()))
            : CAMPUSES;

        if (!filtered.length) { section.classList.add('hidden'); return; }

        section.classList.remove('hidden');
        list.innerHTML = filtered.map(c => `
            <div class="home-dropdown-item flex items-center gap-3 px-4 py-3 hover:bg-black/[0.03] cursor-pointer transition-colors duration-100" data-type="campus" data-id="${c.id}" data-name="${c.name}">
                <div class="w-8 h-8 rounded-[10px] bg-[#F5A623] flex items-center justify-center flex-shrink-0 overflow-hidden">
                    <img src="${c.logo}" alt="${c.name}" class="w-6 h-6 object-contain" onerror="this.style.display='none'">
                </div>
                <div>
                    <p class="text-[12px] font-bold text-dark">${c.name}</p>
                    <p class="text-[10px] text-muted">Kampus</p>
                </div>
            </div>`).join('');
    }

    function renderDropdownSearch(results) {
        const section = document.getElementById('home-dropdown-search-section');
        const list    = document.getElementById('home-dropdown-search-list');
        if (!results.length) { section.classList.add('hidden'); return; }

        section.classList.remove('hidden');
        list.innerHTML = results.map(r => {
            const nameParts  = r.display_name.split(',');
            return `
            <div class="home-dropdown-item flex items-center gap-3 px-4 py-3 hover:bg-black/[0.03] cursor-pointer transition-colors duration-100" data-type="location" data-name="${nameParts.slice(0,2).join(',')}">
                <div class="w-8 h-8 rounded-full bg-[#F5A623]/10 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-map-pin text-[#F5A623] text-[13px]"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[12px] font-bold text-dark truncate">${nameParts[0]}</p>
                    <p class="text-[10px] text-muted truncate">${nameParts.slice(1, 3).join(',')}</p>
                </div>
            </div>`;
        }).join('');
    }

    function openDropdown() {
        document.getElementById('home-loc-dropdown').classList.remove('hidden');
        isDropdownOpen = true;
        renderDropdownCampus();
        document.getElementById('home-dropdown-empty').classList.add('hidden');
    }

    function closeDropdown() {
        document.getElementById('home-loc-dropdown').classList.add('hidden');
        isDropdownOpen = false;
    }

    async function handleSearchInput(query) {
        const clearBtn = document.getElementById('home-loc-clear');
        clearBtn.classList.toggle('hidden', !query);

        if (!query) {
            renderDropdownCampus();
            document.getElementById('home-dropdown-search-section').classList.add('hidden');
            document.getElementById('home-dropdown-empty').classList.add('hidden');
            document.getElementById('home-dropdown-loading').classList.add('hidden');
            return;
        }

        renderDropdownCampus(query);

        clearTimeout(searchTimer);
        searchTimer = setTimeout(async () => {
            document.getElementById('home-dropdown-loading').classList.remove('hidden');
            document.getElementById('home-dropdown-empty').classList.add('hidden');
            const results = await searchLocation(query);
            document.getElementById('home-dropdown-loading').classList.add('hidden');

            if (!results.length) {
                if (document.getElementById('home-dropdown-campus-section').classList.contains('hidden')) {
                    document.getElementById('home-dropdown-empty').classList.remove('hidden');
                }
            } else {
                renderDropdownSearch(results);
            }
        }, 500);
    }

    // ─────────────────────────────────────────────────────────────────
    // GEOLOCATION
    // ─────────────────────────────────────────────────────────────────
    function detectUserLocation() {
        updateLocationBar({ label: 'Mendeteksi lokasi...', value: '', loading: true });
        if (!navigator.geolocation) {
            updateLocationBar({ label: 'GPS tidak didukung', value: '', error: true });
            return;
        }
        navigator.geolocation.getCurrentPosition(
            async (pos) => {
                const { latitude: lat, longitude: lng } = pos.coords;
                const placeName = await reverseGeocode(lat, lng);
                const nearest   = detectNearestCampus(lat, lng);
                const distText  = nearest.dist < 1 ? `${Math.round(nearest.dist * 1000)}m` : `${nearest.dist.toFixed(1)}km`;

                updateLocationBar({
                    label: `Dekat ${nearest.name.split(' ').slice(0,2).join(' ')} · ${distText}`,
                    value: placeName || nearest.name,
                });

                selectCampus(nearest.id, nearest.name);
            },
            (err) => {
                const msgs = { 1: 'Izin ditolak', 2: 'Lokasi tidak tersedia', 3: 'Timeout' };
                updateLocationBar({
                    label: (msgs[err.code] || 'GPS gagal') + ' — ketik lokasi atau pilih kampus',
                    value: '',
                    error: true,
                });
                document.getElementById('home-loc-input').focus();
                openDropdown();
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
        );
    }

    // ─────────────────────────────────────────────────────────────────
    // EVENT LISTENERS
    // ─────────────────────────────────────────────────────────────────
    const input   = document.getElementById('home-loc-input');
    const clearBtn = document.getElementById('home-loc-clear');
    const gpsBtn  = document.getElementById('home-loc-gps-btn');
    const barWrap = document.getElementById('home-location-bar-wrap');

    input.addEventListener('focus', () => openDropdown());
    input.addEventListener('input', (e) => handleSearchInput(e.target.value.trim()));

    clearBtn.addEventListener('click', () => {
        input.value = '';
        clearBtn.classList.add('hidden');
        handleSearchInput('');
        clearCampus();
        input.focus();
    });

    gpsBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        closeDropdown();
        detectUserLocation();
    });

    document.addEventListener('click', (e) => {
        if (!barWrap.contains(e.target)) closeDropdown();
    });

    barWrap.addEventListener('click', (e) => {
        const item = e.target.closest('.home-dropdown-item');
        if (!item) return;

        const type = item.dataset.type;
        const name = item.dataset.name;

        if (type === 'campus') {
            const campusId = parseInt(item.dataset.id, 10);
            selectCampus(campusId, name);
        } else {
            updateLocationBar({ label: 'Lokasi dipilih', value: name });
            closeDropdown();
        }
    });

})();
</script>
@endpush
