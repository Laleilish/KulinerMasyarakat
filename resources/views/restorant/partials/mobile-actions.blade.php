<div class="md:hidden flex items-center justify-between px-4 py-5 gap-4">
    <div class="flex items-center gap-3">
        <button onclick="copyLink()" class="w-12 h-12 rounded-full bg-white shadow-[0_2px_10px_rgba(0,0,0,0.05)] flex items-center justify-center text-gray-500 hover:text-gray-800 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
        </button>
    </div>
    <a href="{{ route('hidden-gem.index') }}?nav_lat={{ $restaurant->latitude }}&nav_lng={{ $restaurant->longitude }}&nav_campus_id={{ $restaurant->campus_id }}" class="flex-1 bg-[#00A896] text-white font-bold h-12 rounded-full flex items-center justify-center gap-2 shadow-[0_4px_12px_rgba(0,168,150,0.3)]">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M516-120 402-402 120-516v-56l720-268-268 720h-56Zm26-148 162-436-436 162 196 78 78 196Zm-78-196Z"/></svg>
        Navigasi
    </a>
</div>
