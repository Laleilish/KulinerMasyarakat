<div class="md:hidden flex items-center justify-between px-4 py-5 gap-4">
    <div class="flex items-center gap-3">
        <button class="w-12 h-12 rounded-full bg-white shadow-[0_2px_10px_rgba(0,0,0,0.05)] flex items-center justify-center text-gray-500 hover:text-red-500 transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        </button>
        <button onclick="copyLink()" class="w-12 h-12 rounded-full bg-white shadow-[0_2px_10px_rgba(0,0,0,0.05)] flex items-center justify-center text-gray-500 hover:text-gray-800 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
        </button>
    </div>
    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $restaurant->latitude }},{{ $restaurant->longitude }}" target="_blank" class="flex-1 bg-[#00A896] text-white font-bold h-12 rounded-full flex items-center justify-center gap-2 shadow-[0_4px_12px_rgba(0,168,150,0.3)]">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
        Navigasi
    </a>
</div>
