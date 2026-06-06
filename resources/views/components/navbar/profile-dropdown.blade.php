<div class="relative">
    <button id="profileBtn" type="button"
            class="flex items-center gap-2 hover:opacity-80 transition-opacity bg-transparent border-none cursor-pointer">
        <div class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-white font-bold overflow-hidden">
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" alt="Profile" class="w-full h-full object-cover" referrerpolicy="no-referrer">
            @else
                <span class="text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
            @endif
        </div>
    </button>

    {{-- Desktop Dropdown --}}
    <div id="profileDropdown"
         x-data="{ settingsOpen: false }"
         class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-card border border-gray-100 py-2 z-50">
        <div class="px-4 py-3 border-b border-gray-100">
            <p class="text-sm font-semibold text-dark truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs text-muted truncate">{{ auth()->user()->email }}</p>
        </div>
        
        {{-- Dashboard Admin --}}
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-dark hover:bg-black/5 transition-colors no-underline">
             <div class="flex justify-between items-center w-full">
                 <div class="flex items-center gap-2">
                     <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/>
                     </svg>
                     <span data-i18n="Dashboard">Dashboard</span>
                 </div>
                <svg class="w-4 h-4 text-muted group-hover:text-dark transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
             </div>
        </a>
        @endif

        {{-- Profil --}}
        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-dark hover:bg-black/5 transition-colors no-underline">
             <div class="flex justify-between items-center w-full">
                 <div class="flex items-center gap-2">
                     <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                     </svg>
                     <span data-i18n="Profil Saya">Profil Saya</span>
                 </div>
                <svg class="w-4 h-4 text-muted group-hover:text-dark transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
             </div>
        </a>

        {{-- Setting --}}
        <div class="relative">
            <button type="button" @click="settingsOpen = !settingsOpen"
                    class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-dark hover:bg-black/5 transition-colors bg-transparent border-none cursor-pointer">
                 <div class="flex justify-between items-center w-full">
                     <div class="flex items-center gap-2">
                         <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                         </svg>
                         <span data-i18n="Pengaturan">Pengaturan</span>
                     </div>
                    <svg class="w-4 h-4 text-muted transition-transform" :class="settingsOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                 </div>
            </button>

            {{-- Settings Submenu --}}
            <div x-show="settingsOpen" x-cloak
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="border-t border-gray-100 bg-gray-50/70 px-4 py-2">


                {{-- Notifikasi Titik Merah --}}
                <div class="flex items-center justify-between py-1.5">
                    <span class="text-xs font-semibold text-dark" data-i18n="Notifikasi">Notifikasi</span>
                    <button type="button"
                          @click="$store.notifDot.toggle()"
                          :class="$store.notifDot.enabled ? 'text-secondary font-bold' : 'text-muted'"
                          class="text-xs bg-transparent border-none cursor-pointer transition-colors hover:opacity-80"
                          x-text="$store.notifDot.enabled ? ($store.i18n.locale === 'EN' ? 'On' : 'Nyala') : ($store.i18n.locale === 'EN' ? 'Off' : 'Mati')">Nyala</button>
                </div>

                {{-- Divider --}}
                <div class="h-px bg-black/8"></div>

                {{-- Language --}}
                <div class="flex items-center justify-between py-1.5">
                    <span class="text-xs font-semibold text-dark" data-i18n="Bahasa">Bahasa</span>
                    <div class="flex items-center gap-1">
                        <button type="button"
                                @click="$store.i18n.setLocale('ID')"
                                :class="$store.i18n.locale === 'ID' ? 'font-bold text-dark' : 'text-muted'"
                                class="text-xs bg-transparent border-none cursor-pointer transition-colors hover:text-dark">
                            ID
                        </button>
                        <span class="text-xs text-muted">|</span>
                        <button type="button"
                                @click="$store.i18n.setLocale('EN')"
                                :class="$store.i18n.locale === 'EN' ? 'font-bold text-dark' : 'text-muted'"
                                class="text-xs bg-transparent border-none cursor-pointer transition-colors hover:text-dark">
                            EN
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="my-1 border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors bg-transparent border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span data-i18n="Keluar">Keluar</span>
            </button>
        </form>
    </div>
</div>
