{{-- DESKTOP --}}
<div class="hidden md:block max-w-7xl mx-auto px-6 pt-6">
    <div class="relative w-full h-[500px] rounded-3xl overflow-hidden shadow-lg">
        <img src="{{ Storage::url($restaurant->image) }}" alt="Foto {{ $restaurant->name }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>

        <div class="absolute bottom-8 left-8 right-8 flex justify-between items-end">
            <div>
                <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-4 drop-shadow-md">{{ $restaurant->name }}</h1>
                <div class="flex items-center text-sm text-gray-200 gap-3">
                    <div class="flex items-center gap-1.5 bg-white/20 px-3 py-1.5 rounded-full backdrop-blur-md text-white font-semibold border border-white/10">
                        <svg class="w-4 h-4 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }}
                        <span class="text-gray-300 font-normal">({{ $restaurant->reviews->count() }} ulasan)</span>
                    </div>
                    <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                    <span class="font-medium drop-shadow">{{ ucwords(str_replace('_', ' ', $restaurant->category)) }}</span>
                    @if($restaurant->food_type)
                        <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                        <span class="font-medium drop-shadow">{{ $restaurant->food_type }}</span>
                    @endif
                    <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                    <span class="text-teal-400 font-bold drop-shadow">Open until {{ substr(explode('-', $restaurant->open_hours)[1] ?? $restaurant->open_hours, 0, 5) }}</span>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="copyLink()" class="w-11 h-11 rounded-full bg-black/40 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:bg-black/60 transition shadow-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                </button>
                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $restaurant->latitude }},{{ $restaurant->longitude }}" target="_blank" class="px-6 py-2.5 rounded-full bg-[#00A896] hover:bg-[#028c7d] text-white font-bold flex items-center gap-2 transition shadow-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Navigasi
                </a>
            </div>
        </div>
    </div>
</div>

{{-- MOBILE --}}
<div class="md:hidden relative w-full h-[350px]">
    <img src="{{ Storage::url($restaurant->image) }}" alt="Foto {{ $restaurant->name }}" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

    <div class="absolute bottom-6 left-4 right-4">
        <h1 class="text-3xl font-extrabold text-white mb-3 drop-shadow-md">{{ $restaurant->name }}</h1>
        <div class="flex items-center text-xs text-gray-200 gap-2 flex-wrap">
            <div class="flex items-center gap-1 bg-white/20 px-3 py-1 rounded-full backdrop-blur-md text-white font-semibold border border-white/10">
                <svg class="w-3.5 h-3.5 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                {{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }}
                <span class="text-gray-300 font-normal">({{ $restaurant->reviews->count() }} Ulasan)</span>
            </div>
            <div class="w-1 h-1 rounded-full bg-gray-400"></div>
            <span class="text-teal-400 font-bold drop-shadow">Open until {{ substr(explode('-', $restaurant->open_hours)[1] ?? $restaurant->open_hours, 0, 5) }}</span>
        </div>
    </div>
</div>
