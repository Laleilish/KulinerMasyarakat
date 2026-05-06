<section class="bg-[#EF950F] rounded-[25px] px-5 py-10 md:px-10 md:py-[30px] flex flex-col md:flex-row items-center justify-between min-h-[200px] relative overflow-hidden m-4">

    <div class="z-10 w-full">
        <img
            class="hidden md:block w-20 h-auto"
            style="margin: 0 13%"
            src="{{ asset('assets/img/Header/icon-kumar-white.png') }}"
            alt="Icon Kumar"
        >
        <h1 class="text-[24px] md:text-[48px] font-bold text-[#040818] leading-[1.3]">Bingung Mau Makan Apa?</h1>
        <h1 class="text-[24px] md:text-[48px] font-bold text-[#040818] leading-[1.3]">KU<span class="text-[#960913]">MAR</span>-in Aja</h1>
        <p class="text-[#040818] text-[13px] md:text-[15px] leading-[1.5] mt-2 mb-4">
            Temukan tempat makan hidden gem, yang pas dengan dompetmu.<br>
            Cepat, hemat, dan banyak pilihan!
        </p>
        <div class="bg-white rounded-2xl w-full md:max-w-[50%] p-3">
            <label class="text-xs font-semibold text-[#040818] block mb-2">Lokasi Kamu</label>
            <div class="flex flex-col md:flex-row gap-2 md:gap-4 md:justify-between md:items-center">
                <div class="flex items-center gap-2 border border-[#ddd] rounded-2xl flex-1 px-[10px] py-[7px]">
                    <i class="fa-solid fa-location-dot text-[#02B176] shrink-0"></i>
                    <input
                        type="text"
                        placeholder="Masukkan Lokasi..."
                        class="border-none outline-none flex-1 text-[13px] text-[#040818] bg-transparent placeholder:text-[#aaa]"
                    >
                </div>
                <button class="bg-[#02B176] hover:bg-[#029962] text-white border-none rounded-full text-base font-semibold cursor-pointer w-full md:w-auto md:whitespace-nowrap px-4 py-2">
                    Cari Resto
                </button>
            </div>
        </div>
    </div>

    <div class="hidden md:flex flex-1 justify-end items-center">
        <img
            class="absolute rounded-full object-cover w-[20%] aspect-square top-[-20%] left-[-2%]"
            src="{{ asset('assets/img/Header/foto1.png') }}"
            alt="food"
        >
        <img
            class="absolute rounded-full object-cover w-[20%] aspect-square top-[-10%] right-[16%]"
            src="{{ asset('assets/img/Header/foto2.png') }}"
            alt="food"
        >
        <img
            class="absolute rounded-full object-cover w-[22%] aspect-square top-[10%] right-[-5%]"
            src="{{ asset('assets/img/Header/foto3.png') }}"
            alt="food"
        >
        <img
            class="absolute rounded-full object-cover w-[25%] aspect-square bottom-[8%] right-[20%]"
            src="{{ asset('assets/img/Header/foto4.png') }}"
            alt="food"
        >
        <img
            class="absolute rounded-full object-cover w-[20%] aspect-square bottom-[-13%] right-[-2%]"
            src="{{ asset('assets/img/Header/foto5.png') }}"
            alt="food"
        >
    </div>

</section>
