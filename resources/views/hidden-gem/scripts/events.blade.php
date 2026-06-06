        // EVENT LISTENERS
        document.addEventListener('DOMContentLoaded', () => {

            initMap();

            const urlParams = new URLSearchParams(window.location.search);
            const navLat = urlParams.get('nav_lat');
            const navLng = urlParams.get('nav_lng');
            const navCampusId = urlParams.get('nav_campus_id');

            if (navLat && navLng && navCampusId) {
                updateLocationBar({ label: 'Mendeteksi lokasi untuk rute...', value: '', loading: true });

                const runFallback = async (reason) => {
                    handleGPSFallback(reason);
                    await selectCampus(parseInt(navCampusId), true, true);
                    startNavigation(parseFloat(navLat), parseFloat(navLng));
                };

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        async (pos) => {
                            // Berhasil dapat GPS
                            const { latitude: lat, longitude: lng, accuracy } = pos.coords;
                            State.userLat = lat;
                            State.userLng = lng;
                            
                            renderUserLocation(lat, lng, accuracy);
                            const placeName = await reverseGeocode(lat, lng);
                            updateLocationBar({ label: 'Rute dari lokasi kamu', value: placeName || 'Lokasi Kamu' });
                            
                            // Tetap load kampus restoran tersebut agar marker muncul
                            await selectCampus(parseInt(navCampusId), true, true);
                            startNavigation(parseFloat(navLat), parseFloat(navLng));
                        },
                        () => runFallback('GPS gagal, rute dari kampus terdekat'),
                        { enableHighAccuracy: true, timeout: 7000, maximumAge: 60000 }
                    );
                } else {
                    runFallback('GPS tidak didukung, rute dari kampus terdekat');
                }
            }

            //  Kampus click
            document.querySelectorAll('.kampus-item').forEach(el => {
                el.addEventListener('click', () => selectCampus(parseInt(el.dataset.id), true, true));
            });

            //  Search input
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

            //  Clear button
            document.getElementById('loc-clear').addEventListener('click', () => {
                input.value = '';
                document.getElementById('loc-clear').classList.add('hidden');
                renderDropdownCampus();
                document.getElementById('dropdown-search-section').classList.add('hidden');
                input.focus();
            });

            //  GPS button
            document.getElementById('loc-gps-btn').addEventListener('click', detectUserLocation);

            //  Dropdown item click
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

            //  Close dropdown on outside click
            document.addEventListener('click', (e) => {
                if (!e.target.closest('#search-section')) closeDropdown();
            });

            //  Modal close
            document.getElementById('modal-close').addEventListener('click', closeModal);
            document.getElementById('modal-backdrop').addEventListener('click', closeModal);

            //  Lihat semua
            document.getElementById('btn-lihat-semua').addEventListener('click', () => {
                window.location.href = '{{ route("semua-resto") }}';
            });
        });
    </script>