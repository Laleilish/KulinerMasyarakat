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

<section class="px-5 pb-6">

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

</section>

@push('scripts')
<script>
(function() {
    // ─────────────────────────────────────────────────────────────────
    // STATE
    // ─────────────────────────────────────────────────────────────────
    const State = {
        activeCampusId : null,   // null = semua kampus
        sortBy         : 'populer', // 'populer' | 'penilaian' | 'termurah' | 'bawah10k'
        activeCategory : null,   // null = semua | 'makanan' | 'minuman' | 'jajanan' | 'snack'
        allRestaurants : window.TT_RESTAURANTS || [],
    };

    // Expose state agar bisa diakses dari hero.blade.php
    window.TT_State = State;

    // ─────────────────────────────────────────────────────────────────
    // PARSE HARGA dari price_range string → angka
    // e.g. "Rp 5.000 - Rp 10.000" → 5000
    // ─────────────────────────────────────────────────────────────────
    function parseMinPrice(priceRange) {
        if (!priceRange) return Infinity;
        const nums = priceRange.replace(/[^0-9.]/g, ' ').trim().split(/\s+/).filter(Boolean);
        if (!nums.length) return Infinity;
        // Ambil angka pertama, hapus titik ribuan
        return parseInt(nums[0].replace(/\./g, ''), 10) || Infinity;
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
                    case 'makanan':
                        return cat.includes('makanan') || cat.includes('nasi') || cat.includes('mie')
                            || cat.includes('ayam') || cat.includes('seafood') || cat.includes('soto')
                            || type.includes('makanan') || type.includes('nasi');
                    case 'minuman':
                        return cat.includes('minuman') || cat.includes('kopi') || cat.includes('es')
                            || cat.includes('juice') || cat.includes('cafe') || cat.includes('kafe')
                            || type.includes('minuman') || type.includes('kopi') || type.includes('es');
                    case 'jajanan':
                        return cat.includes('jajanan') || cat.includes('snack') || cat.includes('cemilan')
                            || cat.includes('gorengan') || cat.includes('bakso') || cat.includes('sate')
                            || type.includes('jajanan') || type.includes('snack');
                    case 'manis':
                        return cat.includes('manis') || cat.includes('dessert') || cat.includes('kue')
                            || cat.includes('bakery') || cat.includes('roti') || cat.includes('es krim')
                            || type.includes('manis') || type.includes('dessert') || type.includes('kue');
                    default:
                        return true;
                }
            });
        }

        // 3. Filter sort "Dibawah 10k"
        if (State.sortBy === 'bawah10k') {
            list = list.filter(r => parseMinPrice(r.price_range) <= 10000);
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
    // FILTER CHIPS (sort)
    // ─────────────────────────────────────────────────────────────────
    document.querySelectorAll('.tt-sort-chip').forEach(btn => {
        btn.addEventListener('click', () => {
            const val = btn.dataset.sort;

            // Toggle: jika aktif diklik lagi → reset ke populer
            if (State.sortBy === val && val !== 'populer') {
                State.sortBy = 'populer';
            } else {
                State.sortBy = val;
            }

            // Update visual
            document.querySelectorAll('.tt-sort-chip').forEach(b => {
                const isActive = b.dataset.sort === State.sortBy;
                b.classList.toggle('bg-[#F5A623]', isActive);
                b.classList.toggle('text-white', isActive);
                b.classList.toggle('border-transparent', isActive);
                b.classList.toggle('text-[#F5A623]', !isActive);
                b.classList.toggle('border-[#F5A623]', !isActive);
                b.classList.toggle('bg-transparent', !isActive);
            });

            renderCards();
        });
    });

    // ─────────────────────────────────────────────────────────────────
    // CATEGORY CIRCLES
    // ─────────────────────────────────────────────────────────────────
    document.querySelectorAll('.tt-cat-item').forEach(item => {
        item.addEventListener('click', () => {
            const cat = item.dataset.category;

            // Toggle
            if (State.activeCategory === cat) {
                State.activeCategory = null;
            } else {
                State.activeCategory = cat;
            }

            // Update visual
            document.querySelectorAll('.tt-cat-item').forEach(i => {
                const isActive = i.dataset.category === State.activeCategory;
                const ring  = i.querySelector('.cat-ring');
                const label = i.querySelector('.cat-label');
                ring.classList.toggle('border-[#F5A623]', true);
                ring.classList.toggle('bg-[#FFF7ED]', isActive);
                ring.classList.toggle('scale-110', isActive);
                ring.classList.toggle('shadow-md', isActive);
                label.classList.toggle('text-[#C07A2A]', isActive);
                label.classList.toggle('font-extrabold', isActive);
                label.classList.toggle('text-dark', !isActive);
            });

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