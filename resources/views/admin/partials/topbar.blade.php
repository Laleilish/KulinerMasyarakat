<!-- Top Navbar -->
<header class="h-16 px-4 md:px-8 flex items-center justify-between lg:justify-end sticky top-0 z-30 bg-cream-light shadow-navbar-admin">
    <!-- Mobile Hamburger -->
    <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-gray-600 hover:text-gray-900 bg-transparent border-none cursor-pointer">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    
    <!-- Right Actions -->
    <div class="flex items-center gap-4">
        <!-- Notification Bell -->
        <div class="relative" x-data="{ notifOpen: false }">
            <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false" type="button" class="relative p-2 text-muted hover:text-dark transition-colors bg-transparent border-none cursor-pointer focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-1 right-1 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>

            <!-- Notification Dropdown Menu -->
            <div x-show="notifOpen" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                 x-cloak>
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-900">Notifikasi</p>
                </div>
                <div class="max-h-80 overflow-y-auto">
                    @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                        <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors no-underline">
                            <p class="text-sm text-gray-800">{{ $notification->data['message'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </a>
                    @empty
                        <div class="px-4 py-4 text-center text-sm text-gray-500">
                            Tidak ada notifikasi baru.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ profileOpen: false }">
            <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-2 hover:opacity-80 transition-opacity bg-transparent border-none cursor-pointer focus:outline-none">
                <div class="w-10 h-10 rounded-full bg-gray-200 shadow-sm overflow-hidden shrink-0">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-full h-full object-cover" referrerpolicy="no-referrer">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff" alt="Avatar" class="w-full h-full object-cover" referrerpolicy="no-referrer">
                    @endif
                </div>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="profileOpen" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                 x-cloak>
                
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                
                {{-- Back to Web --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors no-underline">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Kembali Ke KUMAR</span>
                        </div>
                    </div>
                </a>

                {{-- Profil --}}
                <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors no-underline group">
                     <div class="flex justify-between items-center w-full">
                         <div class="flex items-center gap-2">
                             <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                             </svg>
                             <span>Profil Saya</span>
                         </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                     </div>
                </a>

                {{-- Pengaturan --}}
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors no-underline group">
                     <div class="flex justify-between items-center w-full">
                         <div class="flex items-center gap-2">
                             <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                             </svg>
                             <span>Pengaturan</span>
                         </div>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                     </div>
                </a>

                <hr class="my-1 border-gray-100">
                
                {{-- Logout --}}
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
    </div>
</header>
