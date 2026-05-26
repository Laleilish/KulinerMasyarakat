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
// ── DATA DARI LARAVEL ──────────────────────────────
const CAMPUSES     = @json($campuses);
const API_BASE     = '/hidden-gem/restaurants';
let   activeCampus = @json($selectedCampus);
let   leafletMap   = null;
let   markerLayer  = null;

// ── INIT ──────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    initMap();
    selectCampus(activeCampus.id, false);
});

// ── INIT LEAFLET MAP ──────────────────────────────
function initMap() {
    leafletMap = L.map('leaflet-map', {
        center: [activeCampus.latitude, activeCampus.longitude],
        zoom:   activeCampus.map_zoom,
        zoomControl: true,
        scrollWheelZoom: false,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(leafletMap);

    markerLayer = L.layerGroup().addTo(leafletMap);
}

// ── SELECT KAMPUS ─────────────────────────────────
async function selectCampus(campusId, scroll = true) {
    // Update active state UI
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
    });

    // Show loading
    showLoading(true);

    try {
        const res  = await fetch(`${API_BASE}/${campusId}`);
        const data = await res.json();

        activeCampus = data.campus;

        // Update search bar
        document.getElementById('search-campus-name').textContent = data.campus.name;

        // Update map
        updateMap(data.campus, data.restaurants);

        // Update cards
        renderCards(data.restaurants);

    } catch (err) {
        console.error('Gagal memuat data:', err);
        showError();
    } finally {
        showLoading(false);
    }

    // Smooth scroll ke map
    if (scroll) {
        setTimeout(() => {
            document.getElementById('map-section').scrollIntoView({
                behavior: 'smooth', block: 'start'
            });
        }, 150);
    }
}

// ── UPDATE MAP ────────────────────────────────────
function updateMap(campus, restaurants) {
    // Fly to kampus
    leafletMap.flyTo([campus.latitude, campus.longitude], campus.zoom, {
        duration: 1.2,
        easeLinearity: 0.25,
    });

    // Clear markers
    markerLayer.clearLayers();

    // Custom icon
    const campusIcon = L.divIcon({
        className: '',
        html: `<div class="flex items-center justify-center w-8 h-8 bg-[#F5A623] rounded-full shadow-lg border-2 border-white text-base">🏫</div>`,
        iconSize: [32, 32],
        iconAnchor: [16, 16],
    });

    const restoIcon = L.divIcon({
        className: '',
        html: `<div style="width:32px;height:32px;background:#02b176;border-radius:50%;border:2.5px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.18);display:flex;align-items:center;justify-content:center;font-size:15px;">🍜</div>`,
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32],
    });

    // Marker kampus
    L.marker([campus.latitude, campus.longitude], { icon: campusIcon })
     .addTo(markerLayer)
     .bindPopup(`<b>${activeCampus.name}</b>`)
     .openPopup();

    // Marker restoran
    restaurants.forEach(r => {
        const popup = `
            <div style="min-width:200px;font-family:'Plus Jakarta Sans',sans-serif;">
                <img src="${r.image}" alt="${r.name}"
                     style="width:100%;height:90px;object-fit:cover;border-radius:8px;margin-bottom:8px;">
                <div style="font-weight:800;font-size:13px;color:#040818;margin-bottom:4px;">${r.name}</div>
                <div style="font-size:11px;color:#5d6e86;margin-bottom:6px;">${r.category} · ${r.distance}</div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                    <span style="color:#F5A623;font-size:12px;">★ ${r.rating}</span>
                    <span style="font-size:11px;color:#5d6e86;">${r.price_range}</span>
                </div>
                <a href="${r.maps_url}" target="_blank"
                   style="display:block;background:#02b176;color:#fff;text-align:center;
                          padding:7px;border-radius:99px;font-size:12px;font-weight:700;
                          text-decoration:none;">
                    🗺️ Navigasi
                </a>
            </div>
        `;

        L.marker([r.latitude, r.longitude], { icon: restoIcon })
         .addTo(markerLayer)
         .bindPopup(popup, { maxWidth: 220 });
    });
}

