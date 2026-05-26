<section class="pt-5 pb-2" id="kampus-section">
    <h1 class="text-center text-[19px] md:text-[23px] font-extrabold text-dark
               leading-[1.3] px-6 mb-5">
        Pilih Kampus Yang Kamu Inginkan
    </h1>

    <div id="kampus-grid" class="grid
            grid-cols-3
            md:grid-cols-5
            lg:grid-cols-5
            gap-x-3 md:gap-x-5
            gap-y-4 md:gap-y-6
            px-5 md:px-8 lg:px-10
            max-w-[640px] md:max-w-[950px] lg:max-w-[980px]
            mx-auto w-full">
        @foreach ($campuses as $campus)
            <div class="kampus-item flex flex-col items-center gap-2 cursor-pointer group" data-id="{{ $campus->id }}"
                data-lat="{{ $campus->latitude }}" data-lng="{{ $campus->longitude }}" data-zoom="{{ $campus->map_zoom }}"
                data-name="{{ $campus->name }}">

                <div class="kampus-icon-wrap w-[70px] h-[70px] md:w-[90px] md:h-[90px] lg:w-[105px] lg:h-[105px]
                                    rounded-[20px] bg-[#F5A623]
                                    flex items-center justify-center overflow-hidden
                                    shadow-[0_4px_12px_rgba(245,166,35,0.3)]
                                    transition-all duration-300 ease-out
                                    group-hover:scale-105 group-hover:shadow-[0_6px_20px_rgba(245,166,35,0.45)]
                                    opacity-60">
                    <img src="{{ asset('assets/img/kampus/' . $campus->logo) }}" alt="{{ $campus->name }}" class="w-[46px] h-[46px] 
                                        md:w-[58px] md:h-[58px] lg:w-[68px] lg:h-[68px] object-contain
                                        transition-transform duration-300 group-hover:scale-105">
                </div>

                <span
                    class="kampus-label text-center text-[10px] md:text-[12px] lg:text-[13px] leading-[1.5] tracking-[0.2px] px-1">
                    {{ $campus->name }}
                </span>
            </div>
        @endforeach
    </div>

    <p class="text-center
          text-[12px] md:text-[16px] lg:text-[17px]
          font-medium text-muted
          leading-[1.7] md:leading-[1.9]
          tracking-normal md:tracking-[0.2px]
          px-8 md:px-10
          pt-5 pb-2
          max-w-[440px] md:max-w-[620px]
          mx-auto">
    Bingung Mau Makan Setelah Jadwal Kelas? Ayo, cari Makanan
    <br class="hidden md:block">
    ke Pelosok Daerah Sekitar Kampusmu!
</p>
</section>