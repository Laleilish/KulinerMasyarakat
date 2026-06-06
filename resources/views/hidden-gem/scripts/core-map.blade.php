        // INIT MAP
        function initMap() {
            State.map = L.map('leaflet-map', {
                center: [-6.9, 107.61],
                zoom: 12,
                zoomControl: true,
                scrollWheelZoom: false,
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Â© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(State.map);

            State.markerLayer = L.layerGroup().addTo(State.map);
        }

        // RENDER USER LOCATION ON MAP
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
        

        // RENDER RESTAURANT MARKERS
        function renderRestaurantMarkers(campus, restaurants) {
            State.markerLayer.clearLayers();

            // Marker kampus
            const campusIcon = L.icon({
                iconUrl: '/assets/img/Icon-Pusat.png',
                iconSize: [40, 40],
                iconAnchor: [20, 40],
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

                const restoIcon = L.icon({
                    iconUrl: '/assets/img/icon-loc.png',
                    iconSize: [28],
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
                            <a href="/restoran/${r.id}"
                               style="flex:1;display:flex;align-items:center;justify-content:center;
                                      gap:4px;background:#F5EDE0;color:#C07A2A;
                                      padding:7px 4px;border-radius:99px;
                                      font-size:11px;font-weight:700;text-decoration:none;
                                      cursor:pointer;">
                                <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Detail
                            </a>
                            <a href="javascript:void(0)"
                               onclick="startNavigation(${r.latitude}, ${r.longitude})"
                               style="flex:2;display:flex;align-items:center;justify-content:center;
                                      gap:4px;background:#02b176;color:#fff;
                                      padding:7px 4px;border-radius:99px;
                                      font-size:11px;font-weight:700;text-decoration:none;
                                      cursor:pointer;">
                                <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                Navigasi
                            </a>
                        </div>
                    </div>`;

                L.marker([r.latitude, r.longitude], { icon: restoIcon })
                    .addTo(State.markerLayer)
                    .bindPopup(popupHTML, { maxWidth: 240 });
            });
        }

        // NAVIGATION (ROUTING)
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

        // UPDATE MAP
        function updateMap(campus, restaurants) {
            State.map.flyTo([campus.latitude, campus.longitude], campus.zoom, {
                duration: 1.2,
                easeLinearity: 0.25,
            });
            renderRestaurantMarkers(campus, restaurants);
        }
