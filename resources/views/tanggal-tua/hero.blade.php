<section class="px-5 mt-6 mb-10">

    <h1 class="text-center text-[18px] font-extrabold text-dark mb-4 tracking-tight">
        Duit Habis Diakhir Bulan?
    </h1>

    <div class="relative w-full max-w-lg mx-auto bg-[#F5A623] rounded-[24px] h-[190px] shadow-sm flex items-center mb-8">
        
        {{-- Left Image (Dummy placeholder for the guy with food) --}}
        <img
            src="{{ asset('storage/banner/tanggal-tua.png') }}"
            alt="Tanggal Tua"
            class="absolute left-[-10px] bottom-0 h-[110%] object-contain drop-shadow-md z-10"
            style="width: 50%; max-width: 180px;">

        {{-- Right Content --}}
        <div class="absolute right-0 w-[55%] h-full flex flex-col justify-center px-4 z-20 text-right text-white">
            <h2 class="font-extrabold text-[14px] leading-tight mb-1 text-dark">
                Fitur Tanggal Tua Hadir<br>Untuk Menyelamatkanmu!
            </h2>
            <p class="text-[10px] font-semibold text-white mb-2">
                Makan Enak Tanpa Biaya Lebih
            </p>
            <h3 class="text-[42px] font-black leading-none text-[#5A3805] tracking-tighter mb-1">
                <20k
            </h3>
            <p class="text-[9px] font-semibold text-white leading-tight">
                Harga Terendah,<br>Makan Termewah
            </p>
        </div>

        {{-- Overlapping Location Dropdown --}}
        <div class="absolute -bottom-5 left-1/2 -translate-x-1/2 w-[85%] bg-[#FDF5EB] rounded-full shadow-md border border-[#f0dfc8] px-4 py-3 flex items-center justify-between z-30 cursor-pointer hover:bg-white transition">
            <div class="flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-gray-500 text-[14px]"></i>
                <span class="text-[13px] font-semibold text-gray-600">Pilih Lokasi Anda</span>
            </div>
            <i class="fas fa-caret-down text-gray-500"></i>
        </div>

    </div>

</section>