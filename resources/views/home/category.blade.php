<section class="text-center px-5 pt-6 pb-4 md:px-10 md:py-[30px]">

    <h2 class="text-[22px] md:text-[28px] font-bold text-[#040818] mb-6">Mencari Hal Menarik?</h2>

    {{-- Mobile: baris 1 (3 item) --}}
    <div class="flex justify-center gap-4 mb-4 md:hidden">

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/tanggal_tua') }}'">
            <div class="w-[70px] h-[70px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[28px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Tanggal Tua.png') }}" alt="Tanggal Tua"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Tanggal Tua</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/terserah') }}'">
            <div class="w-[70px] h-[70px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[28px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Random Picker.png') }}" alt="Random Picker"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Terserah</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/split_bill') }}'">
            <div class="w-[70px] h-[70px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[28px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Split Bill.png') }}" alt="Split Bill"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Split Bill</span>
        </div>

    </div>

    {{-- Mobile: baris 2 (2 item, center) --}}
    <div class="flex justify-center gap-4 md:hidden">

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/submit-tempat') }}'">
            <div class="w-[70px] h-[70px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[28px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Komunitas.png') }}" alt="Komunitas"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Usulkan Tempat</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/hidden_gem') }}'">
            <div class="w-[70px] h-[70px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[28px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Hidden Gem.png') }}" alt="Hidden Gem"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Hidden Gem</span>
        </div>

    </div>

    {{-- Desktop: semua 5 item sejajar --}}
    <div class="hidden md:flex justify-center items-center gap-6">

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/tanggal_tua') }}'">
            <div class="w-[90px] h-[90px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[36px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Tanggal Tua.png') }}" alt="Tanggal Tua"
                     class="w-[90px] h-[90px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Tanggal Tua</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/terserah') }}'">
            <div class="w-[90px] h-[90px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[36px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Random Picker.png') }}" alt="Random Picker"
                     class="w-[90px] h-[90px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Terserah</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/split_bill') }}'">
            <div class="w-[90px] h-[90px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[36px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Split Bill.png') }}" alt="Split Bill"
                     class="w-[90px] h-[90px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Split Bill</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/submit-tempat') }}'">
            <div class="w-[90px] h-[90px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[36px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Komunitas.png') }}" alt="Komunitas"
                     class="w-[90px] h-[90px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Usulkan Tempat</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ url('/pages/hidden_gem') }}'">
            <div class="w-[90px] h-[90px] bg-[#FDF4E7] rounded-2xl flex items-center justify-center text-[36px] text-[#EF950F] transition-all duration-200 group-hover:bg-[#EF950F] group-hover:text-white group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Hidden Gem.png') }}" alt="Hidden Gem"
                     class="w-[90px] h-[90px] object-contain border border-[#EF950F] rounded-2xl">
            </div>
            <span class="text-[13px] font-semibold text-[#040818] text-center">Hidden Gem</span>
        </div>

    </div>

</section>
