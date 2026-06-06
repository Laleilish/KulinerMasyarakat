{{-- Notification Icon & Dropdown --}}
<div class="relative">
    <button id="notificationBtn" type="button" class="relative p-2 text-muted hover:text-dark transition-colors bg-transparent border-none cursor-pointer">
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

    {{-- Desktop Notification Dropdown --}}
    <div id="notificationDropdown"
         class="hidden absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-card border border-gray-100 py-2 z-50">
        <div class="px-4 py-3 border-b border-gray-100">
            <p class="text-sm font-semibold text-dark" data-i18n="Notifikasi">Notifikasi</p>
        </div>
        <div class="max-h-80 overflow-y-auto">
            @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                <a href="{{ route('notifications.read', $notification->id) }}" class="block px-4 py-3 border-b border-gray-50 hover:bg-black/5 transition-colors no-underline">
                    <p class="text-sm text-dark">{{ $notification->data['message'] }}</p>
                    <p class="text-xs text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </a>
            @empty
                <div class="px-4 py-4 text-center text-sm text-muted">
                    <span data-i18n="Tidak ada notifikasi baru.">Tidak ada notifikasi baru.</span>
                </div>
            @endforelse
        </div>
    </div>
</div>
