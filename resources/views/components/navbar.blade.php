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

            {{-- Mobile only: Profile Menu (when logged in) --}}
            @auth
                <div class="flex flex-col w-full md:hidden mt-4">
                    <li class="w-full py-3 border-b border-black/5">
                        <a href="{{ route('profile.edit') }}"
                           class="no-underline font-semibold text-base text-muted flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>
                    </li>
                    <li class="w-full py-3 border-b border-black/5">
                        <a href="{{ route('dashboard') }}"
                           class="no-underline font-semibold text-base text-muted flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="w-full py-3 border-b border-black/5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left no-underline font-semibold text-base text-red-600 flex items-center gap-2 bg-transparent border-none cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </li>
                </div>
            @else
                {{-- Mobile only: Login --}}
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
            @endauth

        </ul>
    </div>

    {{-- Kanan: Notification + Profile (mobile & desktop) --}}
    <div class="flex items-center gap-3">
        @auth
            {{-- Notification Icon (visible on mobile & desktop) --}}
            <div class="relative">
                <button type="button" class="relative p-2 text-muted hover:text-dark transition-colors bg-transparent border-none cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>

                    {{-- Notification Badge --}}
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-400 rounded-full"></span>
                </button>
            </div>

            {{-- Profile (visible on mobile & desktop) --}}
            <div class="relative">
                <button id="profileBtn" type="button"
                        class="flex items-center gap-2 hover:opacity-80 transition-opacity bg-transparent border-none cursor-pointer">

                    {{-- Profile Image --}}
                    <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-white font-bold overflow-hidden">
                        @if(auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                        @endif
                    </div>
                </button>
                
                {{-- Dropdown Menu (desktop only) --}}
                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-card border border-gray-100 py-2 z-50">
                    <div class="px-4 py-2 border-b border-gray-100">
                        <p class="text-sm font-semibold text-dark">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-muted">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-dark hover:bg-cream-bg transition-colors no-underline">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Lihat Profil</span>
                        </div>
                    </a>
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-dark hover:bg-cream-bg transition-colors no-underline">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </a>
                    <hr class="my-2 border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2 bg-transparent border-none cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        @else
            {{-- Desktop only: Login + Lang --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('login') }}"
                   class="bg-secondary hover:bg-secondary-dark text-white px-4 py-2 rounded-full font-bold no-underline transition-colors">
                    Masuk
                </a>

                <div class="flex items-center gap-2 font-semibold">
                    <span class="text-dark cursor-pointer">ID</span>
                    <span class="text-muted">|</span>
                    <span class="text-muted cursor-pointer">EN</span>
                </div>
            </div>
        @endauth
    </div>

</nav>

@vite('resources/js/navbar/navbar.js')
