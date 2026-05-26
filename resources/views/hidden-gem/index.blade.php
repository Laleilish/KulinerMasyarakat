@extends('layouts.app')
@section('title', 'Hidden Gem - KUMAR')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
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
// ═══════════════════════════════════════════════
// DATA DARI LARAVEL
// ═══════════════════════════════════════════════
const CAMPUSES = @json($campusesData);

const API_URL = '{{ route("hidden-gem.restaurants", ["campus_id" => "__ID__"]) }}';

// ═══════════════════════════════════════════════
// STATE
// ═══════════════════════════════════════════════
const State = {
    activeCampusId : null,
    userLat        : null,
    userLng        : null,
    map            : null,
    markerLayer    : null,
    userMarker     : null,
};

// ═══════════════════════════════════════════════
// HAVERSINE — hitung jarak (km) antara 2 koordinat
// ═══════════════════════════════════════════════
function haversine(lat1, lng1, lat2, lng2) {
    const R   = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a   = Math.sin(dLat / 2) ** 2
              + Math.cos(lat1 * Math.PI / 180)
              * Math.cos(lat2 * Math.PI / 180)
              * Math.sin(dLng / 2) ** 2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
}

// ═══════════════════════════════════════════════
// DETECT NEAREST CAMPUS
// ═══════════════════════════════════════════════
function detectNearestCampus(userLat, userLng) {
    let nearest = null;
    let minDist = Infinity;

    CAMPUSES.forEach(campus => {
        const dist = haversine(userLat, userLng, campus.latitude, campus.longitude);
        if (dist < minDist) {
            minDist = dist;
            nearest = { ...campus, distKm: dist };
        }
    });

    return nearest;
}

// ═══════════════════════════════════════════════
// UPDATE LOCATION BAR
// ═══════════════════════════════════════════════
function updateLocationBar({ label, value, badge, loading = false, error = false }) {
    const spinner    = document.getElementById('loc-spinner');
    const icon       = document.getElementById('loc-icon');
    const labelEl    = document.getElementById('loc-label');
    const valueEl    = document.getElementById('loc-value');
    const badgeEl    = document.getElementById('loc-badge');
    const badgeText  = document.getElementById('loc-badge-text');
    const bar        = document.getElementById('location-bar');

    // Loading state
    spinner.classList.toggle('hidden', !loading);
    icon.classList.toggle('hidden', loading);

    labelEl.textContent = label;
    valueEl.textContent = value;

    if (badge) {
        badgeEl.classList.remove('hidden');
        badgeText.textContent = badge;
    } else {
        badgeEl.classList.add('hidden');
    }

    // Error styling
    if (error) {
        bar.classList.add('border-red-200');
        icon.classList.replace('text-[#F5A623]', 'text-red-400');
    } else {
        bar.classList.remove('border-red-200');
        icon.classList.remove('text-red-400');
        icon.classList.add('text-[#F5A623]');
    }
}

// ═══════════════════════════════════════════════
// INIT MAP
// ═══════════════════════════════════════════════
function initMap() {
    const defaultCampus = CAMPUSES[0];

    State.map = L.map('leaflet-map', {
        center          : [defaultCampus.latitude, defaultCampus.longitude],
        zoom            : defaultCampus.zoom,
        zoomControl     : true,
        scrollWheelZoom : false,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
    }).addTo(State.map);

    State.markerLayer = L.layerGroup().addTo(State.map);
}

