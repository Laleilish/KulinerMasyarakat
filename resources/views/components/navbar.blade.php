<nav class="flex justify-between items-center px-4 md:px-10 py-3 bg-cream-bg shadow-navbar sticky top-0 z-50">

    {{-- Kiri: Hamburger + Logo --}}
    <div class="flex items-center gap-3">

        {{-- Hamburger (mobile only) --}}
        <button id="hamburgerBtn" class="text-2xl md:hidden bg-transparent border-none cursor-pointer">☰</button>

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
            <img src="{{ asset('assets/img/icon-kumar.png') }}" alt="KUMAR" class="h-10">
        </a>

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
    </div>

    {{-- Kanan --}}
    <div class="flex items-center gap-3">
        @auth
            {{-- Notification Icon --}}
            <button type="button" class="relative p-2 text-muted hover:text-dark transition-colors bg-transparent border-none cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-400 rounded-full"></span>
            </button>

            {{-- Profile Button + Desktop Dropdown --}}
            <div class="relative">
                <button id="profileBtn" type="button"
                        class="flex items-center gap-2 hover:opacity-80 transition-opacity bg-transparent border-none cursor-pointer">
                    <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-white font-bold overflow-hidden">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                        @endif
                    </div>
                </button>

                {{-- Desktop Dropdown --}}
                <div id="profileDropdown"
                     class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-card border border-gray-100 py-2 z-50">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-dark truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-muted truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-dark hover:bg-black/5 transition-colors no-underline">
                         <div class="flex justify-between items-center w-full">
                             <div class="flex items-center gap-2">
                                 <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                 </svg>
                                 <span>Profil Saya</span>
                             </div>
                            <svg class="w-4 h-4 text-muted group-hover:text-dark transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                         </div>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-dark  hover:bg-black/5 transition-colors no-underline">
                         <div class="flex justify-between items-center w-full">
                             <div class="flex items-center gap-2">
                                 <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                 </svg>
                                 <span>Pengaturan</span>
                             </div>
                            <svg class="w-4 h-4 text-muted group-hover:text-dark transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                         </div>
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-dark hover:bg-black/5 transition-colors no-underline">
                        <div class="flex justify-between items-center w-full">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span>Notifikasi</span>
                            </div>
                            <span class="text-sm font-medium text-secondary">Izinkan</span>
                        </div>
                    </a>
                    
                    <hr class="my-1 border-gray-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors bg-transparent border-none cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
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

{{--  PROFILE PANEL  --}}
@auth

{{-- Overlay --}}
<div id="profileOverlay"
     class="fixed inset-0 bg-black/40 z-998 opacity-0 pointer-events-none transition-opacity duration-300">
</div>

{{-- Slide-in Panel/Mobile --}}
<div id="profilePanel"
     class="fixed top-0 right-0 h-full w-75 bg-cream-bg z-999 shadow-2xl
                 translate-x-full transition-transform duration-300 ease-in-out
                 flex flex-col rounded-l-2xl overflow-hidden">

    {{-- Header: Avatar + Info + Close --}}
    <div class="px-6 pt-6 pb-5">

        {{-- Close Button --}}
        <div class="flex justify-end mb-4">
            <button id="profilePanelClose"
                    class="w-8 h-8 flex items-center justify-center text-orange rounded-full hover:bg-orange/10 transition-colors bg-transparent border-none cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Avatar + Name + Email --}}
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-secondary flex items-center justify-center text-white font-bold overflow-hidden shrink-0 border-2 border-white shadow-md">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="Profile" class="w-full h-full object-cover">
                @else
                    <span class="text-xl">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                @endif
            </div>
            <div class="min-w-0">
                <p class="font-bold text-dark text-base truncate">{{ auth()->user()->name }}</p>
                <p class="text-muted text-sm truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    {{-- Divider --}}
    <div class="h-px bg-black/8 mx-6"></div>

    {{-- Menu Items --}}
    <nav class="flex flex-col px-4 py-4 gap-1">

        {{-- Profil Saya --}}
        <a href="{{ route('profile.show') }}"
           class="flex items-center justify-between px-3 py-4 rounded-xl hover:bg-black/5 transition-colors no-underline group">
            <div class="flex items-center gap-4">
                <svg class="w-5 h-5 text-dark/70" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="font-semibold text-dark text-sm">Profil Saya</span>
            </div>
            <svg class="w-4 h-4 text-muted group-hover:text-dark transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        {{-- Pengaturan --}}
        <a href="{{ route('profile.edit') }}"
           class="flex items-center justify-between px-3 py-4 rounded-xl hover:bg-black/5 transition-colors no-underline group">
            <div class="flex items-center gap-4">
                <svg class="w-5 h-5 text-dark/70" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="font-semibold text-dark text-sm">Pengaturan</span>
            </div>
            <svg class="w-4 h-4 text-muted group-hover:text-dark transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>

        {{-- Notifikasi --}}
        <div class="flex items-center justify-between px-3 py-4 rounded-xl hover:bg-black/5 transition-colors cursor-pointer group">
            <div class="flex items-center gap-4">
                <svg class="w-5 h-5 text-dark/70" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="font-semibold text-dark text-sm">Notifikasi</span>
            </div>
            <span class="text-sm font-medium text-secondary">Izinkan</span>
        </div>

        {{-- Divider --}}
        <div class="h-px bg-black/8 my-1 mx-2"></div>

        {{-- Keluar --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-4 px-3 py-4 rounded-xl hover:bg-red-50 transition-colors bg-transparent border-none cursor-pointer text-left">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="font-semibold text-red-500 text-sm">Keluar</span>
            </button>
        </form>

    </nav>

</div>

@endauth

@vite('resources/js/navbar/navbar.js')
