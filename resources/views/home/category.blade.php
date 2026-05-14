<section class="text-center px-5 pt-6 pb-4 md:px-10 md:py-[30px]">

    <h2 class="text-2xl md:text-3xl font-bold text-dark mb-6">Mencari Hal Menarik?</h2>

    {{-- Mobile Baris 1--}}
    <div class="flex justify-center gap-4 mb-4 md:hidden">

        {{-- Tanggal Tua --}}
        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('tanggal-tua.index') }}'">
            <div class="w-[70px] h-[70px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Tanggal Tua.png') }}" alt="Tanggal Tua"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Tanggal Tua</span>
        </div>

        {{-- Terserah --}}
        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('terserah.index') }}'">
            <div class="w-[70px] h-[70px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Random Picker.png') }}" alt="Random Picker"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Terserah</span>
        </div>

        {{-- Split Bill --}}
        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('split-bill.index') }}'">
            <div class="w-[70px] h-[70px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Split Bill.png') }}" alt="Split Bill"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Split Bill</span>
        </div>

    </div>

    {{-- Mobile Baris 2 --}}
    <div class="flex justify-center gap-4 md:hidden">

        {{-- Submit Tempat --}}
        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('submit-place.create') }}'">
            <div class="w-[70px] h-[70px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Komunitas.png') }}" alt="Komunitas"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Usulkan Tempat</span>
        </div>

        {{-- Hidden Gem --}}
        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('hidden-gem.index') }}'">
            <div class="w-[70px] h-[70px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Hidden Gem.png') }}" alt="Hidden Gem"
                     class="w-[70px] h-[70px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Hidden Gem</span>
        </div>

    </div>

    {{-- Desktop: semua 5 item sejajar --}}
    <div class="hidden md:flex justify-center items-center gap-8">

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('tanggal-tua.index') }}'">
            <div class="w-[100px] h-[100px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Tanggal Tua.png') }}" alt="Tanggal Tua"
                     class="w-[100px] h-[100px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Tanggal Tua</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('terserah.index') }}'">
            <div class="w-[100px] h-[100px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Random Picker.png') }}" alt="Random Picker"
                     class="w-[100px] h-[100px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Terserah</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('split-bill.index') }}'">
            <div class="w-[100px] h-[100px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Split Bill.png') }}" alt="Split Bill"
                     class="w-[100px] h-[100px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Split Bill</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('submit-place.create') }}'">
            <div class="w-[100px] h-[100px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Komunitas.png') }}" alt="Komunitas"
                     class="w-[100px] h-[100px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Usulkan Tempat</span>
        </div>

        <div class="group flex flex-col items-center gap-2 cursor-pointer"
             onclick="window.location.href='{{ route('hidden-gem.index') }}'">
            <div class="w-[100px] h-[100px] bg-cream-bg rounded-xl flex items-center justify-center transition-all duration-200 group-hover:bg-[#EF950F] group-hover:-translate-y-1">
                <img src="{{ asset('assets/img/Menu/Hidden Gem.png') }}" alt="Hidden Gem"
                     class="w-[100px] h-[100px] object-contain border border-[#EF950F] rounded-xl">
            </div>
            <span class="text-sm font-semibold text-dark text-center">Hidden Gem</span>
        </div>

    </div>

</section>
