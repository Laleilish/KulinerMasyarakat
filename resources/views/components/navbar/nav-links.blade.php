{{-- Nav Links --}}
<ul id="navLinks"
    class="fixed top-0 -left-full w-full h-screen bg-cream-bg flex flex-col items-start justify-start px-6 py-5 transition-all duration-400 z-999 list-none
           md:static md:w-auto md:h-auto md:flex-row md:items-center md:gap-6 md:bg-transparent md:transition-none md:p-0">

    {{-- Header mobile menu --}}
    <div class="flex justify-between items-center w-full mb-8 md:hidden">
        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
            <img src="{{ asset('assets/img/icon-kumar.png') }}" alt="KUMAR" class="h-10">
        </a>
        <button id="closeBtn" class="text-xl font-bold text-primary bg-transparent border-none cursor-pointer">✕</button>
    </div>

    {{-- Menu Items --}}
    <li class="w-full mb-2 md:w-auto md:mb-0">
        <a href="{{ route('home') }}"
           class="block w-full px-4 py-3 rounded-xl md:inline-block md:w-auto md:px-0 md:py-0 md:rounded-none no-underline font-semibold text-base transition-colors {{ request()->routeIs('home') ? 'bg-[#F2E0BE] text-dark shadow-sm md:bg-transparent md:shadow-none md:border-b-2 md:border-red-logo md:pb-1' : 'text-muted hover:bg-[#F2E0BE]/50 md:hover:bg-transparent hover:text-dark' }}">
            <span data-i18n="Beranda">Beranda</span>
        </a>
    </li>
    <li class="w-full mb-2 md:w-auto md:mb-0">
        <a href="{{ route('hidden-gem.index') }}"
           class="block w-full px-4 py-3 rounded-xl md:inline-block md:w-auto md:px-0 md:py-0 md:rounded-none no-underline font-semibold text-base transition-colors {{ request()->routeIs('hidden-gem.*') ? 'bg-[#F2E0BE] text-dark shadow-sm md:bg-transparent md:shadow-none md:border-b-2 md:border-red-logo md:pb-1' : 'text-muted hover:bg-[#F2E0BE]/50 md:hover:bg-transparent hover:text-dark' }}">
            <span data-i18n="Hidden Gem">Hidden Gem</span>
        </a>
    </li>
    <li class="w-full mb-2 md:w-auto md:mb-0">
        <a href="{{ route('tanggal-tua.index') }}"
           class="block w-full px-4 py-3 rounded-xl md:inline-block md:w-auto md:px-0 md:py-0 md:rounded-none no-underline font-semibold text-base transition-colors {{ request()->routeIs('tanggal-tua.*') ? 'bg-[#F2E0BE] text-dark shadow-sm md:bg-transparent md:shadow-none md:border-b-2 md:border-red-logo md:pb-1' : 'text-muted hover:bg-[#F2E0BE]/50 md:hover:bg-transparent hover:text-dark' }}">
            <span data-i18n="Tanggal Tua">Tanggal Tua</span>
        </a>
    </li>

    {{-- Mobile only: Login --}}
    @guest
        <div class="flex flex-col w-full md:hidden">
            <li class="w-full mb-2">
                <a href="{{ route('login') }}"
                   class="block w-full px-4 py-3 rounded-xl no-underline font-semibold text-base transition-colors text-muted hover:bg-[#F2E0BE]/50 hover:text-dark">
                    <span data-i18n="Masuk">Masuk</span>
                </a>
            </li>
        </div>
    @endguest

</ul>
