<section class="pt-5 pb-2">
    <h1 class="text-center text-[19px] md:text-[23px] font-extrabold text-dark
               leading-[1.3] px-6 mb-5">
        Pilih Kampus Yang Kamu Inginkan
    </h1>

    <div class="grid grid-cols-3 md:grid-cols-5 gap-x-3 gap-y-4
                px-5 md:px-8 max-w-[640px] mx-auto">
        @foreach ($campuses as $campus)
        <div class="kampus-item flex flex-col items-center gap-2 cursor-pointer group"
             data-id="{{ $campus->id }}"
             onclick="selectCampus({{ $campus->id }})">

            <div class="kampus-icon-wrap
                        w-[70px] h-[70px] md:w-[78px] md:h-[78px]
                        rounded-[20px] bg-[#F5A623]
                        flex items-center justify-center overflow-hidden
                        shadow-[0_4px_12px_rgba(245,166,35,0.3)]
                        transition-all duration-300 ease-out
                        group-hover:scale-105 group-hover:shadow-[0_6px_20px_rgba(245,166,35,0.45)]
                        {{ $campus->id === $selectedCampus->id
                            ? 'ring-4 ring-[#F5A623] ring-offset-2 scale-110'
                            : 'opacity-60' }}">
                <img src="{{ asset('assets/img/' . $campus->logo) }}"
                     alt="{{ $campus->name }}"
                     class="w-[46px] h-[46px] object-contain
                            transition-transform duration-300 group-hover:scale-105">
            </div>

            <span class="kampus-label text-center text-[10px] leading-[1.35] transition-all duration-200
                         {{ $campus->id === $selectedCampus->id
                             ? 'text-[#6B4423] font-extrabold'
                             : 'text-muted font-medium' }}">
                {{ $campus->name }}
            </span>
        </div>
        @endforeach
    </div>

    <p class="text-center text-[12px] font-medium text-muted leading-[1.7]
              px-8 pt-5 pb-2 max-w-[440px] mx-auto">
        Bingung Mau Makan Setelah Jadwal Kelas? Ayo, cari Makanan
        Hingga ke Pelosok Daerah Sekitar Kampusmu!
    </p>
</section>