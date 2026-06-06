@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script>
        @include('hidden-gem.scripts.config-state')
        @include('hidden-gem.scripts.utils')
        @include('hidden-gem.scripts.core-map')
        @include('hidden-gem.scripts.ui-components')
        @include('hidden-gem.scripts.geolocation')
        @include('hidden-gem.scripts.fullscreen-map')
        @include('hidden-gem.scripts.events')
    </script>
@endpush
