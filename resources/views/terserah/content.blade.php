<section class="bg-cream-bg">

    {{-- DESKTOP / WEB --}}
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

                    <button type="button" data-category="jajanan"
                        class="desktop-category-card flex min-h-[170px] flex-col justify-center rounded-[18px] border-2 border-transparent bg-[#FDFDFD] px-10 py-8 shadow-card transition hover:-translate-y-1 hover:shadow-card-hover">
                        <div class="mx-auto flex h-[62px] w-[62px] items-center justify-center rounded-xl bg-[#F7D7A8]">
                            <img src="{{ asset('assets/img/terserah/dessert.png') }}" class="h-[48px] w-[48px] object-contain">
                        </div>
                        <h3 class="mt-4 text-center text-[13px] font-bold text-dark">Jajanan</h3>
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
                <h1 class="mb-2 text-[22px] font-extrabold text-dark">Hasil Pilihan KUMAR!</h1>
                <p class="mb-5 text-[13px] text-muted">Tunggu sebentar...</p>

                <div class="overflow-hidden rounded-[20px] border-4 border-[#EF950F] min-h-[300px] flex items-center justify-center">
                    <img id="desktopLoadingImage"
                        src=""
                        style="display: none;"
                        class="mx-auto h-[300px] w-full object-cover transition-all duration-300">
                </div>
            </div>
        </div>

        {{-- DESKTOP RESULT --}}
        <div id="desktopStepResult" class="hidden min-h-[520px] items-center justify-center py-10">
            <div class="w-full max-w-[500px] rounded-[28px] bg-white p-6 text-center shadow-card">
                <h1 class="mb-2 text-[28px] font-extrabold leading-tight text-dark">
                    Kumar Pilihkan Ini<br>Buat Kamu!
                </h1>
                <p class="mb-5 text-[13px] font-medium text-[#6F84A7]">Pilihan spesial hanya untukmu</p>

                <div class="overflow-hidden rounded-[20px]">
                    <img id="desktopFinalImage"
                        src="{{ asset('assets/img/terserah/makanan.png') }}"
                        class="mx-auto h-[300px] w-full object-cover">
                </div>

                <h2 id="desktopFinalName" class="mt-5 text-left text-[20px] font-extrabold text-dark">-</h2>

                <div class="mt-3 flex gap-2">
                    <span id="desktopFinalCategory"
                        class="rounded-full border border-[#EF950F] px-3 py-1 text-[12px] font-semibold text-[#EF950F]">
                        -
                    </span>
                </div>

                <button id="desktopUlangBtn" type="button"
                    class="mt-5 flex h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-[#EF950F] font-bold text-white">
                    ↻ Coba Lagi
                </button>

                <div class="mt-6 text-left">
                    <h3 class="text-[16px] font-extrabold text-dark">Restoran Terdekat</h3>
                    <div id="desktopRestaurantList" class="mt-3 flex flex-col gap-3">
                        {{-- Diisi via JS --}}
                    </div>
                </div>
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
                    class="category-card flex min-h-[80px] w-full items-center gap-4 rounded-[20px] border-2 border-transparent bg-white px-5 py-4 text-left shadow-[0_4px_14px_rgba(0,0,0,0.10)] transition">
                    <div class="flex h-[56px] w-[56px] shrink-0 items-center justify-center overflow-hidden rounded-[12px] bg-[#FFE3CF]">
                        <img src="{{ asset('assets/img/terserah/makanan.png') }}" alt="Makanan Berat" class="h-[44px] w-[44px] object-contain">
                    </div>

                    <div class="flex-1">
                        <h3 class="text-[17px] font-extrabold leading-tight text-dark">Makanan Berat</h3>
                        <p class="mt-1 text-[13px] leading-snug text-[#4D4D4D]">
                            Nasi, Mie, Karedok, Pasta, dll
                        </p>
                    </div>
                </button>

                <button type="button" data-category="minuman"
                    class="category-card flex min-h-[80px] w-full items-center gap-4 rounded-[20px] border-2 border-transparent bg-white px-5 py-4 text-left shadow-[0_4px_14px_rgba(0,0,0,0.10)] transition">
                    <div class="flex h-[56px] w-[56px] shrink-0 items-center justify-center overflow-hidden rounded-[12px] bg-[#FFE3CF]">
                        <img src="{{ asset('assets/img/terserah/minuman.png') }}" alt="Minuman" class="h-[44px] w-[44px] object-contain">
                    </div>

                    <div class="flex-1">
                        <h3 class="text-[17px] font-extrabold leading-tight text-dark">Minuman</h3>
                        <p class="mt-1 text-[13px] leading-snug text-[#4D4D4D]">
                            Jus, Es Teler, Cendol, Kopi, dll
                        </p>
                    </div>
                </button>

                <button type="button" data-category="jajanan"
                    class="category-card flex min-h-[80px] w-full items-center gap-4 rounded-[20px] border-2 border-transparent bg-white px-5 py-4 text-left shadow-[0_4px_14px_rgba(0,0,0,0.10)] transition">
                    <div class="flex h-[56px] w-[56px] shrink-0 items-center justify-center overflow-hidden rounded-[12px] bg-[#FFE3CF]">
                        <img src="{{ asset('assets/img/terserah/dessert.png') }}" alt="Jajanan" class="h-[44px] w-[44px] object-contain">
                    </div>

                    <div class="flex-1">
                        <h3 class="text-[17px] font-extrabold leading-tight text-dark">
                            Jajanan
                        </h3>
                        <p class="mt-1 text-[13px] leading-snug text-[#4D4D4D]">
                            Kue, Es Krim, Martabak, dll
                        </p>
                    </div>
                </button>

            </div>

            <button type="button"
                class="acak-btn flex h-[50px] w-full max-w-[360px] items-center justify-center gap-3 rounded-xl bg-[#F7D7A8] text-[18px] font-extrabold text-[#5F78A3] shadow-[0_4px_8px_rgba(0,0,0,0.16)] transition">
                🎲 <span>Acak Sekarang</span>
            </button>
        </div>


        {{-- STEP 2: ANIMASI ACAK (LOADING / CYCLING) --}}
        <div id="stepLoading" class="hidden min-h-[calc(100vh-120px)] flex-col items-center justify-center py-14">
            <h1 class="mb-2 text-center text-[24px] font-extrabold text-dark">
                Hasil Pilihan KUMAR!
            </h1>
            <p class="mb-8 text-center text-[13px] text-[#6F84A7]">Tunggu sebentar...</p>

            <div class="w-full max-w-[320px] rounded-[28px] bg-white p-4 text-center shadow-[0_8px_18px_rgba(0,0,0,0.14)]">
                <div class="overflow-hidden rounded-[22px] border-4 border-[#EF950F] min-h-[240px] flex items-center justify-center">
                    <img id="loadingImage"
                        src=""
                        style="display: none;"
                        alt="Loading Random"
                        class="h-[240px] w-full object-cover transition-all duration-200">
                </div>
            </div>
        </div>


        {{-- STEP 3: HASIL --}}
        <div id="stepResult" class="hidden min-h-[calc(100vh-120px)] flex-col items-center justify-start px-2 py-8">

            <div class="w-full max-w-[330px] text-center">
                <h1 class="text-[24px] font-extrabold leading-tight text-dark">
                    Kumar Pilihkan ini<br>
                    Buat Kamu!
                </h1>

                <p class="mt-2 text-[13px] font-medium text-[#6F84A7]">
                    Pilihan spesial hanya untukmu
                </p>
            </div>

            <div class="mt-5 w-full max-w-[310px] rounded-[18px] bg-white p-4 shadow-[0_4px_10px_rgba(0,0,0,0.18)]">
                <div class="overflow-hidden rounded-[16px]">
                    <img id="finalImage"
                        src="{{ asset('assets/img/terserah/makanan.png') }}"
                        alt="Hasil Pilihan"
                        class="h-[200px] w-full object-cover">
                </div>

                <h2 id="finalName" class="mt-4 text-left text-[16px] font-extrabold text-dark">
                    -
                </h2>

                <div class="mt-3 flex flex-wrap gap-2">
                    <span id="finalCategory"
                        class="rounded-full border border-[#EF950F] px-3 py-1 text-[11px] font-semibold capitalize text-[#EF950F]">
                        -
                    </span>
                </div>
            </div>

            <button id="ulangBtn" type="button"
                class="mt-5 flex h-[42px] w-full max-w-[310px] items-center justify-center gap-3 rounded-xl bg-[#EF950F] text-[15px] font-extrabold text-white shadow-[0_4px_8px_rgba(0,0,0,0.16)]">
                ↻ <span>Coba Lagi</span>
            </button>

            <div class="mt-6 w-full max-w-[310px]">
                <h3 class="text-left text-[15px] font-extrabold text-dark">
                    Restoran Terdekat
                </h3>

                <div id="restaurantList" class="mt-3 flex flex-col gap-3">
                    {{-- Diisi via JS --}}
                </div>
            </div>

        </div>

    </div>
</section>

