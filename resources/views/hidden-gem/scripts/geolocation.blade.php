        // SELECT CAMPUS
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

        // GEOLOCATION
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
