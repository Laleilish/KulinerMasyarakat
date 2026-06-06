        // CAROUSEL
        (function initCarousel() {
            const track = document.getElementById('featured-carousel');
            const dots = document.querySelectorAll('.carousel-dot');
            const btnPrev = document.getElementById('carousel-prev');
            const btnNext = document.getElementById('carousel-next');

            if (!track) return;

            function getActiveIndex() {
                const slides = track.querySelectorAll('.featured-slide');
                let minDist = Infinity;
                let idx = 0;
                slides.forEach((s, i) => {
                    const d = Math.abs(s.offsetLeft - track.scrollLeft);
                    if (d < minDist) { minDist = d; idx = i; }
                });
                return idx;
            }

            function updateDots() {
                const active = getActiveIndex();
                dots.forEach((dot, i) => {
                    const isActive = i === active;
                    dot.classList.toggle('w-5', isActive);
                    dot.classList.toggle('bg-[#F5A623]', isActive);
                    dot.classList.toggle('w-[5px]', !isActive);
                    dot.classList.toggle('bg-black/15', !isActive);
                });
                if (btnPrev) btnPrev.disabled = track.scrollLeft <= 0;
                if (btnNext) btnNext.disabled =
                    track.scrollLeft >= track.scrollWidth - track.clientWidth - 10;
            }

            function scrollToSlide(index) {
                const slides = track.querySelectorAll('.featured-slide');
                if (slides[index]) {
                    track.scrollTo({ left: slides[index].offsetLeft, behavior: 'smooth' });
                }
            }

            dots.forEach((dot, i) => dot.addEventListener('click', () => scrollToSlide(i)));

            btnPrev?.addEventListener('click', () => track.scrollBy({ left: -380, behavior: 'smooth' }));
            btnNext?.addEventListener('click', () => track.scrollBy({ left: 380, behavior: 'smooth' }));

            track.addEventListener('scroll', updateDots, { passive: true });

            // Klik featured slide â†’ langsung ke detail resto
            track.querySelectorAll('.featured-slide').forEach(slide => {
                slide.addEventListener('click', () => {
                    try {
                        const r = JSON.parse(slide.dataset.resto);
                        window.location.href = `/restoran/${r.id}`;
                    } catch { }
                });
            });

            updateDots();
        })();

        // TOP RESTO CARD CLICK (static dari server)
        document.querySelectorAll('.top-resto-card').forEach(card => {
            card.addEventListener('click', () => {
                try {
                    const r = JSON.parse(card.dataset.resto);
                    window.location.href = `/restoran/${r.id}`;
                } catch { }
            });
        });

        // UPDATE RESTAURANT CARDS
        function updateRestaurants(restaurants, featuredRestaurants = []) {
            const grid = document.getElementById('resto-cards');
            const skeleton = document.getElementById('cards-loading');

            if (!restaurants.length) {
                grid.innerHTML = `
                                    <div class="col-span-2 md:col-span-3 lg:col-span-4
                                                text-center py-8 text-muted text-[13px]">
                                        Belum ada restoran di kampus ini.
                                    </div>`;
                return;
            }

            const cardHTML = (r) => {
                const ratingStr = r.rating != null ? parseFloat(r.rating).toFixed(1) : '—';
                const distStr = calcRestoDistance(r.latitude, r.longitude, r.distance);
                const priceStr = r.price_range || '—';
                return `
                    <div class="top-resto-card bg-white rounded-[16px] overflow-hidden
                                border border-black/[0.05]
                                shadow-[0_2px_8px_rgba(0,0,0,0.08)]
                                cursor-pointer
                                transition-all duration-200
                                hover:-translate-y-[3px]
                                hover:shadow-[0_8px_24px_rgba(0,0,0,0.12)]
                                active:scale-[0.98]"
                            data-resto='${JSON.stringify(r).replace(/'/g, "&#39;")}'>

                        <div class="relative w-full h-[130px] overflow-hidden">
                            <img src="${r.image}"
                                    alt="${r.name}"
                                    class="w-full h-full object-cover
                                        transition-transform duration-300"
                                    onerror="this.src='/assets/img/resto/default.png'">

                            <div class="absolute top-2 right-2">
                                <span style="
                                    display:inline-flex;align-items:center;gap:3px;
                                    background:rgba(0,0,0,0.3);color:#fff;
                                    font-size:10px;font-weight:700;
                                    padding:3px 7px;border-radius:99px;
                                    backdrop-filter:blur(4px);
                                ">
                                    ★ ${ratingStr}
                                </span>
                            </div>

                            ${r.is_featured ? `
                            <div class="absolute top-2 left-2">
                                <span style="
                                    background:#F5A623;color:#fff;
                                    font-size:9px;font-weight:700;
                                    padding:2px 6px;border-radius:99px;
                                ">Unggulan</span>
                            </div>` : ''}
                        </div>

                        <div style="padding:10px 12px 12px;">
                            <p style="
                                font-size:12px;font-weight:800;
                                color:#040818;line-height:1.4;
                                margin-bottom:3px;
                                display:-webkit-box;-webkit-line-clamp:2;
                                -webkit-box-orient:vertical;overflow:hidden;
                            ">${r.name}</p>

                            <p style="font-size:11px;color:#5d6e86;margin-bottom:7px;">
                                ${formatCategory(r.category)}
                            </p>

                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <span style="font-size:11px;color:#02b176;font-weight:700;">
                                    <i class="fas fa-location-dot text-[9px]"></i> ${distStr}
                                </span>
                                <span style="font-size:10px;color:#5d6e86;">
                                    ${priceStr}
                                </span>
                            </div>
                        </div>
                    </div>`;
            };

            grid.innerHTML = `
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    ${restaurants.map(r => cardHTML(r)).join('')}
                                </div>`;

            // Attach click listeners — langsung ke halaman detail
            grid.querySelectorAll('.top-resto-card').forEach(card => {
                card.addEventListener('click', () => {
                    try {
                        const r = JSON.parse(card.dataset.resto);
                        window.location.href = `/restoran/${r.id}`;
                    } catch (e) {
                        console.error('Parse error:', e);
                    }
                });
            });
        }

        // UPDATE FEATURED CAROUSEL
        function updateFeaturedCarousel(restaurants) {

            const track = document.getElementById('featured-carousel');
            const dots = document.getElementById('carousel-dots');

            if (!track) return;

            if (!restaurants.length) {
                track.innerHTML = `
                        <div class="w-full bg-white rounded-[20px]
                                    border border-black/[0.06]
                                    p-8 text-center">
                            <p class="text-[13px] text-muted">
                                Belum ada hidden gem unggulan.
                            </p>
                        </div>
                    `;

                dots.innerHTML = '';
                return;
            }

            track.innerHTML = restaurants.map((r, index) => {
                const ratingStr = r.rating != null ? parseFloat(r.rating).toFixed(1) : '—';
                const distStr = calcRestoDistance(r.latitude, r.longitude, r.distance);
                const descStr = r.description || '';
                return `
                    <div class="featured-slide flex-shrink-0 snap-start
                    w-[calc(100vw-48px)] md:w-[760px] max-w-none">

                    <div onclick='window.location.href="/restoran/${r.id}"'
                        class="bg-gradient-to-br from-[#D08700] to-[#EFB100]
                            rounded-[22px] overflow-hidden cursor-pointer">

                    <div class="relative w-full h-[160px] md:h-[220px] overflow-hidden">
                        <img src="${r.image}"
                         class="w-full h-full object-cover"
                         onerror="this.src='/assets/img/resto/default.png'">

                                <div class="absolute inset-0
                                            bg-gradient-to-t
                                            from-black/40
                                            to-transparent">
                                </div>

                                <div class="absolute top-3 left-3">
                                    <span class="bg-white/90 text-[#C07A2A]
                                                 text-[10px] font-bold
                                                 px-2 py-1 rounded-full">
                                        Rekomendasi
                                    </span>
                                </div>

                                <div class="absolute top-3 right-3">
                                    <span class="bg-black/30 text-white
                                                 text-[11px] font-bold
                                                 px-2 py-1 rounded-full">
                                        ★ ${ratingStr}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4">
                                <h3 class="text-white text-[16px]
                                           font-extrabold mb-1">
                                    ${r.name}
                                </h3>

                                <p class="text-white/80 text-[12px]
                                          line-clamp-2 mb-3">
                                    ${descStr}
                                </p>

                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="bg-white/20 text-white
                                                 text-[10px] font-bold
                                                 px-2 py-1 rounded-full">
                                        📍 ${distStr}
                                    </span>

                                    <span class="bg-white/20 text-white
                                                 text-[10px] font-bold
                                                 px-2 py-1 rounded-full">
                                        ${formatCategory(r.category)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            dots.innerHTML = restaurants.map((_, i) => `
                    <button class="carousel-dot
                                   ${i === 0
                    ? 'w-5 bg-[#F5A623]'
                    : 'w-[5px] bg-black/15'}
                                   h-[5px] rounded-full">
                    </button>
                `).join('');
        }

        // AUTOCOMPLETE DROPDOWN
        function renderDropdownCampus(query = '') {
            const list = document.getElementById('dropdown-campus-list');
            const filtered = query
                ? CAMPUSES.filter(c => c.name.toLowerCase().includes(query.toLowerCase()))
                : CAMPUSES;

            if (!filtered.length) {
                document.getElementById('dropdown-campus-section').classList.add('hidden');
                return;
            }

            document.getElementById('dropdown-campus-section').classList.remove('hidden');
            list.innerHTML = filtered.map(c => `
                                            <div class="dropdown-item flex items-center gap-3 px-4 py-3
                                                        hover:bg-black/[0.03] cursor-pointer transition-colors duration-100"
                                                 data-type="campus" data-id="${c.id}"
                                                 data-lat="${c.latitude}" data-lng="${c.longitude}" data-name="${c.name}">
                                                <div class="w-8 h-8 rounded-[10px] bg-[#F5A623] flex items-center
                                                            justify-center flex-shrink-0 overflow-hidden">
                                                    <img src="${c.logo}" alt="${c.name}"
                                                         class="w-6 h-6 object-contain"
                                                         onerror="this.style.display='none'">
                                                </div>
                                                <div>
                                                    <p class="text-[12px] font-bold text-dark">${c.name}</p>
                                                    <p class="text-[10px] text-muted">Kampus</p>
                                                </div>
                                            </div>`).join('');
        }

        function renderDropdownSearch(results) {
            const section = document.getElementById('dropdown-search-section');
            const list = document.getElementById('dropdown-search-list');

            if (!results.length) {
                section.classList.add('hidden');
                return;
            }

            section.classList.remove('hidden');
            list.innerHTML = results.map(r => `
                                            <div class="dropdown-item flex items-center gap-3 px-4 py-3
                                                        hover:bg-black/[0.03] cursor-pointer transition-colors duration-100"
                                                 data-type="location" data-lat="${r.lat}" data-lng="${r.lon}"
                                                 data-name="${r.display_name.split(',').slice(0, 2).join(',')}">
                                                <div class="w-8 h-8 rounded-full bg-[#F5EDE0] flex items-center
                                                            justify-center flex-shrink-0">
                                                    <i class="fas fa-map-pin text-[#C07A2A] text-[13px]"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[12px] font-bold text-dark truncate">
                                                        ${r.display_name.split(',')[0]}
                                                    </p>
                                                    <p class="text-[10px] text-muted truncate">
                                                        ${r.display_name.split(',').slice(1, 3).join(',')}
                                                    </p>
                                                </div>
                                            </div>`).join('');
        }

        function openDropdown() {
            const dd = document.getElementById('loc-dropdown');
            dd.classList.remove('hidden');
            State.isDropdownOpen = true;
            renderDropdownCampus();
            document.getElementById('dropdown-empty').classList.add('hidden');
        }

        function closeDropdown() {
            document.getElementById('loc-dropdown').classList.add('hidden');
            State.isDropdownOpen = false;
        }

        async function handleSearchInput(query) {
            const clearBtn = document.getElementById('loc-clear');
            clearBtn.classList.toggle('hidden', !query);

            if (!query) {
                renderDropdownCampus();
                document.getElementById('dropdown-search-section').classList.add('hidden');
                document.getElementById('dropdown-empty').classList.add('hidden');
                document.getElementById('dropdown-loading').classList.add('hidden');
                return;
            }

            // Filter kampus dulu
            renderDropdownCampus(query);

            // Debounce search Nominatim
            clearTimeout(State.searchTimer);
            State.searchTimer = setTimeout(async () => {
                document.getElementById('dropdown-loading').classList.remove('hidden');
                document.getElementById('dropdown-empty').classList.add('hidden');

                const results = await searchLocation(query);

                document.getElementById('dropdown-loading').classList.add('hidden');

                if (!results.length) {
                    const campusSection = document.getElementById('dropdown-campus-section');
                    if (campusSection.classList.contains('hidden')) {
                        document.getElementById('dropdown-empty').classList.remove('hidden');
                    }
                } else {
                    renderDropdownSearch(results);
                }
            }, 500);
        }

        // MODAL
        // Mini-map instance tracker
        let _modalMiniMap = null;
        let _modalMiniMarker = null;

        function openModal(r) {
            //  Basic fields
            document.getElementById('modal-image').src = r.image;
            document.getElementById('modal-name').textContent = r.name;
            document.getElementById('modal-category').textContent = formatCategory(r.category);

            const modalRating = r.rating != null
                ? `★ ${parseFloat(r.rating).toFixed(1)}`
                : '★ —';
            const modalDist = calcRestoDistance(r.latitude, r.longitude, r.distance);
            document.getElementById('modal-rating').textContent   = modalRating;
            document.getElementById('modal-distance').textContent = modalDist
                ? `📍 ${modalDist}` : '';
            document.getElementById('modal-desc').textContent  = r.description || 'Tidak ada deskripsi.';
            document.getElementById('modal-price').textContent = r.price_range || '—';
            document.getElementById('modal-address').textContent = r.address || '—';
            document.getElementById('modal-hours').textContent   = r.open_hours || '—';

            //  Google Maps link
            const gmapsEl = document.getElementById('modal-gmaps');
            const gmapsHref = r.gmaps_link
                || `https://www.google.com/maps?q=${r.latitude},${r.longitude}`;
            gmapsEl.href = gmapsHref;

            // Detail btn
            const detailBtn = document.getElementById('modal-detail-btn');
            if (detailBtn) detailBtn.href = `/restoran/${r.id}`;

            // Tulis Ulasan btn
            const reviewBtn = document.getElementById('modal-review-btn');
            if (reviewBtn) reviewBtn.href = `/restoran/${r.id}#ulasan`;

            //  Navigasi btn
            const navBtn = document.getElementById('modal-nav-btn');
            navBtn.onclick = function (e) {
                e.preventDefault();
                closeModal();
                startNavigation(r.latitude, r.longitude);
            };

            //  Fasilitas chips
            const facWrap = document.getElementById('modal-facilities');
            const facilities = buildFacilities(r);
            if (facilities.length) {
                facWrap.innerHTML = facilities.map(f =>
                    `<span class="flex items-center gap-2
                                  bg-white border border-black/[0.08]
                                  text-dark text-[12px] font-semibold
                                  px-3 py-[6px] rounded-full
                                  shadow-[0_1px_4px_rgba(0,0,0,0.06)]">
                        <i class="${f.icon} text-[#C07A2A] text-[11px]"></i>
                        ${f.label}
                    </span>`
                ).join('');
            } else {
                facWrap.innerHTML = '<p class="text-[12px] text-muted">—</p>';
            }

            //  Mini Map
            renderModalMiniMap(r.latitude, r.longitude, r.name);

            //  Reviews
            fetchAndRenderReviews(r.id);

            //  Show modal
            document.getElementById('resto-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Scroll sheet ke atas
            const sheet = document.getElementById('modal-sheet');
            if (sheet) {
                const scrollable = sheet.querySelector('.overflow-y-auto');
                if (scrollable) scrollable.scrollTop = 0;
            }
        }

        // Build fasilitas dari data restoran yang tersedia
        function buildFacilities(r) {
            const chips = [];
            const ft = (r.food_type || '').toLowerCase();
            const cat = (r.category || '').toLowerCase();

            // Dari food_type
            if (ft.includes('halal') || cat.includes('halal')) {
                chips.push({ icon: 'fas fa-check-circle', label: 'Halal' });
            }
            if (ft.includes('outdoor') || ft.includes('lesehan')) {
                chips.push({ icon: 'fas fa-umbrella-beach', label: 'Outdoor' });
            }
            if (ft.includes('indoor')) {
                chips.push({ icon: 'fas fa-store', label: 'Indoor' });
            }
            if (ft.includes('parkir') || ft.includes('parking')) {
                chips.push({ icon: 'fas fa-square-parking', label: 'Parkir' });
            }
            if (ft.includes('wifi') || ft.includes('wi-fi')) {
                chips.push({ icon: 'fas fa-wifi', label: 'Gratis WiFi' });
            }
            if (ft.includes('ac') || ft.includes('ber-ac')) {
                chips.push({ icon: 'fas fa-snowflake', label: 'Ber-AC' });
            }
            if (ft.includes('vegetarian') || ft.includes('vegan')) {
                chips.push({ icon: 'fas fa-leaf', label: 'Vegetarian' });
            }
            if (ft.includes('delivery') || ft.includes('go-jek') || ft.includes('grab')) {
                chips.push({ icon: 'fas fa-motorcycle', label: 'Delivery' });
            }

            // Jika tidak ada apapun, tampilkan food_type mentah
            if (!chips.length && r.food_type) {
                const raw = r.food_type.split(',').map(s => s.trim()).filter(Boolean);
                raw.slice(0, 4).forEach(t =>
                    chips.push({ icon: 'fas fa-utensils', label: t })
                );
            }

            return chips;
        }

        // Render mini-map di dalam modal
        function renderModalMiniMap(lat, lng, name) {
            if (!lat || !lng) {
                document.getElementById('modal-mini-map').innerHTML =
                    '<div class="w-full h-full bg-black/[0.04] flex items-center justify-center">' +
                    '<p class="text-[12px] text-muted">Koordinat tidak tersedia</p></div>';
                return;
            }

            const container = document.getElementById('modal-mini-map');

            // Hapus map lama
            if (_modalMiniMap) {
                _modalMiniMap.remove();
                _modalMiniMap = null;
                _modalMiniMarker = null;
                container.innerHTML = '';
            }

            // Beri waktu DOM render
            setTimeout(() => {
                _modalMiniMap = L.map('modal-mini-map', {
                    center: [lat, lng],
                    zoom: 16,
                    zoomControl: false,
                    dragging: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    boxZoom: false,
                    keyboard: false,
                    attributionControl: false,
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(_modalMiniMap);

                const icon = L.icon({
                    iconUrl: '/assets/img/icon-loc.png',
                    iconSize: [28],
                    iconAnchor: [14, 14],
                });

                _modalMiniMarker = L.marker([lat, lng], { icon })
                    .addTo(_modalMiniMap)
                    .bindPopup(`<b style="font-size:12px;">${name}</b>`)
                    .openPopup();

                _modalMiniMap.invalidateSize();
            }, 80);
        }

        // Fetch dan render ulasan
        async function fetchAndRenderReviews(restoId) {
            const listEl    = document.getElementById('modal-reviews-list');
            const emptyEl   = document.getElementById('modal-reviews-empty');
            const loadingEl = document.getElementById('modal-reviews-loading');

            listEl.innerHTML    = '';
            emptyEl.classList.add('hidden');
            loadingEl.classList.remove('hidden');

            try {
                const res  = await fetch(`/api/restoran/${restoId}/reviews`);
                const data = await res.json();
                loadingEl.classList.add('hidden');

                if (!data.length) {
                    emptyEl.classList.remove('hidden');
                    return;
                }

                listEl.innerHTML = data.map(rv => {
                    const stars = Array.from({ length: 5 }, (_, i) =>
                        `<i class="fas fa-star text-[10px] ${i < rv.rating ? 'text-[#F5A623]' : 'text-black/15'}"></i>`
                    ).join('');

                    const initials = rv.user_name
                        .split(' ').slice(0, 2)
                        .map(w => w[0]).join('').toUpperCase();

                    return `
                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#F5A623] to-[#C07A2A]
                                        flex items-center justify-center flex-shrink-0
                                        text-white text-[13px] font-extrabold shadow-sm">
                                ${initials}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-[3px]">
                                    <p class="text-[13px] font-extrabold text-dark leading-none">${rv.user_name}</p>
                                    <span class="text-[11px] text-muted">${rv.created_at}</span>
                                </div>
                                <div class="flex gap-[2px] mb-1">${stars}</div>
                                <p class="text-[12px] text-muted leading-[1.6]">${rv.comment || ''}</p>
                            </div>
                        </div>`;
                }).join('');

            } catch (err) {
                console.error('fetchReviews error:', err);
                loadingEl.classList.add('hidden');
                listEl.innerHTML = '<p class="text-[12px] text-red-400 text-center py-3">Gagal memuat ulasan.</p>';
            }
        }

        function closeModal() {
            document.getElementById('resto-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }


        // LOADING
        function setLoading(show) {
            const overlay = document.getElementById('map-loading');
            const skeleton = document.getElementById('cards-loading');
            const cards = document.getElementById('resto-cards');

            overlay.style.opacity = show ? '1' : '0';
            overlay.style.pointerEvents = show ? 'all' : 'none';
            skeleton.style.display = show ? 'flex' : 'none';
            cards.style.opacity = show ? '0.3' : '1';
        }
