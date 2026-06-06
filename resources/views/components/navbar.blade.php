<nav class="flex justify-between items-center px-4 md:px-8 py-3 bg-cream-bg shadow-navbar sticky top-0 z-50">

    {{-- Kiri --}}
    <div class="flex items-center gap-4">

        {{-- Hamburger --}}
        <button id="hamburgerBtn" class="text-2xl md:hidden bg-transparent border-none cursor-pointer">☰</button>

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
            <img src="{{ asset('assets/img/icon-kumar.png') }}" alt="KUMAR" class="h-10">
        </a>

        @include('components.navbar.nav-links')
    </div>

    {{-- Kanan --}}
    <div class="flex items-center gap-4">
        @auth
            @include('components.navbar.notification-dropdown')
            @include('components.navbar.profile-dropdown')
        @else
            {{-- Desktop only: Login + Lang --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('login') }}"
                   class="bg-secondary hover:bg-secondary-dark text-white px-4 py-2 rounded-full font-bold no-underline transition-colors">
                    <span data-i18n="Masuk">Masuk</span>
                </a>
                <div class="flex items-center gap-2 font-semibold">
                    <button type="button"
                            @click="$store.i18n.setLocale('ID')"
                            :class="$store.i18n.locale === 'ID' ? 'text-dark' : 'text-muted'"
                            class="bg-transparent border-none cursor-pointer font-semibold transition-colors hover:text-dark">ID</button>
                    <span class="text-muted">|</span>
                    <button type="button"
                            @click="$store.i18n.setLocale('EN')"
                            :class="$store.i18n.locale === 'EN' ? 'text-dark' : 'text-muted'"
                            class="bg-transparent border-none cursor-pointer font-semibold transition-colors hover:text-dark">EN</button>
                </div>
            </div>
        @endauth
    </div>

</nav>

{{--  PROFILE PANEL  --}}
@auth
    @include('components.navbar.mobile-panel')
@endauth

@vite('resources/js/navbar/navbar.js')
