{{-- Embed semua data restoran sebagai JSON untuk filter client-side --}}
@php
    $ttRestaurantsData = $restaurants->map(function($r) {
        return [
            'id'          => $r->id,
            'name'        => $r->name,
            'image'       => $r->image ? asset('storage/' . $r->image) : asset('assets/img/Restoran Favorit/Nasi Goreng Kambing.png'),
            'category'    => $r->category,
            'food_type'   => $r->food_type,
            'address'     => $r->address,
            'landmark'    => $r->landmark,
            'price_range' => $r->price_range,
            'campus_id'   => $r->campus_id,
            'rating'      => round($r->reviews_avg_rating ?? 0, 1),
            'reviews_count' => $r->reviews_count ?? 0,
            'url'         => route('restoran.show', $r->id),
            'default_img' => asset('assets/img/Restoran Favorit/Nasi Goreng Kambing.png'),
        ];
    })->values()->all();
@endphp
<script>
    window.TT_RESTAURANTS = @json($ttRestaurantsData);
</script>

<section class="px-5 md:px-10 pb-6 max-w-[1400px] mx-auto w-full">

    {{-- Kontainer cards —  diisi oleh JS --}}
    <div id="tt-cards-container">
        {{-- Skeleton loading awal --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="tt-skeleton">
            @for($i = 0; $i < 8; $i++)
                <div class="bg-white rounded-xl overflow-hidden border border-black/[0.05] animate-pulse">
                    <div class="w-full h-[130px] md:h-[170px] bg-gray-200"></div>
                    <div class="p-3 space-y-2">
                        <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                        <div class="h-2 bg-gray-200 rounded w-1/2"></div>
                        <div class="h-2 bg-gray-200 rounded w-1/3"></div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    {{-- Count info --}}
    <p id="tt-count-info" class="text-center text-[11px] text-muted mt-4 hidden">
        Menampilkan <span id="tt-count-num" class="font-bold text-dark"></span> restoran
    </p>

    {{-- Filter Modal Overlay --}}
    <div id="tt-filter-modal" class="fixed inset-0 z-[100] hidden">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0 duration-300" id="tt-filter-backdrop"></div>
        
        {{-- Modal Wrapper (Bottom on mobile, Center on desktop) --}}
        <div id="tt-filter-modal-wrapper" class="absolute bottom-0 left-0 w-full md:top-1/2 md:left-1/2 md:-translate-x-1/2 md:-translate-y-1/2 md:w-[90%] md:max-w-[500px] transition-all duration-300 transform translate-y-full md:scale-95 md:opacity-0">
            
            {{-- Floating Close Button (Mobile Only) --}}
            <div class="flex justify-end px-4 mb-3 md:hidden">
                <button id="tt-close-modal-mobile" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-[#00880D] hover:bg-gray-100 transition-colors shadow-lg">
                    <i class="fas fa-times text-lg font-bold"></i>
                </button>
            </div>

            {{-- Inner White Box --}}
            <div class="bg-white rounded-t-3xl md:rounded-2xl shadow-xl flex flex-col overflow-hidden w-full max-h-[85vh]">
                
                {{-- Header --}}
                <div class="flex justify-between items-center p-5 border-b border-gray-100">
                    <h3 class="text-[18px] font-bold text-dark">Filter menu</h3>
                    <button id="tt-close-modal" class="hidden md:flex w-8 h-8 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Body --}}
                <div class="flex-1 overflow-y-auto p-5 space-y-6">
                    
                    {{-- Sort By --}}
                    <div>
                        <h4 class="text-[14px] font-bold text-dark mb-3">Sort by</h4>
                        <div class="flex flex-wrap gap-2">
                            <button class="tt-modal-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark hover:bg-gray-50 transition-colors bg-white" data-sort="populer">Populer</button>
                            <button class="tt-modal-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark hover:bg-gray-50 transition-colors bg-white" data-sort="termurah">Cheapest</button>
                        </div>
                    </div>

                    {{-- All-in price --}}
                    <div>
                        <h4 class="text-[14px] font-bold text-dark mb-3">All-in price</h4>
                        <div class="flex flex-wrap gap-2">
                            <button class="tt-modal-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark hover:bg-gray-50 transition-colors bg-white" data-sort="bawah10k">30k incl. fees</button>
                        </div>
                    </div>

                    {{-- Ratings --}}
                    <div>
                        <h4 class="text-[14px] font-bold text-dark mb-3">Dish ratings</h4>
                        <div class="flex flex-wrap gap-2">
                            <button class="tt-modal-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark hover:bg-gray-50 transition-colors bg-white" data-sort="penilaian">Dish rating 4.5+</button>
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex items-center gap-3 p-4 border-t border-gray-100 bg-white shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">
                    <button id="tt-modal-clear" class="flex-1 py-3 px-4 rounded-full border border-red-500 text-red-500 font-bold text-[14px] hover:bg-red-50 transition-colors">
                        Bersihkan
                    </button>
                    <button id="tt-modal-apply" class="flex-1 py-3 px-4 rounded-full bg-emerald-500 text-white font-bold text-[14px] hover:bg-emerald-600 transition-colors">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>

@push('scripts')
<script>
(function() {
    // ─────────────────────────────────────────────────────────────────
    // STATE
    // ─────────────────────────────────────────────────────────────────
    const State = {
        activeCampusId : null,   // null = semua kampus
        sortBy         : null,   // null | 'populer' | 'penilaian' | 'termurah' | 'bawah10k'
        activeCategory : null,   // null = semua | 'makanan' | 'minuman' | 'jajanan' | 'snack'
        allRestaurants : window.TT_RESTAURANTS || [],
    };

    // Expose state agar bisa diakses dari hero.blade.php
    window.TT_State = State;

    // ─────────────────────────────────────────────────────────────────
    // PARSE HARGA dari price_range string → angka
    // e.g. "Rp 5.000 - Rp 10.000" → min: 5000, max: 10000
    // ─────────────────────────────────────────────────────────────────
    function parseMinPrice(priceRange) {
        if (!priceRange) return Infinity;
        const nums = priceRange.replace(/[^0-9.]/g, ' ').trim().split(/\s+/).filter(Boolean);
        if (!nums.length) return Infinity;
        return parseInt(nums[0].replace(/\./g, ''), 10) || Infinity;
    }

    function parseMaxPrice(priceRange) {
        if (!priceRange) return Infinity;
        const nums = priceRange.replace(/[^0-9.]/g, ' ').trim().split(/\s+/).filter(Boolean);
        if (!nums.length) return Infinity;
        return parseInt(nums[nums.length - 1].replace(/\./g, ''), 10) || Infinity;
    }

    // ─────────────────────────────────────────────────────────────────
    // FILTER & SORT
    // ─────────────────────────────────────────────────────────────────
    function getFiltered() {
        let list = [...State.allRestaurants];

        // 1. Filter kampus
        if (State.activeCampusId !== null) {
            list = list.filter(r => r.campus_id === State.activeCampusId);
        }

        // 2. Filter kategori makanan
        if (State.activeCategory) {
            list = list.filter(r => {
                const cat  = (r.category   || '').toLowerCase();
                const type = (r.food_type  || '').toLowerCase();
                switch (State.activeCategory) {
                    case 'makanan_berat':
                        return cat === 'makanan_berat' || cat.includes('makanan');
                    case 'jajanan':
                        return cat === 'jajanan' || cat.includes('jajanan') || cat.includes('snack');
                    case 'minuman':
                        return cat === 'minuman' || cat.includes('minuman') || cat.includes('kopi') || cat.includes('es');
                    default:
                        return true;
                }
            });
        }

        // 3. Filter sort "Dibawah 10k"
        if (State.sortBy === 'bawah10k') {
            list = list.filter(r => parseMaxPrice(r.price_range) <= 10000);
        }

        // 4. Sort
        switch (State.sortBy) {
            case 'populer':
                list.sort((a, b) => b.reviews_count - a.reviews_count || b.rating - a.rating);
                break;
            case 'penilaian':
                list.sort((a, b) => b.rating - a.rating || b.reviews_count - a.reviews_count);
                break;
            case 'termurah':
            case 'bawah10k':
                list.sort((a, b) => parseMinPrice(a.price_range) - parseMinPrice(b.price_range));
                break;
        }

        return list;
    }

    // ─────────────────────────────────────────────────────────────────
    // RENDER CARDS
    // ─────────────────────────────────────────────────────────────────
    function renderCards() {
        const container = document.getElementById('tt-cards-container');
        const countInfo = document.getElementById('tt-count-info');
        const countNum  = document.getElementById('tt-count-num');
        const list      = getFiltered();

        if (!list.length) {
            container.innerHTML = `
                <div class="text-center py-14">
                    <i class="fas fa-utensils text-[#F5A623]/30 text-5xl mb-4 block"></i>
                    <p class="text-dark font-bold text-[15px] mb-1">Tidak ada restoran ditemukan</p>
                    <p class="text-muted text-[12px]">Coba ubah filter atau pilih lokasi lain</p>
                </div>`;
            countInfo.classList.add('hidden');
            return;
        }

        container.innerHTML = `
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                ${list.map(r => cardHTML(r)).join('')}
            </div>`;

        // Attach click listeners
        container.querySelectorAll('.tt-card').forEach(card => {
            card.addEventListener('click', () => {
                window.location.href = card.dataset.url;
            });
        });

        countNum.textContent  = list.length;
        countInfo.classList.remove('hidden');
    }

    function cardHTML(r) {
        const ratingStr = r.rating > 0 ? r.rating.toFixed(1) : '—';
        const stars = r.rating > 0 ? '★' : '☆';
        return `
            <div class="tt-card flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer
                        shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                        transition-all duration-200
                        hover:-translate-y-1 hover:shadow-[0_8px_24px_rgba(0,0,0,0.12)]
                        active:scale-[0.98] border border-black/[0.05]"
                 data-url="${r.url}">

                <div class="relative w-full h-[130px] md:h-[170px] overflow-hidden">
                    <img src="${r.image}"
                         alt="${r.name}"
                         class="w-full h-full object-cover transition-transform duration-300"
                         onerror="this.src='${r.default_img}'">

                    <div class="absolute top-2 right-2">
                        <span class="inline-flex items-center gap-[3px] bg-black/30 text-white
                                     text-[10px] font-bold px-2 py-[3px] rounded-full backdrop-blur-sm">
                            ${stars} ${ratingStr}
                        </span>
                    </div>

                    <div class="absolute bottom-2 left-2">
                        <span class="inline-flex items-center bg-[#F5A623] text-white
                                     text-[9px] font-extrabold px-2 py-[2px] rounded-full">
                            ${r.price_range || '—'}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col flex-1 p-3 min-h-[80px]">
                    <h3 class="text-[12px] font-extrabold text-dark leading-snug line-clamp-2 mb-1">
                        ${r.name}${r.landmark ? ', ' + r.landmark : ''}
                    </h3>
                    <p class="text-[10px] text-muted mb-1 truncate">
                        ${r.category || ''}${r.food_type ? ', ' + r.food_type : ''}
                    </p>
                    <span class="mt-auto text-[10px] text-[#5d6e86] font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-star text-yellow-500 text-[9px]"></i>
                        ${ratingStr}
                        <span class="font-normal">(${r.reviews_count})</span>
                    </span>
                </div>
            </div>`;
    }

    // ─────────────────────────────────────────────────────────────────
    // FILTER CHIPS (sort) & MODAL
    // ─────────────────────────────────────────────────────────────────
    
    function updateFilterUI() {
        // 1. Update Chips di Halaman Utama & Modal
        document.querySelectorAll('.tt-sort-chip, .tt-modal-chip').forEach(b => {
            const isActive = b.dataset.sort === State.sortBy;
            b.classList.toggle('bg-[#F5A623]', isActive);
            b.classList.toggle('text-white', isActive);
            b.classList.toggle('border-[#F5A623]', isActive);
            b.classList.toggle('bg-white', !isActive);
            b.classList.toggle('text-dark', !isActive);
            b.classList.toggle('border-gray-300', !isActive);
            b.classList.toggle('hover:bg-gray-50', !isActive);
        });

        // 2. Update Tombol Sliders (Icon Filter)
        const btnFilter = document.getElementById('tt-btn-filter-modal');
        const iconFilter = btnFilter ? btnFilter.querySelector('.tt-btn-filter-icon') : null;
        if (btnFilter && iconFilter) {
            const isFilterActive = State.sortBy !== null; // Jika ada filter
            btnFilter.classList.toggle('bg-[#F5A623]', isFilterActive);
            btnFilter.classList.toggle('border-[#F5A623]', isFilterActive);
            iconFilter.classList.toggle('text-white', isFilterActive);
            btnFilter.classList.toggle('bg-white', !isFilterActive);
            btnFilter.classList.toggle('border-gray-300', !isFilterActive);
            iconFilter.classList.toggle('text-gray-500', !isFilterActive);
        }
    }

    // Klik Chip (baik di halaman maupun di dalam modal)
    document.querySelectorAll('.tt-sort-chip, .tt-modal-chip').forEach(btn => {
        btn.addEventListener('click', () => {
            const val = btn.dataset.sort;
            if (State.sortBy === val) {
                State.sortBy = null; // Toggle off jika diklik 2x
            } else {
                State.sortBy = val;
            }
            updateFilterUI();
            renderCards();
        });
    });

    // Modal Logic
    const filterModal = document.getElementById('tt-filter-modal');
    const filterBackdrop = document.getElementById('tt-filter-backdrop');
    const filterModalWrapper = document.getElementById('tt-filter-modal-wrapper');
    
    function openFilterModal() {
        if(!filterModal) return;
        filterModal.classList.remove('hidden');
        // trigger reflow
        void filterModal.offsetWidth;
        filterBackdrop.classList.remove('opacity-0');
        filterModalWrapper.classList.remove('translate-y-full', 'md:scale-95', 'md:opacity-0');
        filterModalWrapper.classList.add('translate-y-0', 'md:scale-100', 'md:opacity-100');
    }
    
    function closeFilterModal() {
        if(!filterModal) return;
        filterBackdrop.classList.add('opacity-0');
        filterModalWrapper.classList.add('translate-y-full', 'md:scale-95', 'md:opacity-0');
        filterModalWrapper.classList.remove('translate-y-0', 'md:scale-100', 'md:opacity-100');
        setTimeout(() => {
            filterModal.classList.add('hidden');
        }, 300);
    }

    document.getElementById('tt-btn-filter-modal')?.addEventListener('click', openFilterModal);
    document.getElementById('tt-close-modal')?.addEventListener('click', closeFilterModal);
    document.getElementById('tt-close-modal-mobile')?.addEventListener('click', closeFilterModal);
    filterBackdrop?.addEventListener('click', closeFilterModal);
    
    document.getElementById('tt-modal-apply')?.addEventListener('click', () => {
        renderCards();
        closeFilterModal();
    });

    document.getElementById('tt-modal-clear')?.addEventListener('click', () => {
        State.sortBy = null;
        State.activeCategory = null;
        updateFilterUI();
        updateCategoryUI();
        renderCards();
        closeFilterModal();
    });

    // Panggil sekali saat inisialisasi agar tampilannya pas
    updateFilterUI();

    // ─────────────────────────────────────────────────────────────────
    // CATEGORY CIRCLES (GoFood Style)
    // ─────────────────────────────────────────────────────────────────
    function updateCategoryUI() {
        document.querySelectorAll('.tt-cat-item').forEach(i => {
            const isCat = i.dataset.category;
            const isActive = (isCat === State.activeCategory) || (!State.activeCategory && isCat === 'semua');
            
            const label = i.querySelector('.cat-label');

            if (isActive) {
                i.classList.remove('border-transparent', 'hover:border-gray-300');
                i.classList.add('border-[#F5A623]');
                label.classList.remove('text-muted', 'font-medium');
                label.classList.add('text-dark', 'font-bold');
            } else {
                i.classList.remove('border-[#F5A623]');
                i.classList.add('border-transparent', 'hover:border-gray-300');
                label.classList.remove('text-dark', 'font-bold');
                label.classList.add('text-muted', 'font-medium');
            }
        });
    }

    document.querySelectorAll('.tt-cat-item').forEach(item => {
        item.addEventListener('click', () => {
            const cat = item.dataset.category;

            // Toggle logic
            if (cat === 'semua') {
                State.activeCategory = null;
            } else if (State.activeCategory === cat) {
                State.activeCategory = null;
            } else {
                State.activeCategory = cat;
            }

            updateCategoryUI();
            renderCards();
        });
    });

    // ─────────────────────────────────────────────────────────────────
    // EXPOSE selectCampus ke hero.blade.php
    // ─────────────────────────────────────────────────────────────────
    window.TT_selectCampus = function(campusId) {
        State.activeCampusId = campusId;
        renderCards();
    };

    window.TT_clearCampus = function() {
        State.activeCampusId = null;
        renderCards();
    };

    // ─────────────────────────────────────────────────────────────────
    // INIT — render semua setelah DOM siap
    // ─────────────────────────────────────────────────────────────────
    renderCards();
})();
</script>
@endpush