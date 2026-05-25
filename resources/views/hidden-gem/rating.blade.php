<section class="px-5 pb-8">

    <h2 class="text-[20px] font-extrabold text-center text-dark mb-5"> Hidden Gem Hari ini</h2>

    <div class="grid grid-cols-2 gap-3 mb-3">
        @foreach ($topRatings as $item)

            <div class=" bg-white rounded-2xl border border-black/5 shadow-card overflow-hidden hover:shadow-card-hover transition">
                <div class="flex">
                    <div class="flex-1 p-3">
                        <h3 class=" text-[11px] font-extrabold text-dark leading-[1.4] mb-2">{{ $item['nama'] }}</h3>
                        <div class="flex gap-1 flex-wrap mb-2">

                            @foreach ($item['tags'] as $tag)

                                <span class=" bg-cream-dark text-secondary text-[9px] font-bold px-2 py-[2px] rounded-full">{{ $tag }}</span>

                            @endforeach
                        </div>

                        <div class="text-yellow-400 text-xs tracking-wider">★★★★★</div>
                    </div>

                    <img src="{{ asset($item['image']) }}" class="w-[100px] h-[100px] object-cover">

                </div>

            </div>

        @endforeach

    </div>

    <div class="text-center pt-3">
        <button class=" bg-secondary hover:bg-secondary-dark text-white font-extrabold text-[15px] px-12 py-3 rounded-full shadow-lg active:scale-95 transition">Lihat Semua</button>
    </div>

</section>