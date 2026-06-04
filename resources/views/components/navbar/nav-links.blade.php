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
    <li class="w-full py-3 border-b border-black/5 md:w-auto md:py-0 md:border-none">
        <a href="{{ route('home') }}"
           class="no-underline font-semibold text-base {{ request()->routeIs('home') ? 'text-dark border-b-2 border-red-logo pb-1' : 'text-muted' }}">
            Beranda
        </a>
    </li>
    <li class="w-full py-3 border-b border-black/5 md:w-auto md:py-0 md:border-none">
        <a href="{{ route('hidden-gem.index') }}"
           class="no-underline font-semibold text-base {{ request()->routeIs('hidden-gem.*') ? 'text-dark border-b-2 border-red-logo pb-1' : 'text-muted' }}">
            Hidden Gem
        </a>
    </li>
    <li class="w-full py-3 border-b border-black/5 md:w-auto md:py-0 md:border-none">
        <a href="{{ route('tanggal-tua.index') }}"
           class="no-underline font-semibold text-base {{ request()->routeIs('tanggal-tua.*') ? 'text-dark border-b-2 border-red-logo pb-1' : 'text-muted' }}">
            Tanggal Tua
        </a>
    </li>

    {{-- Mobile only: Login --}}
    @guest
        <div class="flex flex-col w-full md:hidden">
            <li class="w-full py-3 border-b border-black/5">
                <a href="{{ route('login') }}"
                   class="no-underline font-semibold text-base text-muted">Masuk</a>
            </li>
            <li class="w-full py-3">
                <div class="flex items-center gap-2 font-semibold">
                    <span class="text-dark cursor-pointer">ID</span>
                    <span class="text-muted">|</span>
                    <span class="text-muted cursor-pointer">EN</span>
                </div>
            </li>
        </div>
    @endguest

</ul>