// ── RENDER CARDS ──────────────────────────────────
function renderCards(restaurants) {
    const grid = document.getElementById('resto-cards');

    if (!restaurants.length) {
        grid.innerHTML = `
            <div class="col-span-2 text-center py-8 text-muted text-[13px]">
                Belum ada restoran di kampus ini.
            </div>`;
        return;
    }

    // Top 2 horizontal
    const top2 = restaurants.slice(0, 2).map(r => `
        <div class="bg-white rounded-[16px] overflow-hidden border border-black/[0.05]
                    shadow-[0_2px_8px_rgba(0,0,0,0.08)] cursor-pointer
                    transition-all duration-200 hover:-translate-y-[3px]
                    hover:shadow-[0_8px_24px_rgba(0,0,0,0.10)] active:scale-[0.98]"
             onclick="openRestoDetail(${JSON.stringify(r).replace(/"/g, '&quot;')})">
            <div class="flex items-stretch">
                <img src="${r.image}" alt="${r.name}"
                     class="w-[90px] h-[90px] object-cover flex-shrink-0">
                <div class="flex-1 flex flex-col justify-between p-3">
                    <p class="text-[11px] font-extrabold text-[#6B4423] leading-[1.35] mb-1">${r.name}</p>
                    <div class="flex gap-1 flex-wrap mb-1">
                        <span class="bg-[#F5EDE0] text-[#C07A2A] text-[9px] font-bold px-2 py-[2px] rounded-full">${r.category}</span>
                        <span class="bg-[#F5EDE0] text-[#C07A2A] text-[9px] font-bold px-2 py-[2px] rounded-full">${r.distance}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[#F5A623] text-[11px]">★ ${r.rating}</span>
                        <span class="text-[10px] text-muted">${r.price_range}</span>
                    </div>
                </div>
            </div>
        </div>
    `).join('');

    // Bottom 3 vertical
    const bottom3 = restaurants.slice(2, 5).map(r => `
        <div class="flex flex-col bg-white rounded-[16px] overflow-hidden
                    border border-black/[0.05] shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                    cursor-pointer transition-all duration-200
                    hover:-translate-y-[3px] hover:shadow-[0_8px_24px_rgba(0,0,0,0.10)]
                    active:scale-[0.98]"
             onclick="openRestoDetail(${JSON.stringify(r).replace(/"/g, '&quot;')})">
            <img src="${r.image}" alt="${r.name}" class="w-full h-[75px] object-cover">
            <div class="p-2 flex flex-col flex-1">
                <p class="text-[10px] font-extrabold text-[#6B4423] mb-1 leading-[1.35]">${r.name}</p>
                <span class="bg-[#F5EDE0] text-[#C07A2A] text-[9px] font-bold px-2 py-[2px] rounded-full w-fit mb-1">${r.category}</span>
                <div class="flex items-center justify-between mt-auto">
                    <span class="text-[#F5A623] text-[10px]">★ ${r.rating}</span>
                    <span class="text-[9px] text-muted">${r.distance}</span>
                </div>
            </div>
        </div>
    `).join('');

    grid.innerHTML = `
        <div class="col-span-2 grid grid-cols-2 gap-3 mb-3">${top2}</div>
        <div class="col-span-2 grid grid-cols-3 gap-3">${bottom3}</div>
    `;
}

// ── DETAIL POPUP ──────────────────────────────────
function openRestoDetail(r) {
    document.getElementById('detail-image').src       = r.image;
    document.getElementById('detail-name').textContent      = r.name;
    document.getElementById('detail-category').textContent  = r.category;
    document.getElementById('detail-rating').textContent    = `★ ${r.rating}`;
    document.getElementById('detail-distance').textContent  = r.distance;
    document.getElementById('detail-price').textContent     = r.price_range;
    document.getElementById('detail-desc').textContent      = r.description;
    document.getElementById('detail-nav-btn').href          = r.maps_url;
    document.getElementById('resto-detail-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetail() {
    document.getElementById('resto-detail-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

// ── LOADING STATE ─────────────────────────────────
function showLoading(show) {
    const el = document.getElementById('map-loading');
    el.style.opacity = show ? '1' : '0';
    el.style.pointerEvents = show ? 'all' : 'none';

    const cards = document.getElementById('cards-loading');
    cards.style.display = show ? 'flex' : 'none';
    document.getElementById('resto-cards').style.opacity = show ? '0.4' : '1';
}

function showError() {
    document.getElementById('resto-cards').innerHTML = `
        <div class="col-span-2 text-center py-8 text-red-400 text-[13px]">
            Gagal memuat data. Coba lagi.
        </div>`;
}
</script>
@endpush