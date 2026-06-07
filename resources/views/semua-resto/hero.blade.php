<section class="px-5 mt-6 mb-4 w-full md:px-10 max-w-[1400px] mx-auto relative z-10">

    {{-- Search Bar --}}
    <div id="search-bar-wrap" class="relative bg-white rounded-3xl md:rounded-full shadow-lg
                border border-black/[0.06] transition-all duration-300 w-full mx-auto mt-6 z-30">

        {{-- Main bar --}}
        <div class="flex items-center gap-3 px-4 h-[54px]">

            {{-- Icon kiri --}}
            <div id="search-icon-wrap" class="flex-shrink-0 w-5 flex items-center justify-center">
                <i id="search-icon" class="fas fa-search text-[#F5A623] text-[16px]"></i>
            </div>

            {{-- Input --}}
            <div class="flex-1 flex flex-col justify-center min-w-0">
                <input id="search-input" type="text" placeholder="Masukkan nama restoran atau menu..." autocomplete="off"
                       class="w-full border-none outline-none bg-transparent
                              text-[13px] font-semibold text-dark
                              placeholder:text-muted/50 placeholder:font-normal
                              transition-all duration-200">
            </div>

            {{-- Tombol clear --}}
            <button id="search-clear" class="hidden flex-shrink-0 w-7 h-7 rounded-full
                           bg-black/[0.06] flex items-center justify-center
                           hover:bg-black/10 transition-colors duration-150">
                <i class="fas fa-xmark text-[12px] text-muted"></i>
            </button>
        </div>
    </div>

</section>

@push('scripts')
<script>
(function() {
    const input = document.getElementById('search-input');
    const clearBtn = document.getElementById('search-clear');

    input.addEventListener('input', (e) => {
        const query = e.target.value.trim();
        clearBtn.classList.toggle('hidden', !query);
        
        if (typeof window.TT_searchQuery === 'function') {
            window.TT_searchQuery(query);
        }
    });

    clearBtn.addEventListener('click', () => {
        input.value = '';
        clearBtn.classList.add('hidden');
        input.focus();
        
        if (typeof window.TT_searchQuery === 'function') {
            window.TT_searchQuery('');
        }
    });
})();
</script>
@endpush