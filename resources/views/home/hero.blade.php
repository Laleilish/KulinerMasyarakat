<section class="bg-[#EF950F] rounded-3xl px-5 py-10 md:px-10 md:py-[30px] flex flex-col md:flex-row items-center justify-between min-h-[200px] relative overflow-hidden m-4">

    <div class="z-10 w-full">
        <img
            class="hidden md:block w-20 h-auto"
            style="margin: 0 13%"
            src="{{ asset('assets/img/Header/icon-kumar-white.png') }}"
            alt="Icon Kumar"
        >
        <h1 class="text-2xl md:text-5xl font-bold text-dark leading-tight">Bingung Mau Makan Apa?</h1>
        <h1 class="text-2xl md:text-5xl font-bold text-dark leading-tight">KU<span class="text-red-logo">MAR</span>-in Aja</h1>
        <p class="text-dark text-sm md:text-base leading-relaxed mt-2 mb-4">
            Temukan tempat makan hidden gem, yang pas dengan dompetmu.<br>
            Cepat, hemat, dan banyak pilihan!
        </p>
        <div class="bg-white rounded-xl w-full md:max-w-[50%] p-3">
            <label class="text-xs font-semibold text-dark block mb-2">Lokasi Kamu</label>
            <div class="flex flex-col md:flex-row gap-2 md:gap-4 md:justify-between md:items-center">
                <div class="flex items-center gap-2 border border-gray-300 rounded-xl flex-1 px-3 py-2">
                    <i class="fa-solid fa-location-dot text-secondary shrink-0"></i>
                    <input
                        type="text"
                        placeholder="Masukkan Lokasi..."
                        class="border-none outline-none flex-1 text-sm text-dark bg-transparent placeholder:text-muted-light"
                    >
                </div>
                <button class="bg-secondary hover:bg-secondary-dark text-white border-none rounded-full text-base font-semibold cursor-pointer w-full md:w-auto md:whitespace-nowrap px-4 py-2 transition-colors">
                    Cari Resto
                </button>
            </div>
        </div>
    </div>

    <div class="hidden md:flex flex-1 justify-end items-center">
        <img
            class="absolute rounded-full object-cover w-[20%] aspect-square top-[-20%] left-[-2%]"
            src="{{ asset('assets/img/Header/image1.png') }}"
            alt="food"
        >
        <img
            class="absolute rounded-full object-cover w-[20%] aspect-square top-[-10%] right-[16%]"
            src="{{ asset('assets/img/Header/image2.png') }}"
            alt="food"
        >
        <img
            class="absolute rounded-full object-cover w-[22%] aspect-square top-[10%] right-[-5%]"
            src="{{ asset('assets/img/Header/image3.png') }}"
            alt="food"
        >
        <img
            class="absolute rounded-full object-cover w-[25%] aspect-square bottom-[8%] right-[20%]"
            src="{{ asset('assets/img/Header/image4.png') }}"
            alt="food"
        >
        <img
            class="absolute rounded-full object-cover w-[20%] aspect-square bottom-[-13%] right-[-2%]"
            src="{{ asset('assets/img/Header/image6.png') }}"
            alt="food"
        >
    </div>

</section>
