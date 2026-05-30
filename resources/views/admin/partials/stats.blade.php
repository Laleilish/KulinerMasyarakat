<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 lg:gap-6">
    {{-- Total Resto --}}
    <div class="bg-white rounded-2xl p-3 sm:p-4 border border-gray-100/50 shadow-sm h-28 sm:h-32 lg:h-28 flex flex-col justify-between">
        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-md bg-cream-bg flex items-center justify-center text-gray-800 shrink-0">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>

        <div>
            <h4 class="text-gray-900 font-medium text-[13px] sm:text-sm mb-2 leading-tight">
                Jumlah Resto
            </h4>
            <div class="text-lg sm:text-xl font-medium text-gray-900 leading-none">
                {{ number_format($stats['restaurants_count']) }}
            </div>
        </div>
    </div>

    {{-- Total Ulasan --}}
    <div class="bg-white rounded-2xl p-3 sm:p-4 border border-gray-100/50 shadow-sm h-28 sm:h-32 lg:h-28 flex flex-col justify-between">
        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-md bg-cream-bg flex items-center justify-center text-gray-800 shrink-0">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </div>

        <div>
            <h4 class="text-gray-900 font-medium text-[13px] sm:text-sm mb-2 leading-tight">
                Jumlah Ulasan
            </h4>
            <div class="text-lg sm:text-xl font-medium text-gray-900 leading-none">
                {{ number_format($stats['reviews_count']) }}
            </div>
        </div>
    </div>

    {{-- Pengguna Aktif --}}
    <div class="bg-white rounded-2xl p-3 sm:p-4 border border-gray-100/50 shadow-sm h-28 sm:h-32 lg:h-28 flex flex-col justify-between">
        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-md bg-cream-bg flex items-center justify-center text-gray-800 shrink-0">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>

        <div>
            <h4 class="text-gray-900 font-medium text-[13px] sm:text-sm mb-2 leading-tight">
                Pengguna Aktif
            </h4>
            <div class="text-lg sm:text-xl font-medium text-gray-900 leading-none">
                {{ number_format($stats['users_count']) }}
            </div>
        </div>
    </div>

    {{-- Usulan Baru --}}
    <div class="bg-white rounded-2xl p-3 sm:p-4 border border-gray-100/50 shadow-sm h-28 sm:h-32 lg:h-28 flex flex-col justify-between">
        <div class="w-fit self-start inline-flex h-6 sm:h-7 px-2 rounded-md bg-cream-bg items-center justify-center text-gray-800 shrink-0">
            <span class="text-[8px] sm:text-[9px] font-bold tracking-wide leading-none">
                NEW
            </span>
        </div>

        <div>
            <h4 class="text-gray-900 font-medium text-[13px] sm:text-sm mb-2 leading-tight whitespace-normal break-words">
                Usulan Baru
            </h4>

            <div class="text-lg sm:text-xl font-medium text-gray-900 leading-none">
                {{ number_format($stats['pending_places_count']) }}
            </div>
        </div>
    </div>
</div>