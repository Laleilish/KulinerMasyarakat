<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<nav class="flex justify-between items-center px-4 md:px-10 py-3 bg-cream-bg shadow-navbar sticky top-0 z-50">

    {{-- Kiri: Hamburger + Logo --}}
    <div class="flex items-center gap-3">

        {{-- Hamburger (mobile only) --}}
        <button id="hamburgerBtn" class="text-2xl md:hidden bg-transparent border-none cursor-pointer">☰</button>

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
            <img src="{{ asset('assets/img/icon-kumar.png') }}" alt="KUMAR" class="h-10">
        </a>

        {{-- Nav Links (slide-in mobile, inline desktop) --}}
        <ul id="navLinks"
            class="fixed top-0 left-[-100%] w-full h-screen bg-cream-bg flex flex-col items-start justify-start px-6 py-5 transition-all duration-400 z-[999] list-none
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

            {{-- Mobile only: Login + Lang --}}
            <div class="flex flex-col w-full md:hidden">
                @auth
                    <li class="w-full py-3 border-b border-black/5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="#" onclick="this.closest('form').submit()"
                               class="no-underline font-semibold text-base text-muted">Keluar</a>
                        </form>
                    </li>
                @else
                    <li class="w-full py-3 border-b border-black/5">
                        <a href="{{ route('login') }}"
                           class="no-underline font-semibold text-base text-muted">Masuk</a>
                    </li>
                @endauth
                <li class="w-full py-3">
                    <div class="flex items-center gap-2 font-semibold">
                        <span class="text-dark cursor-pointer">ID</span>
                        <span class="text-muted">|</span>
                        <span class="text-muted cursor-pointer">EN</span>
                    </div>
                </li>
            </div>

        </ul>
    </div>

    {{-- Kanan: Login + Lang (desktop only) --}}
    <div class="hidden md:flex items-center gap-6">
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="bg-secondary hover:bg-secondary-dark text-white border-none px-4 py-3 rounded-brand font-bold cursor-pointer transition-colors">
                    Keluar
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
               class="bg-secondary hover:bg-secondary-dark text-white px-4 py-2 rounded-full font-bold no-underline transition-colors">
                Masuk
            </a>
        @endauth

        <div class="flex items-center gap-2 font-semibold">
            <span class="text-dark cursor-pointer">ID</span>
            <span class="text-muted">|</span>
            <span class="text-muted cursor-pointer">EN</span>
        </div>
    </div>

</nav>

<script>
    const hamburger = document.getElementById('hamburgerBtn');
    const navLinks  = document.getElementById('navLinks');
    const closeBtn  = document.getElementById('closeBtn');

    hamburger.addEventListener('click', () => navLinks.style.left = '0');
    closeBtn.addEventListener('click', () => navLinks.style.left = '-100%');
</script>
    
</body>
</html>