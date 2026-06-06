<section class="bg-cream-bg">

    {{-- DESKTOP / WEB --}}{{-- DESKTOP / WEB --}}
    <div class="hidden md:block px-10">
        <div id="desktopStepChoose" class="mx-auto flex min-h-[520px] max-w-[1512px] items-center justify-center py-10">
            <div class="w-full max-w-[1180px] rounded-[20px] bg-[#F8E8D0] px-16 py-12 shadow-card">

                <div class="mb-8 text-center">
                    <h1 class="text-[34px] font-bold leading-tight text-dark">
                        Mau Makan Apa Hari Ini?
                    </h1>

                    <p class="mx-auto mt-5 max-w-[360px] text-center text-[15px] leading-tight text-muted">
                        Pilih yang kamu mau, biar KUMAR yang tentuin makanannya.
                    </p>
                </div>

                <div class="mx-auto grid w-full max-w-[980px] grid-cols-3 gap-6">
                    <button type="button" data-category="makanan"
                        class="desktop-category-card flex min-h-[170px] flex-col justify-center rounded-[18px] border-2 border-transparent bg-[#FDFDFD] px-10 py-8 shadow-card transition hover:-translate-y-1 hover:shadow-card-hover">
                        <div class="mx-auto flex h-[62px] w-[62px] items-center justify-center rounded-xl bg-[#F7D7A8]">
                            <img src="{{ asset('assets/img/terserah/makanan.png') }}" class="h-[48px] w-[48px] object-contain">
                        </div>
                        <h3 class="mt-4 text-center text-[13px] font-bold text-dark">Makanan Berat</h3>
                        <p class="mt-1 text-center text-[9px] text-muted">Nasi, Mie, Karedok, Pasta, dll</p>
                    </button>

                    <button type="button" data-category="minuman"
                        class="desktop-category-card flex min-h-[170px] flex-col justify-center rounded-[18px] border-2 border-transparent bg-[#FDFDFD] px-10 py-8 shadow-card transition hover:-translate-y-1 hover:shadow-card-hover">
                        <div class="mx-auto flex h-[62px] w-[62px] items-center justify-center rounded-xl bg-[#F7D7A8]">
                            <img src="{{ asset('assets/img/terserah/minuman.png') }}" class="h-[48px] w-[48px] object-contain">
                        </div>
                        <h3 class="mt-4 text-center text-[13px] font-bold text-dark">Minuman</h3>
                        <p class="mt-1 text-center text-[9px] text-muted">Jus, Es Teler, Cendol, Kopi, dll</p>
                    </button>

                    <button type="button" data-category="dessert"
                        class="desktop-category-card flex min-h-[170px] flex-col justify-center rounded-[18px] border-2 border-transparent bg-[#FDFDFD] px-10 py-8 shadow-card transition hover:-translate-y-1 hover:shadow-card-hover">
                        <div class="mx-auto flex h-[62px] w-[62px] items-center justify-center rounded-xl bg-[#F7D7A8]">
                            <img src="{{ asset('assets/img/terserah/dessert.png') }}" class="h-[48px] w-[48px] object-contain">
                        </div>
                        <h3 class="mt-4 text-center text-[13px] font-bold text-dark">Camilan & Dessert</h3>
                        <p class="mt-1 text-center text-[9px] text-muted">Kue, Es Krim, Martabak, dll</p>
                    </button>
                </div>

                <div class="mt-8 flex justify-center">
                    <button type="button"
                        class="desktop-acak-btn flex h-[42px] w-full max-w-[370px] items-center justify-center gap-2 rounded-lg bg-[#F5D7A8] text-[15px] font-bold text-muted transition hover:bg-[#EF950F] hover:text-white">
                        🎲 <span>Acak Sekarang</span>
                    </button>
                </div>

            </div>
        </div>

        {{-- DESKTOP LOADING --}}
        <div id="desktopStepLoading" class="hidden min-h-[520px] items-center justify-center py-10">
            <div class="w-full max-w-[500px] rounded-[28px] bg-white p-6 text-center shadow-card">
                <h1 class="mb-6 text-[30px] font-extrabold text-dark">Lagi diacak...</h1>

                <img id="desktopLoadingImage"
                    src="{{ asset('assets/img/terserah/makanan.png') }}"
                    class="mx-auto h-[300px] w-full rounded-[20px] object-cover">

                <p id="desktopLoadingName" class="mt-5 text-[24px] font-extrabold text-dark">
                    KUMAR lagi mikir...
                </p>
            </div>
        </div>

        {{-- DESKTOP RESULT --}}
        <div id="desktopStepResult" class="hidden min-h-[520px] items-center justify-center py-10">
            <div class="w-full max-w-[500px] rounded-[28px] bg-white p-6 text-center shadow-card">
                <h1 class="mb-6 text-[30px] font-extrabold text-dark">
                    Kumar Pilihkan Ini Buat Kamu!
                </h1>

                <img id="desktopFinalImage"
                    src="{{ asset('assets/img/terserah/makanan.png') }}"
                    class="mx-auto h-[300px] w-full rounded-[20px] object-cover">

                <h2 id="desktopFinalName" class="mt-5 text-[24px] font-extrabold text-dark">-</h2>

                <span id="desktopFinalCategory"
                    class="mt-4 inline-block rounded-full border border-[#EF950F] px-4 py-2 text-[13px] font-semibold text-[#EF950F]">
                    -
                </span>

                <div class="mt-6 rounded-xl bg-[#F8E8D0] p-4 text-left">
                    <h3 class="text-[18px] font-extrabold text-dark">Restoran Rekomendasi</h3>
                    <p id="desktopRestaurantName" class="mt-2 font-bold text-dark">-</p>
                    <p id="desktopRestaurantAddress" class="text-sm text-muted">-</p>
                </div>

                <button id="desktopUlangBtn" type="button"
                    class="mt-6 h-[44px] w-full rounded-xl bg-[#EF950F] font-bold text-white">
                    ↻ Coba Lagi
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE / HP --}}
    <div class="block md:hidden px-4">

        {{-- STEP 1: PILIH KATEGORI --}}
        <div id="stepChoose" class="flex min-h-[calc(100vh-120px)] flex-col items-center justify-start gap-7 py-14">

            <div class="text-center">
                <h1 class="text-[24px] font-extrabold leading-tight text-dark">
                    Bingung Mau Makan APA?
                </h1>

                <p class="mx-auto mt-5 max-w-[270px] text-center text-[14px] leading-snug text-[#6F84A7]">
                    Pilih yang kamu mau, biar KUMAR yang tentuin makanannya.
                </p>
            </div>

            <div class="flex w-full max-w-[360px] flex-col gap-4">

                <button type="button" data-category="makanan"
                    class="category-card flex min-h-[148px] w-full items-center gap-4 rounded-[28px] border-2 border-transparent bg-white px-5 py-5 text-left shadow-[0_8px_18px_rgba(0,0,0,0.14)] transition">
                    <div class="flex h-[100px] w-[100px] shrink-0 items-center justify-center overflow-hidden rounded-[16px] bg-[#FFE3CF]">
                        <img src="{{ asset('assets/img/terserah/makanan.png') }}" alt="Makanan Berat" class="h-full w-full object-cover">
                    </div>

                    <div class="flex-1">
                        <h3 class="text-[20px] font-extrabold leading-tight text-dark">Makanan Berat</h3>
                        <p class="mt-2 text-[15px] leading-snug text-[#4D4D4D]">
                            Nasi, Mie, Karedok,<br>Pasta, dll
                        </p>
                    </div>
                </button>

                <button type="button" data-category="minuman"
                    class="category-card flex min-h-[148px] w-full items-center gap-4 rounded-[28px] border-2 border-transparent bg-white px-5 py-5 text-left shadow-[0_8px_18px_rgba(0,0,0,0.14)] transition">
                    <div class="flex h-[100px] w-[100px] shrink-0 items-center justify-center overflow-hidden rounded-[16px] bg-[#FFE3CF]">
                        <img src="{{ asset('assets/img/terserah/minuman.png') }}" alt="Minuman" class="h-full w-full object-cover">
                    </div>

                    <div class="flex-1">
                        <h3 class="text-[20px] font-extrabold leading-tight text-dark">Minuman</h3>
                        <p class="mt-2 text-[15px] leading-snug text-[#4D4D4D]">
                            Jus, Es Teler, Cendol,<br>Kopi, dll
                        </p>
                    </div>
                </button>

                <button type="button" data-category="dessert"
                    class="category-card flex min-h-[148px] w-full items-center gap-4 rounded-[28px] border-2 border-transparent bg-white px-5 py-5 text-left shadow-[0_8px_18px_rgba(0,0,0,0.14)] transition">
                    <div class="flex h-[100px] w-[100px] shrink-0 items-center justify-center overflow-hidden rounded-[16px] bg-[#FFE3CF]">
                        <img src="{{ asset('assets/img/terserah/dessert.png') }}" alt="Camilan & Dessert" class="h-full w-full object-cover">
                    </div>

                    <div class="flex-1">
                        <h3 class="text-[20px] font-extrabold leading-tight text-dark">
                            Camilan &<br>Dessert
                        </h3>
                        <p class="mt-2 text-[15px] leading-snug text-[#4D4D4D]">
                            Kue, Es Krim,<br>Martabak, dll
                        </p>
                    </div>
                </button>

            </div>

            <button type="button"
                class="acak-btn flex h-[50px] w-full max-w-[360px] items-center justify-center gap-3 rounded-xl bg-[#F7D7A8] text-[18px] font-extrabold text-[#5F78A3] shadow-[0_4px_8px_rgba(0,0,0,0.16)]">
                🎲 <span>Acak Sekarang</span>
            </button>
        </div>


        {{-- STEP 2: ANIMASI ACAK --}}
        <div id="stepLoading" class="hidden min-h-[calc(100vh-120px)] flex-col items-center justify-center py-14">
            <h1 class="mb-8 text-center text-[26px] font-extrabold text-dark">
                Lagi diacak...
            </h1>

            <div class="w-full max-w-[340px] rounded-[28px] bg-white p-5 text-center shadow-[0_8px_18px_rgba(0,0,0,0.14)]">
                <div class="overflow-hidden rounded-[22px] border-2 border-[#EF950F]">
                    <img id="loadingImage"
                        src="{{ asset('assets/img/terserah/makanan.png') }}"
                        alt="Loading Random"
                        class="h-[260px] w-full object-cover transition-all duration-200">
                </div>

                <p id="loadingName" class="mt-5 text-[22px] font-extrabold text-dark">
                    KUMAR lagi mikir...
                </p>
            </div>
        </div>


        {{-- STEP 3: HASIL --}}
        <div id="stepResult" class="hidden min-h-[calc(100vh-120px)] flex-col items-center justify-start px-2 py-8">

            <div class="w-full max-w-[330px] text-center">
                <h1 class="text-[27px] font-extrabold leading-tight text-dark">
                    Kumar Pilihkan ini<br>
                    Buat Kamu!
                </h1>

                <p class="mt-5 text-[14px] font-medium text-[#6F84A7]">
                    Pilihan spesial hanya untukmu
                </p>
            </div>

            <div class="mt-5 w-full max-w-[310px] rounded-[18px] bg-white p-4 shadow-[0_4px_10px_rgba(0,0,0,0.18)]">
                <div class="overflow-hidden rounded-[16px]">
                    <img id="finalImage"
                        src="{{ asset('assets/img/terserah/makanan.png') }}"
                        alt="Hasil Pilihan"
                        class="h-[215px] w-full object-cover">
                </div>

                <h2 id="finalName" class="mt-5 text-left text-[16px] font-extrabold text-dark">
                    -
                </h2>

                <p id="finalPrice" class="mt-1 text-left text-[13px] font-semibold text-[#6F84A7]">
                    -
                </p>

                <div class="mt-4 flex gap-2">
                    <span id="finalCategory"
                        class="rounded-full border border-[#EF950F] px-3 py-2 text-[11px] font-semibold capitalize text-[#EF950F]">
                        -
                    </span>

                    <span class="rounded-full border border-[#EF950F] px-3 py-2 text-[11px] font-semibold text-[#EF950F]">
                        Rekomendasi
                    </span>
                </div>
            </div>

            <button id="ulangBtn" type="button"
                class="mt-5 flex h-[42px] w-full max-w-[310px] items-center justify-center gap-3 rounded-xl bg-[#EF950F] text-[15px] font-extrabold text-white shadow-[0_4px_8px_rgba(0,0,0,0.16)]">
                ↻ <span>Coba Lagi</span>
            </button>

            <div class="mt-6 w-full max-w-[310px]">
                <h3 class="text-left text-[16px] font-extrabold text-dark">
                    Restoran Rekomendasi
                </h3>

                <div class="mt-4 flex items-center gap-4 rounded-xl bg-white p-3 shadow-[0_3px_8px_rgba(0,0,0,0.14)]">
                    <img id="restaurantImage1"
                        src="{{ asset('assets/img/terserah/makanan.png') }}"
                        alt="Restoran"
                        class="h-[58px] w-[58px] rounded-lg object-cover">

                    <div class="text-left">
                        <h4 id="restaurantName1" class="text-[16px] font-extrabold text-dark">
                            -
                        </h4>
                        <p id="restaurantAddress1" class="text-[14px] text-[#8A9AB5]">
                            -
                        </p>
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-4 rounded-xl bg-white p-3 shadow-[0_3px_8px_rgba(0,0,0,0.14)]">
                    <img id="restaurantImage2"
                        src="{{ asset('assets/img/terserah/makanan.png') }}"
                        alt="Restoran"
                        class="h-[58px] w-[58px] rounded-lg object-cover">

                    <div class="text-left">
                        <h4 id="restaurantName2" class="text-[16px] font-extrabold text-dark">
                            -
                        </h4>
                        <p id="restaurantAddress2" class="text-[14px] text-[#8A9AB5]">
                            -
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

