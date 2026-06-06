        // HAVERSINE
        function haversine(lat1, lng1, lat2, lng2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) ** 2
                + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180)
                * Math.sin(dLng / 2) ** 2;
            return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        }

        // HITUNG JARAK RESTO DARI LOKASI USER (DINAMIS)
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

            return fallback || 'â€”';
        }

        // DETECT NEAREST CAMPUS
        function detectNearestCampus(lat, lng) {
            return CAMPUSES.reduce((nearest, campus) => {
                const dist = haversine(lat, lng, campus.latitude, campus.longitude);
                return dist < nearest.dist ? { ...campus, dist } : nearest;
            }, { dist: Infinity });
        }

        // UPDATE LOCATION BAR
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

        // REVERSE GEOCODE (Nominatim)
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

        // SEARCH LOCATION (Nominatim autocomplete)
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
