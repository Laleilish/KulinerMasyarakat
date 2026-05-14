<section class="bg-cream-bg text-center px-5 pt-4 pb-6 md:px-10 md:py-[30px]">

    <h2 class="text-2xl md:text-3xl font-bold text-dark mb-6">Restoran Terfavorit</h2>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-left">

        <div class="flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover"
             onclick="window.location.href='{{ url('/pages/riview-resto') }}'">
            <img src="{{ asset('assets/img/Restoran Favorit/Nasi Goreng Kambing.png') }}" alt="Haji Salim"
                 class="w-full h-[130px] md:h-[230px] object-cover">
            <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                <h3 class="text-base font-bold text-dark leading-snug mb-1">Haji Salim Kebon Sirih 1959, Kebon Sirih Barat</h3>
                <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">Makanan Berat, Nasi, Goreng</p>
                <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> 1.2km</span>
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover">
            <img src="{{ asset('assets/img/Restoran Favorit/Mie Gojo.png') }}" alt="Mie Gojo"
                 class="w-full h-[130px] md:h-[230px] object-cover">
            <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                <h3 class="text-base font-bold text-dark leading-snug mb-1">Mie Gojo Kambing Kebon Sirih, Kebon Sirih Barat</h3>
                <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">Makanan Berat, Nasi, Goreng</p>
                <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> 1.2km</span>
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover">
            <img src="{{ asset('assets/img/Restoran Favorit/Bakmie Ayam.png') }}" alt="Bakmi Ayam Kecap"
                 class="w-full h-[130px] md:h-[230px] object-cover">
            <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                <h3 class="text-base font-bold text-dark leading-snug mb-1">Bakmi Ayam Kecap Pak Samsudin, Cikarang Selatan</h3>
                <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">Makanan Berat, Bakmi Ayam</p>
                <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> 1.8km</span>
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover">
            <img src="{{ asset('assets/img/Restoran Favorit/Mie Aceh.png') }}" alt="Mie Aceh Nandin"
                 class="w-full h-[130px] md:h-[230px] object-cover">
            <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                <h3 class="text-base font-bold text-dark leading-snug mb-1">Mie Aceh Nandin Selamet, Seitabudi Jakarta</h3>
                <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">Makanan Berat, Mie, Ayam, Kikil</p>
                <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> 3.1km</span>
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover">
            <img src="{{ asset('assets/img/Restoran Favorit/Mie Ayam Pangsit.png') }}" alt="Mie Ayam Pangsit"
                 class="w-full h-[130px] md:h-[230px] object-cover">
            <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                <h3 class="text-base font-bold text-dark leading-snug mb-1">Mie Ayam Pangait Serang 1969, Serang Barat</h3>
                <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">Makanan Berat, Mie Ayam</p>
                <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> 2.4km</span>
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover">
            <img src="{{ asset('assets/img/Restoran Favorit/Sate Padang.png') }}" alt="Sate Padang SM"
                 class="w-full h-[130px] md:h-[230px] object-cover">
            <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                <h3 class="text-base font-bold text-dark leading-snug mb-1">Sate Padang SM Kuliner Menteng, Sidoarjo</h3>
                <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">Makanan Cepat Saji, Sate, Ayam, Sapi</p>
                <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> 1.5km</span>
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover">
            <img src="{{ asset('assets/img/Restoran Favorit/Nasi Goreng Gila.png') }}" alt="Nasi Goreng Gila 82"
                 class="w-full h-[130px] md:h-[230px] object-cover">
            <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                <h3 class="text-base font-bold text-dark leading-snug mb-1">Nasi Goreng Gila 82 Menteng, Menteng</h3>
                <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">Makanan Berat, Nasi, Goreng</p>
                <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> 1.3km</span>
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover">
            <img src="{{ asset('assets/img/Restoran Favorit/Ayam Bakar.png') }}" alt="Ayam Bakar Selera Nusantara"
                 class="w-full h-[130px] md:h-[230px] object-cover">
            <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                <h3 class="text-base font-bold text-dark leading-snug mb-1">Ayam Bakar dan Ikan Bakar Selera Nusantara, Jakarta</h3>
                <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">Makanan Berat, Nasi, Goreng</p>
                <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1"><i class="fa-solid fa-location-dot"></i> 1.2km</span>
            </div>
        </div>

    </div>

    <div class="mt-6">
