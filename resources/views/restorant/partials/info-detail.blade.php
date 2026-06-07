<div class="flex gap-4 mb-5">
    <div class="mt-0.5 text-teal-600">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </div>
    <div>
        <p class="text-[11px] font-bold text-gray-800 mb-0.5">Alamat</p>
        <p class="text-sm text-gray-500 leading-snug">{{ $restaurant->address }}</p>
    </div>
</div>

<div class="flex gap-4 mb-5">
    <div class="mt-0.5 text-teal-600">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <div>
        <p class="text-[11px] font-bold text-gray-800 mb-0.5">Jam Buka</p>
        <p class="text-sm text-gray-500">{{ $restaurant->open_hours }}</p>
    </div>
</div>

<div class="flex gap-4 {{ $restaurant->landmark ? 'mb-8' : '' }}">
    <div class="mt-0.5 text-teal-600">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
    </div>
    <div>
        <p class="text-[11px] font-bold text-gray-800 mb-0.5">Range Harga</p>
        <p class="text-sm text-gray-500">{{ $restaurant->price_range }}</p>
    </div>
</div>

@if($restaurant->landmark)
    <h3 class="font-bold text-gray-800 text-[15px] mb-3">Patokan</h3>
    @if($restaurant->landmark_photo)
        <div class="relative rounded-2xl overflow-hidden shadow-sm">
            <img src="{{ str_starts_with($restaurant->landmark_photo, 'http') ? $restaurant->landmark_photo : Storage::url($restaurant->landmark_photo) }}" alt="Patokan" class="w-full h-[180px] object-cover">
            <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                <p class="text-sm text-white font-medium drop-shadow">{{ $restaurant->landmark }}</p>
            </div>
        </div>
    @else
        <p class="text-sm text-gray-500">{{ $restaurant->landmark }}</p>
    @endif
@endif
