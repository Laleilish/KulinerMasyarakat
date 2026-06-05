{{-- Overlay --}}
<div id="profileOverlay"
     class="fixed inset-0 bg-black/40 z-998 opacity-0 pointer-events-none transition-opacity duration-300">
</div>

{{-- Slide-in Panel/Mobile --}}
<div id="profilePanel"
     x-data="{ settingsOpen: false, language: 'ID' }"
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
                    <img src="{{ auth()->user()->avatar }}" alt="Profile" class="w-full h-full object-cover" referrerpolicy="no-referrer">
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

        {{-- Dashboard --}}
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center justify-between px-3 py-4 rounded-xl hover:bg-black/5 transition-colors no-underline group">
            <div class="flex items-center gap-4">
                <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/>
                </svg>
                <span class="font-bold">Dashboard</span>
            </div>
            <svg class="w-4 h-4 text-muted group-hover:text-dark transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        @endif

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
        <button type="button" @click="settingsOpen = true"
           class="w-full flex items-center justify-between px-3 py-4 rounded-xl hover:bg-black/5 transition-colors bg-transparent border-none cursor-pointer group">
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
        </button>

        {{-- Settings Modal --}}
        <div x-show="settingsOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute inset-4 bottom-auto bg-cream-bg rounded-2xl shadow-card border border-black/8 p-5 z-10">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between mb-4">
                <span class="font-bold text-dark text-base">Pengaturan</span>
                <button type="button" @click="settingsOpen = false"
                        class="w-7 h-7 flex items-center justify-center rounded-full hover:bg-black/8 transition-colors bg-transparent border-none cursor-pointer text-dark">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Divider --}}
            <div class="h-px bg-black/8 mb-3"></div>

            {{-- Notifikasi Row --}}
            <div class="flex items-center justify-between py-3">
                <span class="text-sm font-semibold text-dark">Notifikasi</span>
                <span class="text-sm font-medium text-secondary cursor-pointer">Izinkan</span>
            </div>

            {{-- Divider --}}
            <div class="h-px bg-black/8"></div>

            {{-- Language Row --}}
            <div class="flex items-center justify-between py-3">
                <span class="text-sm font-semibold text-dark">Bahasa</span>
                <div class="relative">
                    <button type="button" @click="$refs.langMenu.classList.toggle('hidden')"
                            class="flex items-center gap-1.5 text-sm font-medium text-muted hover:text-dark transition-colors bg-transparent border-none cursor-pointer">
                        <span x-text="language"></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-ref="langMenu" class="hidden absolute right-0 top-7 bg-white rounded-xl shadow-card border border-black/8 py-1 min-w-[100px] z-10">
                        <button type="button" @click="language = 'ID'; $refs.langMenu.classList.add('hidden')"
                                :class="language === 'ID' ? 'text-dark font-semibold' : 'text-muted'"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-black/5 transition-colors bg-transparent border-none cursor-pointer">
                            ID
                        </button>
                        <button type="button" @click="language = 'EN'; $refs.langMenu.classList.add('hidden')"
                                :class="language === 'EN' ? 'text-dark font-semibold' : 'text-muted'"
                                class="w-full text-left px-4 py-2 text-sm hover:bg-black/5 transition-colors bg-transparent border-none cursor-pointer">
                            EN
                        </button>
                    </div>
                </div>
            </div>
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
