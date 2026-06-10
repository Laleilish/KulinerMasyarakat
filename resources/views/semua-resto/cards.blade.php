{{-- Embed semua data restoran sebagai JSON untuk filter client-side --}}
@php
    $ttRestaurantsData = $restaurants->map(function($r) {
        return [
            'id'          => $r->id,
            'name'        => $r->name,
            'image'       => $r->image ? (str_starts_with($r->image, 'http') ? $r->image : asset('storage/' . $r->image)) : asset('assets/img/Restoran Favorit/Nasi Goreng Kambing.png'),
            'category'    => $r->category,
            'formatted_category' => $r->formatted_category,
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

{{-- MAIN CONTENT --}}
<div class="px-5 md:px-10 pb-10 pt-8 max-w-[1400px] mx-auto w-full">
    <div class="flex gap-6 items-start">

        {{-- LEFT SIDEBAR FILTER --}}
        <aside class="hidden md:flex flex-col w-[200px] flex-shrink-0 bg-white rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.07)] border border-gray-100 p-5 sticky top-4 self-start">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-[15px] text-dark">Filter</h3>
                <button id="tt-sidebar-reset" class="text-[#F5A623] font-semibold text-[13px] hover:text-[#D4891E] transition-colors">Reset</button>
            </div>

            {{-- Range Harga --}}
            <div class="mb-5">
                <p class="font-bold text-[13px] text-dark mb-3">Range Harga</p>
                <div class="space-y-2" id="tt-price-group">
                    <div class="tt-price-btn flex items-center gap-2.5 cursor-pointer group" data-value="dibawah15k">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">< 15.000</span>
                    </div>
                    <div class="tt-price-btn flex items-center gap-2.5 cursor-pointer group" data-value="15k-30k">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">15.000 - 30.000</span>
                    </div>
                    <div class="tt-price-btn flex items-center gap-2.5 cursor-pointer group" data-value="30k-50k">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">30.000 - 50.000</span>
                    </div>
                    <div class="tt-price-btn flex items-center gap-2.5 cursor-pointer group" data-value="diatas50k">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">> 50.000</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 mb-5"></div>

            {{-- Sort By --}}
            <div class="mb-5">
                <p class="font-bold text-[13px] text-dark mb-3">Urutkan</p>
                <div class="space-y-2" id="tt-sort-group">
                    <div class="tt-sort-btn flex items-center gap-2.5 cursor-pointer group" data-value="populer">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">Populer</span>
                    </div>
                    <div class="tt-sort-btn flex items-center gap-2.5 cursor-pointer group" data-value="terdekat">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">Terdekat</span>
                    </div>
                    <div class="tt-sort-btn flex items-center gap-2.5 cursor-pointer group" data-value="penilaian">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">Penilaian 4.5+</span>
                    </div>
                    <div class="tt-sort-btn flex items-center gap-2.5 cursor-pointer group" data-value="termurah">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">Termurah</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 mb-5"></div>

            {{-- Kategori --}}
            <div>
                <p class="font-bold text-[13px] text-dark mb-3">Kategori</p>
                <div class="space-y-2" id="tt-cat-group">
                    <div class="tt-cat-btn flex items-center gap-2.5 cursor-pointer group" data-value="makanan_berat">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">Makanan Berat</span>
                    </div>
                    <div class="tt-cat-btn flex items-center gap-2.5 cursor-pointer group" data-value="jajanan">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">Jajanan</span>
                    </div>
                    <div class="tt-cat-btn flex items-center gap-2.5 cursor-pointer group" data-value="minuman">
                        <span class="tt-radio-dot w-4 h-4 rounded-full border-2 border-gray-400 flex-shrink-0 flex items-center justify-center transition-all">
                            <span class="tt-radio-inner w-2 h-2 rounded-full bg-[#F5A623] opacity-0 transition-all"></span>
                        </span>
                        <span class="tt-radio-label text-[13px] text-dark group-hover:text-[#F5A623] transition-colors">Minuman</span>
                    </div>
                </div>
            </div>

        </aside>

        {{-- RIGHT CONTENT: Header Info + Cards Grid --}}
        <div class="flex-1 min-w-0">

            {{-- Search Bar --}}
            <div id="search-bar-wrap" class="relative bg-white rounded-3xl md:rounded-full shadow-sm
                        border border-black/[0.06] transition-all duration-300 w-full mb-6 z-30 mt-4 md:mt-0">
                <div class="flex items-center gap-3 px-4 h-[50px]">
                    <div id="search-icon-wrap" class="flex-shrink-0 w-5 flex items-center justify-center">
                        <i id="search-icon" class="fas fa-search text-[#F5A623] text-[16px]"></i>
                    </div>
                    <div class="flex-1 flex flex-col justify-center min-w-0">
                        <input id="search-input" type="text" placeholder="Masukkan nama restoran atau menu..." autocomplete="off"
                               class="w-full border-none outline-none bg-transparent
                                      text-[13px] font-semibold text-dark
                                      placeholder:text-muted/50 placeholder:font-normal
                                      transition-all duration-200">
                    </div>
                    <button id="search-clear" class="hidden flex-shrink-0 w-7 h-7 rounded-full
                                   bg-black/[0.06] flex items-center justify-center
                                   hover:bg-black/10 transition-colors duration-150">
                        <i class="fas fa-xmark text-[12px] text-muted"></i>
                    </button>
                </div>
            </div>



            {{-- Mobile Filter Button (only on mobile) --}}
            <div class="flex items-center gap-2 mb-4 md:hidden overflow-x-auto no-scrollbar pb-2">
                <button id="tt-btn-filter-modal" class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 bg-white text-[13px] font-semibold text-dark hover:bg-[#F5A623]/10 hover:border-[#F5A623]/30 transition-all shadow-sm flex-shrink-0">
                    <i class="fas fa-sliders-h text-gray-500 tt-btn-filter-icon"></i>
                    <span class="tt-filter-text">Filter</span>
                </button>
                <button class="tt-sort-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark flex-shrink-0 transition-all bg-white hover:bg-[#F5A623]/10 hover:border-[#F5A623]/30 shadow-sm" data-sort="populer">Populer</button>
                <button class="tt-sort-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark flex-shrink-0 transition-all bg-white hover:bg-[#F5A623]/10 hover:border-[#F5A623]/30 shadow-sm" data-sort="terdekat">Terdekat</button>
                <button class="tt-sort-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark flex-shrink-0 transition-all bg-white hover:bg-[#F5A623]/10 hover:border-[#F5A623]/30 shadow-sm" data-sort="penilaian">Rating 4.5+</button>
                <button class="tt-sort-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark flex-shrink-0 transition-all bg-white hover:bg-[#F5A623]/10 hover:border-[#F5A623]/30 shadow-sm" data-sort="termurah">Termurah</button>
                <button class="tt-sort-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark flex-shrink-0 transition-all bg-white hover:bg-[#F5A623]/10 hover:border-[#F5A623]/30 shadow-sm" data-sort="bawah15k">Dibawah 15k</button>
            </div>

            {{-- Header: Count info only --}}
            <div class="flex items-center mb-4">
                <p id="tt-count-info" class="text-[13px] text-muted hidden">
                    Menampilkan <span id="tt-count-num" class="font-bold text-dark"></span> tempat makan
                </p>
            </div>

            {{-- Cards Container — filled by JS --}}
            <div id="tt-cards-container">
                {{-- Skeleton loading --}}
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4" id="tt-skeleton">
                    @for($i = 0; $i < 6; $i++)
                        <div class="bg-white rounded-xl overflow-hidden border border-black/[0.05] animate-pulse">
                            <div class="w-full h-[180px] bg-gray-200"></div>
                            <div class="p-4 space-y-2">
                                <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-2 bg-gray-200 rounded w-1/2"></div>
                                <div class="h-2 bg-gray-200 rounded w-1/3"></div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

        </div>{{-- end right --}}
    </div>{{-- end flex row --}}
</div>

{{-- MOBILE FILTER MODAL --}}
<div id="tt-filter-modal" class="fixed inset-0 z-[100] hidden md:hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity opacity-0 duration-300" id="tt-filter-backdrop"></div>

    <div id="tt-filter-modal-wrapper" class="absolute bottom-0 left-0 w-full transition-transform duration-300 transform translate-y-full">

        <div class="flex justify-end px-4 mb-3">
            <button id="tt-close-modal-mobile" class="w-10 h-10 flex items-center justify-center rounded-full bg-white text-gray-600 hover:bg-gray-100 transition-colors shadow-lg">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="bg-white rounded-t-3xl shadow-xl flex flex-col overflow-hidden w-full max-h-[85vh]">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-[18px] font-bold text-dark">Filter</h3>
            </div>
            <div class="flex-1 overflow-y-auto p-5 space-y-6">
                {{-- Sort By --}}
                <div>
                    <h4 class="text-[14px] font-bold text-dark mb-3">Urutkan</h4>
                    <div class="flex flex-wrap gap-2">
                        <button class="tt-modal-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark hover:bg-gray-50 transition-colors bg-white" data-sort="populer">Populer</button>
                        <button class="tt-modal-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark hover:bg-gray-50 transition-colors bg-white" data-sort="terdekat">Terdekat</button>
                        <button class="tt-modal-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark hover:bg-gray-50 transition-colors bg-white" data-sort="penilaian">Rating 4.5+</button>
                        <button class="tt-modal-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark hover:bg-gray-50 transition-colors bg-white" data-sort="termurah">Termurah</button>
                        <button class="tt-modal-chip px-4 py-2 rounded-full border border-gray-300 text-[13px] font-semibold text-dark hover:bg-gray-50 transition-colors bg-white" data-sort="bawah15k">Dibawah 15k</button>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 p-4 border-t border-gray-100 bg-white shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">
                <button id="tt-modal-clear" class="flex-1 py-3 px-4 rounded-full border border-red-400 text-red-500 font-bold text-[14px] hover:bg-red-50 transition-colors">Bersihkan</button>
                <button id="tt-modal-apply" class="flex-1 py-3 px-4 rounded-full bg-[#F5A623] text-white font-bold text-[14px] hover:bg-[#D4891E] transition-colors">Terapkan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    const State = {
        activeCampusId : null,
        sortBy         : null,    
        activeCategory : null,   
        priceRange     : null,    
        searchQuery    : '',
        currentPage    : 1,
        itemsPerPage   : 15,
        allRestaurants : window.TT_RESTAURANTS || [],
    };

    window.TT_State = State;

    // PARSE HARGA
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

    // FILTER & SORT
    function getFiltered() {
        let list = [...State.allRestaurants];

        // 1. Filter kampus
        if (State.activeCampusId !== null) {
            list = list.filter(r => r.campus_id === State.activeCampusId);
        }

        // 1.5. Filter nama / menu
        if (State.searchQuery) {
            const q = State.searchQuery.toLowerCase();
            list = list.filter(r => 
                (r.name && r.name.toLowerCase().includes(q)) || 
                (r.category && r.category.toLowerCase().includes(q)) ||
                (r.food_type && r.food_type.toLowerCase().includes(q))
            );
        }

        // 2. Filter kategori makanan (dari sidebar checkboxes atau category circles)
        if (State.activeCategory) {
            list = list.filter(r => {
                const cat  = (r.category  || '').toLowerCase();
                switch (State.activeCategory) {
                    case 'makanan_berat': return cat === 'makanan_berat' || cat.includes('makanan');
                    case 'jajanan':      return cat === 'jajanan' || cat.includes('jajanan') || cat.includes('snack');
                    case 'minuman':      return cat === 'minuman' || cat.includes('minuman') || cat.includes('kopi') || cat.includes('es');
                    default:             return true;
                }
            });
        }

        // 3. Filter range harga
        if (State.priceRange === 'dibawah15k') {
            list = list.filter(r => parseMaxPrice(r.price_range) < 15000);
        } else if (State.priceRange === '15k-30k') {
            list = list.filter(r => {
                const min = parseMinPrice(r.price_range);
                const max = parseMaxPrice(r.price_range);
                return (min <= 30000 && max >= 15000);
            });
        } else if (State.priceRange === '30k-50k') {
            list = list.filter(r => {
                const min = parseMinPrice(r.price_range);
                const max = parseMaxPrice(r.price_range);
                return (min <= 50000 && max >= 30000);
            });
        } else if (State.priceRange === 'diatas50k') {
            list = list.filter(r => parseMaxPrice(r.price_range) >= 50000 || parseMinPrice(r.price_range) >= 50000);
        }

        // 4. Filter "dibawah 15k"
        if (State.sortBy === 'bawah15k') {
            list = list.filter(r => parseMaxPrice(r.price_range) < 15000);
        }

        // 5. Filter penilaian >= 4.5
        if (State.sortBy === 'penilaian') {
            list = list.filter(r => r.rating >= 4.5);
        }

        // 6. Sort
        switch (State.sortBy) {
            case 'populer':
                list.sort((a, b) => b.reviews_count - a.reviews_count || b.rating - a.rating);
                break;
            case 'terdekat':
                // Simulasi sorting terdekat sementara (menggunakan ID sebagai patokan dummy)
                list.sort((a, b) => b.id - a.id);
                break;
            case 'penilaian':
                list.sort((a, b) => b.rating - a.rating || b.reviews_count - a.reviews_count);
                break;
            case 'termurah':
            case 'bawah15k':
                list.sort((a, b) => parseMinPrice(a.price_range) - parseMinPrice(b.price_range));
                break;
        }

        return list;
    }

    // RENDER CARDS
    function renderCards() {
        const container = document.getElementById('tt-cards-container');
        const countInfo = document.getElementById('tt-count-info');
        const countNum  = document.getElementById('tt-count-num');
        const list      = getFiltered();

        if (!list.length) {
            container.innerHTML = `
                <div class="text-center py-20 col-span-2">
                    <i class="fas fa-utensils text-[#F5A623]/30 text-5xl mb-4 block"></i>
                    <p class="text-dark font-bold text-[15px] mb-1">Tidak ada restoran ditemukan</p>
                    <p class="text-muted text-[12px]">Coba ubah filter atau pilih lokasi lain</p>
                </div>`;
            countInfo.classList.add('hidden');
            return;
        }

        const totalItems = list.length;
        const totalPages = Math.ceil(totalItems / State.itemsPerPage);
        
        if (State.currentPage > totalPages) State.currentPage = totalPages;
        if (State.currentPage < 1) State.currentPage = 1;

        const startIndex = (State.currentPage - 1) * State.itemsPerPage;
        const endIndex = startIndex + State.itemsPerPage;
        const paginatedList = list.slice(startIndex, endIndex);

        container.innerHTML = `
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                ${paginatedList.map(r => cardHTML(r)).join('')}
            </div>
            ${renderPaginationHTML(totalPages)}
        `;

        container.querySelectorAll('.tt-card').forEach(card => {
            card.addEventListener('click', () => {
                window.location.href = card.dataset.url;
            });
        });

        countNum.textContent = totalItems;
        countInfo.classList.remove('hidden');
    }

    function renderPaginationHTML(totalPages) {
        if (totalPages <= 1) return '';

        let html = '<div class="mt-8 flex justify-center"><nav class="flex items-center gap-2">';

        if (State.currentPage === 1) {
            html += `<span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-400 opacity-50 cursor-not-allowed">&lt;</span>`;
        } else {
            html += `<button onclick="window.TT_goToPage(${State.currentPage - 1})" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-700 hover:bg-[#D98A2C] hover:text-white transition-colors">&lt;</button>`;
        }

        let lastShown = 0;
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= State.currentPage - 1 && i <= State.currentPage + 1)) {
                if (lastShown + 1 < i) {
                    html += `<span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium text-gray-500">...</span>`;
                }
                if (i === State.currentPage) {
                    html += `<span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold bg-[#D98A2C] text-white">${i}</span>`;
                } else {
                    html += `<button onclick="window.TT_goToPage(${i})" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-700 hover:bg-[#D98A2C] hover:text-white transition-colors">${i}</button>`;
                }
                lastShown = i;
            }
        }

        if (State.currentPage === totalPages) {
            html += `<span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-400 opacity-50 cursor-not-allowed">&gt;</span>`;
        } else {
            html += `<button onclick="window.TT_goToPage(${State.currentPage + 1})" class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-medium bg-[#F2E0BE] text-gray-700 hover:bg-[#D98A2C] hover:text-white transition-colors">&gt;</button>`;
        }

        html += '</nav></div>';
        return html;
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
                        ${r.formatted_category || ''}${r.food_type ? ', ' + r.food_type : ''}
                    </p>
                    <span class="mt-auto text-[10px] text-[#5d6e86] font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-star text-yellow-500 text-[9px]"></i>
                        ${ratingStr}
                        <span class="font-normal">(${r.reviews_count})</span>
                    </span>
                </div>
            </div>`;
    }

    // SIDEBAR FILTER LISTENERS
    
    // Price range 
    function applyPriceUI() {
        document.querySelectorAll('.tt-price-btn').forEach(btn => {
            const isActive = btn.dataset.value === State.priceRange;
            const dot   = btn.querySelector('.tt-radio-dot');
            const inner = btn.querySelector('.tt-radio-inner');
            const label = btn.querySelector('.tt-radio-label');
            dot.classList.toggle('border-[#F5A623]', isActive);
            dot.classList.toggle('border-gray-400', !isActive);
            inner.classList.toggle('opacity-100', isActive);
            inner.classList.toggle('opacity-0', !isActive);
            label.classList.toggle('text-[#F5A623]', isActive);
            label.classList.toggle('font-semibold', isActive);
            label.classList.toggle('text-dark', !isActive);
            label.classList.toggle('font-normal', !isActive);
        });
    }

    document.querySelectorAll('.tt-price-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (State.priceRange === this.dataset.value) {
                State.priceRange = null;  // toggle off
            } else {
                State.priceRange = this.dataset.value;  // switch
            }
            State.currentPage = 1;
            applyPriceUI();
            renderCards();
        });
    });

    // Sort
    function applySortRadioUI() {
        document.querySelectorAll('.tt-sort-btn').forEach(btn => {
            const isActive = btn.dataset.value === State.sortBy;
            const dot   = btn.querySelector('.tt-radio-dot');
            const inner = btn.querySelector('.tt-radio-inner');
            const label = btn.querySelector('.tt-radio-label');
            dot.classList.toggle('border-[#F5A623]', isActive);
            dot.classList.toggle('border-gray-400', !isActive);
            inner.classList.toggle('opacity-100', isActive);
            inner.classList.toggle('opacity-0', !isActive);
            label.classList.toggle('text-[#F5A623]', isActive);
            label.classList.toggle('font-semibold', isActive);
            label.classList.toggle('text-dark', !isActive);
            label.classList.toggle('font-normal', !isActive);
        });
    }

    document.querySelectorAll('.tt-sort-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (State.sortBy === this.dataset.value) {
                State.sortBy = null;  // toggle off
            } else {
                State.sortBy = this.dataset.value;  // switch
            }
            State.currentPage = 1;
            applySortRadioUI();
            updateFilterUI();
            renderCards();
        });
    });

    // Category
    document.querySelectorAll('.tt-cat-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (State.activeCategory === this.dataset.value) {
                State.activeCategory = null; // toggle off
            } else {
                State.activeCategory = this.dataset.value; // switch
            }
            State.currentPage = 1;
            updateCategoryUI();
            renderCards();
        });
    });



    // Sidebar Reset
    document.getElementById('tt-sidebar-reset')?.addEventListener('click', () => {
        State.sortBy = null;
        State.activeCategory = null;
        State.priceRange = null;
        State.currentPage = 1;
        applyPriceUI();
        applySortRadioUI();
        updateCategoryUI();
        updateFilterUI();
        updateCategoryUI();
        renderCards();
    });

    // MOBILE CHIP FILTER & MODAL
    function updateFilterUI() {
        document.querySelectorAll('.tt-sort-chip, .tt-modal-chip').forEach(b => {
            const isActive = b.dataset.sort === State.sortBy;
            b.classList.toggle('bg-[#F5A623]', isActive);
            b.classList.toggle('text-white', isActive);
            b.classList.toggle('border-[#F5A623]', isActive);
            b.classList.toggle('bg-white', !isActive);
            b.classList.toggle('text-dark', !isActive);
            b.classList.toggle('border-gray-300', !isActive);
            // Hover: hanya muncul saat belum dipilih (inactive)
            b.classList.toggle('hover:bg-[#F5A623]/10', !isActive);
            b.classList.toggle('hover:border-[#F5A623]/30', !isActive);
        });

        const btnFilter = document.getElementById('tt-btn-filter-modal');
        const iconFilter = btnFilter ? btnFilter.querySelector('.tt-btn-filter-icon') : null;
        const textFilter = btnFilter ? btnFilter.querySelector('.tt-filter-text') : null;
        if (btnFilter && iconFilter) {
            const isFilterActive = State.sortBy !== null;
            btnFilter.classList.toggle('bg-[#F5A623]', isFilterActive);
            btnFilter.classList.toggle('border-[#F5A623]', isFilterActive);
            btnFilter.classList.toggle('hover:bg-[#F5A623]/10', !isFilterActive);
            btnFilter.classList.toggle('hover:border-[#F5A623]/30', !isFilterActive);
            iconFilter.classList.toggle('text-white', isFilterActive);
            iconFilter.classList.toggle('text-gray-500', !isFilterActive);
            if (textFilter) {
                textFilter.classList.toggle('text-white', isFilterActive);
                textFilter.classList.toggle('text-dark', !isFilterActive);
            }
            btnFilter.classList.toggle('bg-white', !isFilterActive);
            btnFilter.classList.toggle('border-gray-300', !isFilterActive);
        }
    }

    document.querySelectorAll('.tt-sort-chip, .tt-modal-chip').forEach(btn => {
        btn.addEventListener('click', () => {
            const val = btn.dataset.sort;
            State.sortBy = State.sortBy === val ? null : val;
            State.currentPage = 1;
            updateFilterUI();
            renderCards();
        });
    });

    // Modal open/close
    const filterModal   = document.getElementById('tt-filter-modal');
    const filterBackdrop = document.getElementById('tt-filter-backdrop');
    const filterWrapper  = document.getElementById('tt-filter-modal-wrapper');

    function openFilterModal() {
        if (!filterModal) return;
        filterModal.classList.remove('hidden');
        void filterModal.offsetWidth;
        filterBackdrop.classList.remove('opacity-0');
        filterWrapper.classList.remove('translate-y-full');
    }

    function closeFilterModal() {
        if (!filterModal) return;
        filterBackdrop.classList.add('opacity-0');
        filterWrapper.classList.add('translate-y-full');
        setTimeout(() => filterModal.classList.add('hidden'), 300);
    }

    document.getElementById('tt-btn-filter-modal')?.addEventListener('click', openFilterModal);
    document.getElementById('tt-close-modal-mobile')?.addEventListener('click', closeFilterModal);
    filterBackdrop?.addEventListener('click', closeFilterModal);

    document.getElementById('tt-modal-apply')?.addEventListener('click', () => {
        State.currentPage = 1;
        renderCards();
        closeFilterModal();
    });

    document.getElementById('tt-modal-clear')?.addEventListener('click', () => {
        State.sortBy = null;
        State.activeCategory = null;
        State.priceRange = null;
        State.currentPage = 1;
        updateFilterUI();
        updateCategoryUI();
        renderCards();
        closeFilterModal();
    });

    updateFilterUI();

    // CATEGORY CIRCLES UI (from category.blade.php icons)
    function updateCategoryUI() {
        document.querySelectorAll('.tt-cat-item').forEach(i => {
            const isCat = i.dataset.category;
            const isActive = (isCat === State.activeCategory) || (!State.activeCategory && isCat === 'semua');
            const iconWrap = i.querySelector('.tt-cat-icon');
            const icon     = iconWrap?.querySelector('i');
            const label    = i.querySelector('.cat-label');

            if (isActive) {
                iconWrap?.classList.remove('bg-[#F3F4F6]', 'border-transparent');
                iconWrap?.classList.add('bg-[#FFF3E0]', 'border-[#F5A623]');
                icon?.classList.remove('text-[#374151]');
                icon?.classList.add('text-[#F5A623]');
                label?.classList.remove('text-muted', 'font-medium');
                label?.classList.add('text-dark', 'font-bold');
            } else {
                iconWrap?.classList.add('bg-[#F3F4F6]', 'border-transparent');
                iconWrap?.classList.remove('bg-[#FFF3E0]', 'border-[#F5A623]');
                icon?.classList.add('text-[#374151]');
                icon?.classList.remove('text-[#F5A623]');
                label?.classList.remove('text-dark', 'font-bold');
                label?.classList.add('text-muted', 'font-medium');
            }
        });

        // Sync custom category radio in sidebar
        document.querySelectorAll('.tt-cat-btn').forEach(btn => {
            const isActive = btn.dataset.value === State.activeCategory;
            const dot   = btn.querySelector('.tt-radio-dot');
            const inner = btn.querySelector('.tt-radio-inner');
            const label = btn.querySelector('.tt-radio-label');
            dot.classList.toggle('border-[#F5A623]', isActive);
            dot.classList.toggle('border-gray-400', !isActive);
            inner.classList.toggle('opacity-100', isActive);
            inner.classList.toggle('opacity-0', !isActive);
            label.classList.toggle('text-[#F5A623]', isActive);
            label.classList.toggle('font-semibold', isActive);
            label.classList.toggle('text-dark', !isActive);
            label.classList.toggle('font-normal', !isActive);
        });
    }

    document.querySelectorAll('.tt-cat-item').forEach(item => {
        item.addEventListener('click', () => {
            const cat = item.dataset.category;
            if (cat === 'semua') {
                State.activeCategory = null;
            } else if (State.activeCategory === cat) {
                State.activeCategory = null;
            } else {
                State.activeCategory = cat;
            }
            State.currentPage = 1;
            updateCategoryUI();
            renderCards();
        });
    });

    // EXPOSE global functions
    window.TT_selectCampus = function(campusId) {
        State.activeCampusId = campusId;
        State.currentPage = 1;
        renderCards();
    };

    window.TT_clearCampus = function() {
        State.activeCampusId = null;
        State.currentPage = 1;
        renderCards();
    };

    window.TT_searchQuery = function(query) {
        State.searchQuery = query;
        State.currentPage = 1;
        renderCards();
    };

    window.TT_goToPage = function(page) {
        State.currentPage = page;
        renderCards();
        document.getElementById('tt-cards-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
    };

    // SEARCH BAR LOGIC
    const searchInput = document.getElementById('search-input');
    const searchClearBtn = document.getElementById('search-clear');
    if (searchInput && searchClearBtn) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            searchClearBtn.classList.toggle('hidden', !query);
            window.TT_searchQuery(query);
        });
        searchClearBtn.addEventListener('click', () => {
            searchInput.value = '';
            searchClearBtn.classList.add('hidden');
            searchInput.focus();
            window.TT_searchQuery('');
        });
    }

    // INIT
    renderCards();
})();
</script>
@endpush