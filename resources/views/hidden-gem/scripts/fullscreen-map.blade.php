        // FULLSCREEN MAP
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
            const fsLocInput = document.getElementById('fs-loc-input');
            const fsLocLabel = document.getElementById('fs-loc-label');
            
            if (fsLocInput) fsLocInput.value = campus.name;
            if (fsLocLabel) {
                const mainLabel = document.getElementById('loc-label');
                fsLocLabel.textContent = mainLabel ? mainLabel.textContent : 'Lokasi Terpilih';
            }

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
                                   : 'bg-white text-dark border-black/[0.1] shadow-sm hover:bg-orange hover:text-white'}"
                        data-filter="all">All</button>
                ${categories.map(cat => `
                    <button class="fs-chip flex-shrink-0 px-4 py-[6px] rounded-full text-[12px]
                                   font-bold transition-all duration-150 border
                                   ${FsState.activeFilter === cat
                                       ? 'bg-[#F5A623] text-white border-transparent shadow-[0_2px_8px_rgba(245,166,35,0.4)]'
                                       : 'bg-white text-dark border-black/[0.1] shadow-sm hover:bg-orange hover:text-white '}"
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
                const campusIcon = L.icon({
                    iconUrl: '/assets/img/icon-Pusat.png',
                    iconSize: [40, 40],
                    iconAnchor: [20, 40],
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
                const icon = L.icon({
                    iconUrl: '/assets/img/icon-loc.png',
                    iconSize: [28],
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

            const ratingStr = r.rating != null ? `${parseFloat(r.rating).toFixed(1)}` : '—';
            const distStr   = calcRestoDistance(r.latitude, r.longitude, r.distance);

            document.getElementById('fs-bs-image').src           = r.image;
            document.getElementById('fs-bs-image').alt           = r.name;
            document.getElementById('fs-bs-name').textContent    = r.name;
            document.getElementById('fs-bs-rating').textContent  = ratingStr;
            document.getElementById('fs-bs-category').textContent = formatCategory(r.category);
            document.getElementById('fs-bs-distance').textContent = distStr;
            document.getElementById('fs-bs-desc').textContent    = r.description || 'Tidak ada deskripsi.';
            document.getElementById('fs-bs-address').textContent = r.address || '—';
            document.getElementById('fs-bs-hours').textContent   = r.open_hours || '—';
            document.getElementById('fs-bs-price').textContent   = r.price_range || '—';

            const detailBtn = document.getElementById('fs-bs-detail-btn');
            if (detailBtn) {
                detailBtn.href = `/restoran/${r.id}`;
            }

            // Load ulasan
            fsFetchAndRenderReviews(r.id);

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
                createMarker: function() { return null; },
                router: L.Routing.osrmv1({
                    language: 'id',
                    profile: 'car',
                    serviceUrl: 'https://router.project-osrm.org/route/v1'
                })
            }).addTo(FsState.map);

            // Jangan tutup bottom sheet agar info resto tetap terlihat
            // fsCloseBottomSheet();
        }

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

        async function fsFetchAndRenderReviews(restoId) {
            const listEl    = document.getElementById('fs-bs-reviews-list');
            const emptyEl   = document.getElementById('fs-bs-reviews-empty');
            const loadingEl = document.getElementById('fs-bs-reviews-loading');

            if (!listEl) return;

            listEl.innerHTML    = '';
            emptyEl.classList.add('hidden');
            loadingEl.classList.remove('hidden');

            try {
                const res  = await fetch(`/api/restoran/${restoId}/reviews`);
                const data = await res.json();
                loadingEl.classList.add('hidden');

                if (!data || !data.length) {
                    emptyEl.classList.remove('hidden');
                    return;
                }

                listEl.innerHTML = data.map(rv => {
                    const stars = Array.from({ length: 5 }, (_, i) => {
                        const active = i < rv.rating ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-200 text-gray-200';
                        return `<svg class="w-3.5 h-3.5 ${active}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>`;
                    }).join('');

                    const initials = rv.user_name ? rv.user_name.split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase() : 'U';

                    const avatarHtml = `<div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 text-sm font-bold flex-shrink-0">
                                        ${initials}
                                      </div>`;

                    return `
                    <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm mb-3">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                ${avatarHtml}
                                <div>
                                    <p class="text-sm font-bold text-gray-800">${rv.user_name}</p>
                                    <div class="flex gap-0.5 mt-0.5">
                                        ${stars}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <span class="text-[11px] text-gray-400">${rv.created_at || ''}</span>
                            </div>
                        </div>
                        <p class="text-[14px] text-gray-600 leading-relaxed">${rv.comment || ''}</p>
                    </div>`;
                }).join('');

            } catch (err) {
                console.error('fsFetchReviews error:', err);
                loadingEl.classList.add('hidden');
                listEl.innerHTML = '<p class="text-[12px] text-red-400 text-center py-3">Gagal memuat ulasan.</p>';
            }
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
