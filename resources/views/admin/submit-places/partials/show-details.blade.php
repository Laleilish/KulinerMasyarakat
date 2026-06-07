{{-- Title & Category --}}
<div class="border-b border-gray-50 pb-5">
    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">{{ $submitPlace->name }}</h1>
    <div class="flex flex-wrap gap-2 mt-3">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
            {{ $submitPlace->category === 'makanan_berat' ? 'bg-orange-50 text-orange-700 border border-orange-100' : '' }}
            {{ $submitPlace->category === 'jajanan' ? 'bg-purple-50 text-purple-700 border border-purple-100' : '' }}
            {{ $submitPlace->category === 'minuman' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}">
            {{ str_replace('_', ' ', ucfirst($submitPlace->category)) }}
        </span>
        @if ($submitPlace->food_type)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                {{ $submitPlace->food_type }}
            </span>
        @endif
    </div>
</div>

{{-- Info Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-4">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Pengirim</span>
        <span class="text-sm font-bold text-gray-800">{{ $submitPlace->user->name ?? '-' }}</span>
        <span class="text-xs text-gray-400 block mt-0.5">{{ $submitPlace->user->email ?? '-' }}</span>
    </div>
    <div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-4">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Kampus Terdekat</span>
        <span class="text-sm font-bold text-gray-800">{{ $submitPlace->campus->name ?? '-' }}</span>
    </div>
    <div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-4">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Jam Operasional</span>
        <span class="text-sm font-bold text-gray-800">{{ $submitPlace->open_hours ?: '-' }}</span>
    </div>
    <div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-4">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Range Harga</span>
        <span class="text-sm font-bold text-gray-800">{{ $submitPlace->price_range ?: '-' }}</span>
    </div>
</div>

{{-- Address --}}
<div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-4">
    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Alamat</span>
    <p class="text-sm text-gray-700 leading-relaxed font-medium">{{ $submitPlace->address }}</p>
</div>

{{-- Description --}}
@if ($submitPlace->description)
    <div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-4">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Deskripsi</span>
        <p class="text-sm text-gray-700 leading-relaxed">{{ $submitPlace->description }}</p>
    </div>
@endif

{{-- Google Maps Link --}}
<div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-4">
    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1.5">Google Maps Link</span>
    <a href="{{ $submitPlace->gmaps_link }}" target="_blank" rel="noopener"
       class="text-sm text-emerald-600 hover:text-emerald-700 font-bold break-all flex items-center gap-1.5 no-underline">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>Buka di Google Maps &rarr;</span>
    </a>
    @if ($submitPlace->latitude && $submitPlace->longitude)
        <p class="text-[10px] text-gray-400 font-mono mt-2">Koordinat: {{ $submitPlace->latitude }}, {{ $submitPlace->longitude }}</p>
    @endif
</div>

{{-- Landmark --}}
@if ($submitPlace->landmark || $submitPlace->landmark_photo)
    <div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-4">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Patokan Lokasi</span>
        @if ($submitPlace->landmark)
            <p class="text-sm text-gray-700 font-medium mb-3">{{ $submitPlace->landmark }}</p>
        @endif
        @if ($submitPlace->landmark_photo)
            <div class="max-w-sm rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                <img src="{{ str_starts_with($submitPlace->landmark_photo, 'http') ? $submitPlace->landmark_photo : Storage::url($submitPlace->landmark_photo) }}" alt="Foto Patokan" class="w-full object-cover">
            </div>
        @endif
    </div>
@endif

{{-- Initial Review & Rating --}}
<div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-5">
    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Review & Ulasan Awal</span>
    <div class="flex items-center gap-1 mb-3">
        @for ($i = 1; $i <= 5; $i++)
            <svg class="w-5 h-5 {{ $i <= $submitPlace->initial_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @endfor
        <span class="text-sm font-bold text-gray-600 ml-1.5">{{ $submitPlace->initial_rating }} / 5</span>
    </div>
    
    @if ($submitPlace->initial_review)
        <p class="text-sm text-gray-700 leading-relaxed italic bg-white p-4 rounded-xl border border-gray-150">{{ $submitPlace->initial_review }}</p>
    @endif

    {{-- Display review photos array properly --}}
    @if (!empty($submitPlace->initial_review_photos) && is_array($submitPlace->initial_review_photos))
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-4">
            @foreach ($submitPlace->initial_review_photos as $photo)
                <div class="aspect-square rounded-xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50">
                    <img src="{{ str_starts_with($photo, 'http') ? $photo : Storage::url($photo) }}" alt="Foto Ulasan" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Timestamp --}}
<p class="text-[10px] text-gray-400">Diusulkan pada {{ $submitPlace->created_at->format('d M Y, H:i') }}</p>