// ═══════════════════════════════════════════════
// UPDATE MAP
// ═══════════════════════════════════════════════
function updateMap(campus, restaurants) {
    // Fly to kampus
    State.map.flyTo([campus.latitude, campus.longitude], campus.zoom, {
        duration       : 1.2,
        easeLinearity  : 0.25,
    });

    // Clear markers
    State.markerLayer.clearLayers();

    // Marker user (jika ada)
    if (State.userLat && State.userLng) {
        if (State.userMarker) State.userMarker.remove();
        const userIcon = L.divIcon({
            className : '',
            html      : `<div style="width:14px;height:14px;background:#3B82F6;border-radius:50%;border:2.5px solid #fff;box-shadow:0 0 0 4px rgba(59,130,246,0.25);"></div>`,
            iconSize  : [14, 14],
            iconAnchor: [7, 7],
        });
        State.userMarker = L.marker([State.userLat, State.userLng], { icon: userIcon })
            .addTo(State.map)
            .bindPopup('<b>Lokasi Kamu</b>');
    }

    // Marker kampus
    const campusIcon = L.divIcon({
        className : '',
        html      : `<div style="width:36px;height:36px;background:#F5A623;border-radius:12px;border:2.5px solid #fff;box-shadow:0 3px 10px rgba(245,166,35,0.4);display:flex;align-items:center;justify-content:center;font-size:18px;">🏫</div>`,
        iconSize  : [36, 36],
        iconAnchor: [18, 18],
    });

    L.marker([campus.latitude, campus.longitude], { icon: campusIcon })
     .addTo(State.markerLayer)
     .bindPopup(`<b style="font-size:13px;">${campus.name}</b>`)
     .openPopup();

    // Marker restoran
    restaurants.forEach(r => {
        const restoIcon = L.divIcon({
            className : '',
            html      : `<div style="width:32px;height:32px;background:#02b176;border-radius:50%;border:2.5px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.18);display:flex;align-items:center;justify-content:center;font-size:15px;">🍜</div>`,
            iconSize  : [32, 32],
            iconAnchor: [16, 32],
            popupAnchor:[0, -34],
        });

        const popupHTML = `
            <div style="width:210px;font-family:'Plus Jakarta Sans',sans-serif;">
                <img src="${r.image}" alt="${r.name}"
                     style="width:100%;height:90px;object-fit:cover;border-radius:10px;margin-bottom:8px;">
                <div style="font-weight:800;font-size:13px;color:#040818;margin-bottom:3px;">${r.name}</div>
                <div style="font-size:11px;color:#5d6e86;margin-bottom:6px;">${r.category} · ${r.distance}</div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
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

// ═══════════════════════════════════════════════
// UPDATE RESTAURANT CARDS
// ═══════════════════════════════════════════════
function updateRestaurants(restaurants) {
    const grid = document.getElementById('resto-cards');

    if (!restaurants.length) {
        grid.innerHTML = `
            <p class="text-center text-muted text-[13px] py-8">
                Belum ada restoran di kampus ini.
            </p>`;
        return;
    }

    const cardHTML = (r, size = 'horizontal') => {
        if (size === 'horizontal') return `
            <div class="resto-card bg-white rounded-[16px] overflow-hidden
                        border border-black/[0.05] shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                        cursor-pointer transition-all duration-200
                        hover:-translate-y-[3px] hover:shadow-[0_8px_24px_rgba(0,0,0,0.10)]
                        active:scale-[0.98]"
                 data-resto='${JSON.stringify(r)}'>
                <div class="flex items-stretch">
                    <img src="${r.image}" alt="${r.name}"
                         class="w-[90px] h-[90px] object-cover flex-shrink-0">
                    <div class="flex-1 flex flex-col justify-between p-3">
                        <p class="text-[11px] font-extrabold text-[#6B4423] leading-[1.35] mb-1 line-clamp-2">${r.name}</p>
                        <div class="flex gap-1 flex-wrap mb-1">
                            <span class="bg-[#F5EDE0] text-[#C07A2A] text-[9px] font-bold px-2 py-[2px] rounded-full">${r.category}</span>
                            <span class="bg-[#F5EDE0] text-[#C07A2A] text-[9px] font-bold px-2 py-[2px] rounded-full">${r.distance}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[#F5A623] text-[11px] font-bold">★ ${r.rating}</span>
                            <span class="text-[10px] text-muted">${r.price_range}</span>
                        </div>
                    </div>
                </div>
            </div>`;

        return `
            <div class="resto-card flex flex-col bg-white rounded-[16px] overflow-hidden
                        border border-black/[0.05] shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                        cursor-pointer transition-all duration-200
                        hover:-translate-y-[3px] hover:shadow-[0_8px_24px_rgba(0,0,0,0.10)]
                        active:scale-[0.98]"
                 data-resto='${JSON.stringify(r)}'>
                <img src="${r.image}" alt="${r.name}"
                     class="w-full h-[75px] object-cover">
                <div class="p-2 flex flex-col flex-1">
                    <p class="text-[10px] font-extrabold text-[#6B4423] mb-1 leading-[1.35] line-clamp-2">${r.name}</p>
                    <span class="bg-[#F5EDE0] text-[#C07A2A] text-[9px] font-bold px-2 py-[2px] rounded-full w-fit mb-1">${r.category}</span>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-[#F5A623] text-[10px] font-bold">★ ${r.rating}</span>
                        <span class="text-[9px] text-muted">${r.distance}</span>
                    </div>
                </div>
            </div>`;
    };

    grid.innerHTML = `
        <div class="grid grid-cols-2 gap-3 mb-3">
            ${restaurants.slice(0, 2).map(r => cardHTML(r, 'horizontal')).join('')}
        </div>
        <div class="grid grid-cols-3 gap-3">
            ${restaurants.slice(2, 5).map(r => cardHTML(r, 'vertical')).join('')}
        </div>`;

    // Attach event listeners ke card
    grid.querySelectorAll('.resto-card').forEach(card => {
        card.addEventListener('click', () => {
            const r = JSON.parse(card.dataset.resto);
            openModal(r);
        });
    });
}

// ═══════════════════════════════════════════════
// SELECT CAMPUS
// ═══════════════════════════════════════════════
async function selectCampus(campusId, scroll = true) {
    State.activeCampusId = campusId;

    // Update active state UI kampus
    document.querySelectorAll('.kampus-item').forEach(el => {
        const isActive = parseInt(el.dataset.id) === campusId;
        const icon     = el.querySelector('.kampus-icon-wrap');
        const label    = el.querySelector('.kampus-label');

        icon.classList.toggle('ring-4',          isActive);
        icon.classList.toggle('ring-[#F5A623]',  isActive);
        icon.classList.toggle('ring-offset-2',   isActive);
        icon.classList.toggle('scale-110',       isActive);
        icon.classList.toggle('opacity-60',      !isActive);
        label.classList.toggle('text-[#6B4423]', isActive);
        label.classList.toggle('font-extrabold', isActive);
        label.classList.toggle('text-muted',     !isActive);
        label.classList.toggle('font-medium',    !isActive);
    });

    // Show loading
    setLoading(true);

    try {
        const url = API_URL.replace('__ID__', campusId);
        const res = await fetch(url);
        if (!res.ok) throw new Error('Fetch gagal');
        const data = await res.json();

        updateMap(data.campus, data.restaurants);
        updateRestaurants(data.restaurants);

        document.getElementById('map-subtitle').textContent =
            `${data.campus.name} · ${data.restaurants.length} hidden gem`;

    } catch (err) {
        console.error(err);
        document.getElementById('resto-cards').innerHTML = `
            <p class="text-center text-red-400 text-[13px] py-8">
                Gagal memuat data. Silakan coba lagi.
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

// ═══════════════════════════════════════════════
// GEOLOCATION — DETECT USER LOCATION
// ═══════════════════════════════════════════════
function startGeolocation() {
    updateLocationBar({
        label   : 'Mendeteksi lokasi...',
        value   : 'Mohon izinkan akses GPS',
        loading : true,
    });

    if (!navigator.geolocation) {
        handleLocationFallback('GPS tidak didukung browser ini');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        onLocationSuccess,
        onLocationError,
        { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
    );
}

function onLocationSuccess(position) {
    State.userLat = position.coords.latitude;
    State.userLng = position.coords.longitude;

    const nearest  = detectNearestCampus(State.userLat, State.userLng);
    const distText = nearest.distKm < 1
        ? `${Math.round(nearest.distKm * 1000)}m dari kamu`
        : `${nearest.distKm.toFixed(1)}km dari kamu`;

    updateLocationBar({
        label : 'Kampus terdekat',
        value : nearest.name,
        badge : distText,
    });

    selectCampus(nearest.id, false);
}

function onLocationError(err) {
    const messages = {
        1: 'Izin lokasi ditolak',
        2: 'Lokasi tidak tersedia',
        3: 'Waktu deteksi habis',
    };
    handleLocationFallback(messages[err.code] || 'Gagal mendapat lokasi');
}

function handleLocationFallback(reason) {
    const fallback = CAMPUSES[0];

    updateLocationBar({
        label : reason,
        value : `Default: ${fallback.name}`,
        badge : 'Manual',
        error : true,
    });

    selectCampus(fallback.id, false);
}

// ═══════════════════════════════════════════════
// MODAL DETAIL RESTORAN
// ═══════════════════════════════════════════════
function openModal(r) {
    document.getElementById('modal-image').src              = r.image;
    document.getElementById('modal-name').textContent       = r.name;
    document.getElementById('modal-category').textContent   = r.category;
    document.getElementById('modal-rating').textContent     = `★ ${r.rating}`;
    document.getElementById('modal-distance').textContent   = r.distance;
    document.getElementById('modal-desc').textContent       = r.description;
    document.getElementById('modal-price').textContent      = r.price_range;
    document.getElementById('modal-nav-btn').href =
        `https://www.google.com/maps?q=${r.latitude},${r.longitude}`;

    document.getElementById('resto-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('resto-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

// ═══════════════════════════════════════════════
// LOADING STATE
// ═══════════════════════════════════════════════
function setLoading(show) {
    const overlay   = document.getElementById('map-loading');
    const skeleton  = document.getElementById('cards-loading');
    const cardsWrap = document.getElementById('resto-cards');

    overlay.style.opacity       = show ? '1' : '0';
    overlay.style.pointerEvents = show ? 'all' : 'none';
    skeleton.style.display      = show ? 'flex' : 'none';
    cardsWrap.style.opacity     = show ? '0.3' : '1';
}

// ═══════════════════════════════════════════════
// EVENT LISTENERS
// ═══════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
    // Init map
    initMap();

    // Kampus click
    document.querySelectorAll('.kampus-item').forEach(el => {
        el.addEventListener('click', () => {
            selectCampus(parseInt(el.dataset.id), true);
        });
    });

    // Modal close
    document.getElementById('modal-close')
        .addEventListener('click', closeModal);
    document.getElementById('modal-backdrop')
        .addEventListener('click', closeModal);

    // Lihat semua
    document.getElementById('btn-lihat-semua')
        .addEventListener('click', () => {
            window.location.href = '{{ route("semua-resto") }}';
        });

    // Start GPS
    startGeolocation();
});
</script>
@endpush