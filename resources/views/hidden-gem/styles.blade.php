@push('styles_extra')
<style>
    /* ── Panel kiri desktop (Google Maps style) ── */
    @media (min-width: 768px) {
        #fs-bottom-sheet {
            max-height: 100% !important;
            overflow-y: auto !important;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 380px;
            z-index: 500;
        }
        #fs-bottom-sheet.fs-panel-open {
            transform: translateX(0);
        }
    }

    /* ── Bottom sheet mobile ── */
    @media (max-width: 767px) {
        #fs-bottom-sheet {
            max-height: 72vh;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1);
        }
        #fs-bottom-sheet.fs-panel-open {
            transform: translateY(0);
        }
        
        /* Hide leaflet zoom control on mobile */
        .leaflet-control-zoom {
            display: none !important;
        }
    }
</style>
@endpush
