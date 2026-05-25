<div class="rating-section">
    <div class="rating-title">Rating Tertinggi dari Pengguna Lain</div>

    {{-- TOP ROW - 2 horizontal cards --}}
    <div class="rating-grid-top">
        @foreach ($topRatings->take(2) as $resto)
        <div class="rating-card">
            <div class="rating-card-inner">
                <div class="rating-card-info">
                    <div class="rating-card-name">{{ $resto->name }}</div>
                    <div class="rating-tags">
                        @foreach (explode(',', $resto->tags) as $tag)
                            <span class="rtag">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    <div class="rating-stars">
                        @for ($i = 0; $i < round($resto->rating); $i++) ★ @endfor
                    </div>
                </div>
                <img src="{{ asset('assets/img/Restoran Favorit/' . $resto->image) }}" alt="{{ $resto->name }}">
            </div>
        </div>
        @endforeach
    </div>

    {{-- BOTTOM ROW - 3 vertical cards --}}
    <div class="rating-grid-bottom">
        @foreach ($topRatings->skip(2)->take(3) as $resto)
        <div class="rating-card-vert">
            <img src="{{ asset('assets/img/Restoran Favorit/' . $resto->image) }}" alt="{{ $resto->name }}">
            <div class="rcard-body">
                <div class="rcard-name">{{ $resto->name }}</div>
                <div class="rcard-tags">
                    @foreach (explode(',', $resto->tags) as $tag)
                        <span class="rtag">{{ trim($tag) }}</span>
                    @endforeach
                </div>
                <div class="rcard-stars">
                    @for ($i = 0; $i < round($resto->rating); $i++) ★ @endfor
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="lihat-semua-wrap">
        <a href="#">
            <button class="btn-lihat-semua">Lihat Semua</button>
        </a>
    </div>
</div>