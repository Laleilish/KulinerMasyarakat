        // CONFIG
        const CAMPUSES = @json($campusesData);
        const API_URL = '{{ url("/hidden-gem/restaurants") }}';
        const NOMINATIM = 'https://nominatim.openstreetmap.org';

        // Format category name (e.g. "makanan_berat" to "Makanan Berat")
        function formatCategory(str) {
            if (!str) return 'â€”';
            return str.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
        }
        // STATE
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
            routingControl: null,
            currentCampus: null,
            currentRestaurants: [],
        };
