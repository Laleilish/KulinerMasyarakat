<!-- Sidebar -->
<aside class="fixed inset-y-0 left-0 w-64 bg-cream-light border-r border-gray-200/80 transform lg:transform-none lg:static transition-transform duration-300 z-50 flex flex-col"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       x-cloak>
    
    <!-- Logo Area -->
    <div class="h-24 flex items-center px-8 shrink-0">
        <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline">
            <img src="{{ asset('assets/img/icon-kumar.png') }}" alt="KUMAR" class="h-10">
        </a>
    </div>
    
    <!-- Menu -->
    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold no-underline transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#F2E0BE] text-gray-900 shadow-sm' : 'text-gray-500 hover:bg-[#F2E0BE]/50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- Usulan Tempat --}}
        <a href="{{ route('admin.submit-places.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold no-underline transition-colors {{ request()->routeIs('admin.submit-places.*') ? 'bg-[#F2E0BE] text-gray-900 shadow-sm' : 'text-gray-500 hover:bg-[#F2E0BE]/50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span>Usulan Tempat</span>
        </a>

        {{-- Kelola Restoran --}}
        <a href="{{ route('admin.restaurants.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold no-underline transition-colors {{ request()->routeIs('admin.restaurants.*') ? 'bg-[#F2E0BE] text-gray-900 shadow-sm' : 'text-gray-500 hover:bg-[#F2E0BE]/50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                <circle cx="12" cy="10" r="3" />
            </svg>
            <span>Kelola Restoran</span>
        </a>

        {{-- Manajemen User --}}
        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold no-underline transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#F2E0BE] text-gray-900 shadow-sm' : 'text-gray-500 hover:bg-[#F2E0BE]/50 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Manajemen User</span>
        </a>
    </nav>
</aside>
