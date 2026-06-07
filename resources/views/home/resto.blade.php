{{-- Embed semua data restoran sebagai JSON untuk filter client-side --}}
@php
    $homeRestaurantsData = $restaurants->map(function($r) {
        return [
            'id'          => $r->id,
            'name'        => $r->name,
            'image'       => $r->image ? (str_starts_with($r->image, 'http') ? $r->image : asset('storage/' . $r->image)) : asset('assets/img/Restoran Favorit/Nasi Goreng Kambing.png'),
            'category'    => $r->category,
            'food_type'   => $r->food_type,
            'landmark'    => $r->landmark,
            'campus_id'   => $r->campus_id,
            'rating'      => round($r->reviews_avg_rating ?? 0, 1),
            'reviews_count' => $r->reviews_count ?? 0,
            'url'         => route('restoran.show', $r->id),
            'default_img' => asset('assets/img/Restoran Favorit/Nasi Goreng Kambing.png'),
        ];
    })->values()->all();
@endphp

<section class="bg-cream-bg text-center px-5 pt-4 pb-6 md:px-10 md:py-[30px]">

    <div class="flex items-center justify-between mb-6">
        <h2 id="home-resto-title" class="text-2xl md:text-3xl font-bold text-dark">Restoran Terfavorit</h2>
        <span id="home-campus-badge" class="hidden text-[12px] font-bold text-[#C07A2A] bg-[#FFF7ED] px-3 py-1 rounded-full border border-[#F5A623]/40"></span>
    </div>

    {{-- Kontainer cards —  diisi oleh JS --}}
    <div id="home-cards-container" class="grid grid-cols-2 md:grid-cols-4 gap-4 text-left">
        {{-- Skeleton loading awal --}}
        @for($i = 0; $i < 12; $i++)
            <div class="bg-white rounded-xl overflow-hidden border border-black/[0.05] animate-pulse">
                <div class="w-full h-[130px] md:h-[230px] bg-gray-200"></div>
                <div class="p-3 space-y-2">
                    <div class="h-3 bg-gray-200 rounded w-3/4"></div>
                    <div class="h-2 bg-gray-200 rounded w-1/2"></div>
                    <div class="h-2 bg-gray-200 rounded w-1/3"></div>
                </div>
            </div>
        @endfor
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('semua-resto') }}" class="inline-block px-4 py-1.5 md:px-6 md:py-2.5 bg-transparent border-2 border-[#EF950F] text-[#EF950F] text-[12px] md:text-[14px] lg:text-base font-bold rounded-full hover:bg-[#EF950F] hover:text-white transition-colors duration-200">
            Lihat Semua Restoran
        </a>
    </div>
</section>

@push('scripts')
<script>
    window.HOME_RESTAURANTS = @json($homeRestaurantsData);

    (function() {
        const State = {
            activeCampusId : null,
            allRestaurants : window.HOME_RESTAURANTS || [],
        };

        function renderCards() {
            const container = document.getElementById('home-cards-container');
            const title     = document.getElementById('home-resto-title');
            
            let list = [...State.allRestaurants];

            if (State.activeCampusId !== null) {
                list = list.filter(r => r.campus_id === State.activeCampusId);
                title.textContent = 'Restoran di Lokasi Ini';
            } else {
                // Default home page -> top 12 only
                list = list.slice(0, 12);
                title.textContent = 'Restoran Terfavorit';
            }

            if (!list.length) {
                container.innerHTML = `
                    <div class="col-span-2 md:col-span-4 text-center py-10">
                        <i class="fas fa-utensils text-[#F5A623]/30 text-5xl mb-4 block mx-auto"></i>
                        <p class="text-dark font-bold text-[15px] mb-1">Tidak ada restoran ditemukan</p>
                        <p class="text-muted text-[12px]">Coba ubah lokasi atau pilih kampus lain</p>
                    </div>`;
                return;
            }

            container.innerHTML = list.map(r => cardHTML(r)).join('');

            // Attach click listeners
            container.querySelectorAll('.home-card').forEach(card => {
                card.addEventListener('click', () => {
                    window.location.href = card.dataset.url;
                });
            });
        }

        function cardHTML(r) {
            const ratingStr = r.rating > 0 ? r.rating.toFixed(1) : '—';
            return `
                <div class="home-card flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover text-left"
                     data-url="${r.url}">
                    <img src="${r.image}" alt="${r.name}"
                         class="w-full h-[130px] md:h-[230px] object-cover"
                         onerror="this.src='${r.default_img}'">
                    
                    <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                        <h3 class="text-base font-bold text-dark leading-snug mb-1">
                            ${r.name}${r.landmark ? ', ' + r.landmark : ''}
                        </h3>
                        <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">
                            ${r.category || ''}${r.food_type ? ', ' + r.food_type : ''}
                        </p>
                        <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-star text-yellow-500"></i> ${ratingStr} (${r.reviews_count})
                        </span>
                    </div>
                </div>`;
        }

        window.HOME_selectCampus = function(campusId, campusName) {
            State.activeCampusId = campusId;
            const badge = document.getElementById('home-campus-badge');
            if (campusName) {
                badge.textContent = campusName;
                badge.classList.remove('hidden');
                badge.classList.add('inline-block');
            }
            renderCards();
        };

        window.HOME_clearCampus = function() {
            State.activeCampusId = null;
            const badge = document.getElementById('home-campus-badge');
            badge.classList.add('hidden');
            badge.classList.remove('inline-block');
            renderCards();
        };

        renderCards();
    })();
</script>
@endpush
