<section class="px-5 mt-6 mb-4 w-full md:px-10">

    <h1 class="text-center text-[18px] md:text-2xl font-extrabold text-dark mb-4 tracking-tight">
        Duit Habis Diakhir Bulan?
    </h1>

    {{-- Banner Card --}}
    <div class="relative w-full bg-[#F5A623] rounded-[24px] md:rounded-[36px] shadow-md flex items-end md:items-stretch overflow-hidden mb-5 md:mb-8"
         style="min-height: 220px;">

        {{-- Left Image --}}
        <img
            src="{{ asset('storage/banner/tanggal-tua-banner.png') }}"
            alt="Tanggal Tua"
            class="relative z-10 self-end h-[160px] w-auto max-w-[45%] md:h-[280px] md:max-w-[320px] object-contain drop-shadow-md ml-0 md:ml-8 flex-shrink-0">

        {{-- Right Content --}}
        <div class="flex-1 flex flex-col justify-center px-4 md:px-10 py-5 md:py-8 text-right text-white z-20">
            <h2 class="font-extrabold text-[14px] md:text-3xl leading-tight mb-1 md:mb-2 text-dark">
                Fitur Tanggal Tua Hadir<br>Untuk Menyelamatkanmu!
            </h2>
            <p class="text-[10px] md:text-base font-semibold text-white mb-2 md:mb-4">
                Makan Enak Tanpa Biaya Lebih
            </p>
            <h3 class="text-[42px] md:text-8xl font-black leading-none text-[#5A3805] tracking-tighter mb-1 md:mb-3">
                &lt;15k
            </h3>
            <p class="text-[9px] md:text-sm font-semibold text-white leading-tight">
                Harga Terendah,<br>Makan Termewah
            </p>
        </div>

    </div>

    {{-- Location Bar — identik dengan Hidden Gem --}}
    <div id="location-bar-wrap" class="relative bg-white rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                border border-black/[0.06] transition-all duration-300 max-w-4xl w-full mx-auto md:-mt-14 z-30">

        {{-- Main bar --}}
        <div class="flex items-center gap-3 px-4 h-[54px]">

            {{-- Icon kiri --}}
            <div id="loc-icon-wrap" class="flex-shrink-0 w-5 flex items-center justify-center">
                <div id="loc-spinner" class="hidden w-4 h-4 rounded-full border-2 border-[#F5A623]
                            border-t-transparent animate-spin"></div>
                <i id="loc-icon" class="fas fa-location-dot text-[#F5A623] text-[16px]"></i>
            </div>

            {{-- Input --}}
            <div class="flex-1 flex flex-col justify-center min-w-0">
                <label id="loc-label" class="text-[9px] text-muted font-semibold uppercase
                              tracking-wider leading-none mb-[3px] transition-all duration-200">
                    Lokasi Kamu
                </label>
                <input id="loc-input" type="text" placeholder="Cari lokasi atau kampus..." autocomplete="off"
                       class="w-full border-none outline-none bg-transparent
                              text-[13px] font-semibold text-dark
                              placeholder:text-muted/50 placeholder:font-normal
                              transition-all duration-200">
            </div>

            {{-- Tombol clear --}}
            <button id="loc-clear" class="hidden flex-shrink-0 w-7 h-7 rounded-full
                           bg-black/[0.06] flex items-center justify-center
                           hover:bg-black/10 transition-colors duration-150">
                <i class="fas fa-xmark text-[12px] text-muted"></i>
            </button>

            {{-- GPS button --}}
            <button id="loc-gps-btn" title="Gunakan lokasi saya"
                    class="flex-shrink-0 w-8 h-8 rounded-full
                           bg-[#F5A623]/10 flex items-center justify-center
                           hover:bg-[#F5A623]/20 transition-colors duration-150">
                <i class="fas fa-crosshairs text-[#F5A623] text-[14px]"></i>
            </button>
        </div>

        {{-- Dropdown autocomplete --}}
        <div id="loc-dropdown" class="hidden absolute top-[calc(100%+6px)] left-0 right-0
                    bg-white border border-black/[0.08] rounded-2xl
                    shadow-[0_8px_32px_rgba(0,0,0,0.12)] z-[500]
                    overflow-hidden">

            {{-- Section: Kampus --}}
            <div id="dropdown-campus-section">
                <div class="px-4 py-2 text-[10px] font-bold text-muted uppercase tracking-wider
                            bg-black/[0.02] border-b border-black/[0.04]">
                    Kampus
                </div>
                <div id="dropdown-campus-list"></div>
            </div>

            {{-- Section: Hasil pencarian --}}
            <div id="dropdown-search-section" class="hidden">
                <div class="px-4 py-2 text-[10px] font-bold text-muted uppercase tracking-wider
                            bg-black/[0.02] border-b border-black/[0.04]">
                    Hasil Pencarian
                </div>
                <div id="dropdown-search-list"></div>
            </div>

            {{-- Loading state --}}
            <div id="dropdown-loading" class="hidden items-center gap-3 px-4 py-3">
                <div class="w-4 h-4 rounded-full border-2 border-[#F5A623]
                            border-t-transparent animate-spin flex-shrink-0"></div>
                <span class="text-[12px] text-muted">Mencari lokasi...</span>
            </div>

            {{-- Empty state --}}
            <div id="dropdown-empty" class="hidden px-4 py-4 text-center">
                <i class="fas fa-map-pin text-muted/40 text-[20px] mb-2 block"></i>
                <p class="text-[12px] text-muted">Lokasi tidak ditemukan</p>
            </div>
        </div>

    </div>

</section>

@push('scripts')
<script>
(function() {
    const CAMPUSES    = @json($campusesData);
    const NOMINATIM   = 'https://nominatim.openstreetmap.org';
    let   searchTimer = null;
    let   isDropdownOpen = false;

    // ─────────────────────────────────────────────────────────────────
    // UPDATE LOCATION BAR UI
    // ─────────────────────────────────────────────────────────────────
    function updateLocationBar({ label, value, loading = false, error = false }) {
        const spinner = document.getElementById('loc-spinner');
        const icon    = document.getElementById('loc-icon');
        const labelEl = document.getElementById('loc-label');
        const input   = document.getElementById('loc-input');

        if (loading) {
            spinner.classList.remove('hidden');
            icon.classList.add('hidden');
        } else {
            spinner.classList.add('hidden');
            icon.classList.remove('hidden');
        }
        if (label !== undefined) labelEl.textContent = label;
        if (value !== undefined && value !== null) input.value = value;
        icon.style.color = error ? '#f87171' : '#F5A623';
    }

    // ─────────────────────────────────────────────────────────────────
    // UPDATE CAMPUS BADGE (di section category)
    // ─────────────────────────────────────────────────────────────────
    function updateCampusBadge(name) {
        const badge     = document.getElementById('tt-campus-badge');
        const nameEl    = document.getElementById('tt-campus-name');
        if (!badge || !nameEl) return;

        if (name) {
            nameEl.textContent = name;
            badge.classList.remove('hidden');
            badge.classList.add('flex');
        } else {
            badge.classList.add('hidden');
            badge.classList.remove('flex');
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // SELECT CAMPUS → trigger filter cards
    // ─────────────────────────────────────────────────────────────────
    function selectCampus(campusId, campusName) {
        updateLocationBar({ label: 'Kampus dipilih', value: campusName });
        updateCampusBadge(campusName);
        closeDropdown();

        // Panggil fungsi filter dari cards.blade.php
        if (typeof window.TT_selectCampus === 'function') {
            window.TT_selectCampus(campusId);
        }
    }

    function clearCampus() {
        updateLocationBar({ label: 'Lokasi Kamu', value: '' });
        document.getElementById('loc-clear').classList.add('hidden');
        updateCampusBadge(null);

        if (typeof window.TT_clearCampus === 'function') {
            window.TT_clearCampus();
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
            const res = await fetch(
                `${NOMINATIM}/search?q=${encodeURIComponent(query)}&format=json&countrycodes=id&limit=5&accept-language=id`
            );
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
        const list    = document.getElementById('dropdown-campus-list');
        const section = document.getElementById('dropdown-campus-section');
        const filtered = query
            ? CAMPUSES.filter(c => c.name.toLowerCase().includes(query.toLowerCase()))
            : CAMPUSES;

        if (!filtered.length) { section.classList.add('hidden'); return; }

        section.classList.remove('hidden');
        list.innerHTML = filtered.map(c => `
            <div class="dropdown-item flex items-center gap-3 px-4 py-3
                        hover:bg-black/[0.03] cursor-pointer transition-colors duration-100"
                 data-type="campus" data-id="${c.id}" data-name="${c.name}">
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
        const list    = document.getElementById('dropdown-search-list');
        if (!results.length) { section.classList.add('hidden'); return; }

        section.classList.remove('hidden');
        list.innerHTML = results.map(r => {
            const nameParts  = r.display_name.split(',');
            const shortName  = nameParts[0];
            const subName    = nameParts.slice(1, 3).join(',');
            return `
            <div class="dropdown-item flex items-center gap-3 px-4 py-3
                        hover:bg-black/[0.03] cursor-pointer transition-colors duration-100"
                 data-type="location" data-lat="${r.lat}" data-lng="${r.lon}"
                 data-name="${nameParts.slice(0,2).join(',')}">
                <div class="w-8 h-8 rounded-full bg-[#F5EDE0] flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-map-pin text-[#C07A2A] text-[13px]"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[12px] font-bold text-dark truncate">${shortName}</p>
                    <p class="text-[10px] text-muted truncate">${subName}</p>
                </div>
            </div>`;
        }).join('');
    }

    function openDropdown() {
        document.getElementById('loc-dropdown').classList.remove('hidden');
        isDropdownOpen = true;
        renderDropdownCampus();
        document.getElementById('dropdown-empty').classList.add('hidden');
    }

    function closeDropdown() {
        document.getElementById('loc-dropdown').classList.add('hidden');
        isDropdownOpen = false;
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

        renderDropdownCampus(query);

        clearTimeout(searchTimer);
        searchTimer = setTimeout(async () => {
            document.getElementById('dropdown-loading').classList.remove('hidden');
            document.getElementById('dropdown-empty').classList.add('hidden');
            const results = await searchLocation(query);
            document.getElementById('dropdown-loading').classList.add('hidden');

            if (!results.length) {
                const campusSec = document.getElementById('dropdown-campus-section');
                if (campusSec.classList.contains('hidden')) {
                    document.getElementById('dropdown-empty').classList.remove('hidden');
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
                const distText  = nearest.dist < 1
                    ? `${Math.round(nearest.dist * 1000)}m`
                    : `${nearest.dist.toFixed(1)}km`;

                updateLocationBar({
                    label: `Dekat ${nearest.name.split(' ').slice(0,2).join(' ')} · ${distText}`,
                    value: placeName || nearest.name,
                });

                // Auto-select kampus terdekat
                selectCampus(nearest.id, nearest.name);
            },
            (err) => {
                const msgs = { 1: 'Izin ditolak', 2: 'Lokasi tidak tersedia', 3: 'Timeout' };
                updateLocationBar({
                    label: (msgs[err.code] || 'GPS gagal') + ' — ketik lokasi atau pilih kampus',
                    value: '',
                    error: true,
                });
                document.getElementById('loc-input').focus();
                openDropdown();
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
        );
    }

    // ─────────────────────────────────────────────────────────────────
    // EVENT LISTENERS
    // ─────────────────────────────────────────────────────────────────
    const input   = document.getElementById('loc-input');
    const clearBtn = document.getElementById('loc-clear');
    const gpsBtn  = document.getElementById('loc-gps-btn');
    const barWrap = document.getElementById('location-bar-wrap');

    // Input focus → buka dropdown
    input.addEventListener('focus', () => openDropdown());

    // Input typing → filter + search
    input.addEventListener('input', (e) => handleSearchInput(e.target.value.trim()));

    // Clear → reset lokasi & kampus filter
    clearBtn.addEventListener('click', () => {
        input.value = '';
        clearBtn.classList.add('hidden');
        handleSearchInput('');
        clearCampus();
        input.focus();
    });

    // GPS
    gpsBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        closeDropdown();
        detectUserLocation();
    });

    // Klik luar → tutup dropdown
    document.addEventListener('click', (e) => {
        if (!barWrap.contains(e.target)) closeDropdown();
    });

    // Klik item dropdown
    barWrap.addEventListener('click', (e) => {
        const item = e.target.closest('.dropdown-item');
        if (!item) return;

        const type = item.dataset.type;
        const name = item.dataset.name;

        if (type === 'campus') {
            const campusId = parseInt(item.dataset.id, 10);
            selectCampus(campusId, name);
        } else {
            // Lokasi hasil pencarian (bukan kampus) — hanya update UI, tidak filter per kampus
            updateLocationBar({ label: 'Lokasi dipilih', value: name });
            closeDropdown();
        }
    });

    // ─────────────────────────────────────────────────────────────────
    // CAMPUS BADGE CLEAR BUTTON (di category.blade.php)
    // ─────────────────────────────────────────────────────────────────
    document.addEventListener('click', (e) => {
        if (e.target.closest('#tt-campus-clear')) {
            clearCampus();
        }
    });

})();
</script>
@endpush