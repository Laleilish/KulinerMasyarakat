<footer class="bg-[#EF950F] px-4 md:px-10 py-6 md:py-10 rounded-t-[25px] w-full">

    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-6">

        {{-- Kiri --}}
        <div class="flex flex-col gap-2 max-w-md">

            <div class="flex items-center gap-2 font-bold text-dark text-lg">
                <img src="{{ asset('assets/img/icon-kumar-white.png') }}" alt="KUMAR" class="h-10">
            </div>

            <h2 class="text-lg md:text-xl font-bold text-dark leading-tight" data-i18n="Seperti memiliki dapur tersembunyi di setiap sudut kota">
                Seperti memiliki dapur tersembunyi di setiap sudut kota
            </h2>

            <p class="text-sm md:text-base text-dark" data-i18n="Temukan kuliner hidden gem dengan rasa autentik dan pengalaman baru di sekitarmu.">
                Temukan kuliner hidden gem dengan rasa autentik dan pengalaman baru di sekitarmu.
            </p>

        </div>

        {{-- Tengah --}}
        <div class="flex flex-wrap md:flex-col gap-4 md:gap-3">

            <a href="{{ route('privacy') }}" 
                target="_blank"
                class="flex items-center gap-2 font-semibold text-dark hover:opacity-80">
                <span data-i18n="Privasi & Keamanan">Privasi & Keamanan</span>
            </a>

            <a href="{{ route('terms') }}" 
                target="_blank"
                class="flex items-center gap-2 font-semibold text-dark hover:opacity-80">
                <span data-i18n="Syarat & Ketentuan">Syarat & Ketentuan</span>
            </a>

            <div class="flex items-center gap-3 font-semibold text-dark">
                <span data-i18n="Ikuti Kami">Ikuti Kami</span>
                <i class="fa-brands fa-instagram text-xl"></i>
                <i class="fa-brands fa-facebook text-xl"></i>
                <i class="fa-brands fa-whatsapp text-xl"></i>
            </div>

        </div>

        {{-- Kanan --}}
        <p class="text-xs md:text-sm text-dark max-w-xs leading-relaxed">
            &copy; 2026 KUMAR <br>
            <span data-i18n="Kuliner Masyarakat aplikasi karya anak bangsa. Dirancang untuk membantu menemukan kuliner tersembunyi terbaik.">Kuliner Masyarakat aplikasi karya anak bangsa. Dirancang untuk membantu menemukan kuliner tersembunyi terbaik.</span>
        </p>

    </div>

</footer>
