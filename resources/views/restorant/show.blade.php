@extends('layouts.app')

@section('content')
<div class="max-w-[900px] mx-auto pb-8">

    {{-- Hero --}}
    <div class="relative w-full h-[260px] md:h-[420px] overflow-hidden md:rounded-b-2xl">
        <img src="{{ Storage::url($restaurant->photo) }}"
             alt="Foto {{ $restaurant->name }}"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

        {{-- Hero Content --}}
        <div class="absolute bottom-0 left-0 right-0 p-4">
            <h1 class="text-[22px] md:text-[30px] font-bold text-white mb-2 leading-snug">
                {{ $restaurant->name }}
            </h1>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="flex items-center gap-1 px-3 py-1 rounded-full bg-white/15 backdrop-blur text-white text-xs font-semibold">
                    <svg class="w-3 h-3 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    {{ number_format($restaurant->reviews->avg('rating'), 1) }}
                    ({{ $restaurant->reviews->count() }} ulasan)
                </span>
                <span class="px-3 py-1 rounded-full bg-white/15 backdrop-blur text-white text-xs font-semibold">
                    {{ $restaurant->food_type }}
                </span>
                <span class="flex items-center gap-1 px-3 py-1 rounded-full bg-brand-green/20 backdrop-blur text-brand-green text-xs font-semibold">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Buka sampai {{ substr($restaurant->open_hours, -5) }}
                </span>
            </div>
        </div>

        {{-- Mobile Actions --}}
        <div class="absolute bottom-4 right-4 flex items-center gap-2 md:hidden">
            <button onclick="copyLink()"
                    class="w-9 h-9 rounded-full bg-white/15 backdrop-blur border border-white/30 flex items-center justify-center text-white"
                    aria-label="Salin link">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
            </button>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $restaurant->latitude }},{{ $restaurant->longitude }}"
               target="_blank"
               class="flex items-center gap-1 px-4 py-2 rounded-full bg-brand-green text-white text-xs font-bold">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Navigasi
            </a>
        </div>
    </div>

    {{-- Content Grid --}}
    <div class="px-4 md:px-6 mt-4 grid grid-cols-1 md:grid-cols-[1fr_300px] gap-4 items-start">

        {{-- Kiri --}}
        <div>
            {{-- Desktop Actions --}}
            <div class="hidden md:flex justify-end items-center gap-2 mb-3">
                <button onclick="copyLink()"
                        class="w-9 h-9 rounded-full bg-[var(--color-background-secondary)] border border-[var(--color-border-tertiary)] flex items-center justify-center text-[var(--color-text-primary)]"
                        aria-label="Salin link">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                </button>
                <a href="https://www.google.com/maps/dir/?api=1&destination={{ $restaurant->latitude }},{{ $restaurant->longitude }}"
                   target="_blank"
                   class="flex items-center gap-1 px-4 py-2 rounded-full bg-brand-green hover:bg-brand-green-hover text-white text-xs font-bold transition-colors">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Navigasi
                </a>
            </div>

            {{-- About --}}
            <h2 class="text-lg font-bold text-brand-dark mb-3 font-jakarta">About</h2>
            <div class="bg-white rounded-2xl border border-black/5 p-4 mb-5">
                <p class="text-sm text-brand-gray leading-relaxed">{{ $restaurant->description }}</p>
            </div>

            {{-- Ulasan --}}
            <div x-data="{ showForm: false }" id="tulis-ulasan">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-bold text-brand-dark font-jakarta">Ulasan</h2>
                    @auth
                        @if(!$hasReviewed)
                            <button @click="showForm = !showForm"
                               class="flex items-center gap-1 px-4 py-2 rounded-full bg-brand-green text-white text-xs font-bold hover:bg-brand-green-hover transition-colors">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                <span x-text="showForm ? 'Batal' : 'Tulis Ulasan'"></span>
                            </button>
                        @endif
                    @endauth
                </div>

                {{-- Alert Messages --}}
                @if(session('success'))
                    <div class="mb-4 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium border border-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-50 text-red-600 px-4 py-3 rounded-xl text-sm font-medium border border-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Form Tulis Ulasan --}}
                @auth
                    @if(!$hasReviewed)
                        <div x-show="showForm" x-collapse class="mb-5">
                            <form action="{{ route('reviews.store', $restaurant->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-black/5 p-4" x-data="{ rating: {{ old('rating', 0) }}, reviewPhotoName: '' }">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="block text-sm font-bold text-brand-dark mb-2">Rating <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="rating" :value="rating">
                                    <div class="flex gap-2">
                                        <template x-for="i in 5">
                                            <button type="button" @click="rating = i" class="focus:outline-none transition-transform hover:scale-110">
                                                <svg class="w-8 h-8" :class="i <= rating ? 'text-yellow-400 fill-yellow-400' : 'text-gray-200 fill-gray-200'" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </button>
                                        </template>
                                    </div>
                                    @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-bold text-brand-dark mb-2">Komentar</label>
                                    <textarea name="comment" rows="3" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-green text-sm resize-none" placeholder="Ceritain pengalamanmu makan di sini... (opsional)">{{ old('comment') }}</textarea>
                                    @error('comment') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="mb-4">
                                    <span class="block text-sm font-bold text-brand-dark mb-2">Foto (Opsional)</span>
                                    <label for="review-photo" class="flex justify-center px-6 pt-5 pb-6 border-2 border-brand-green/30 border-dashed rounded-xl bg-white hover:bg-brand-green/5 transition-colors cursor-pointer group">
                                        <div class="space-y-1 text-center flex flex-col items-center">
                                            <svg class="h-6 w-6 text-brand-green/50 group-hover:text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <p x-show="!reviewPhotoName" class="text-xs text-brand-green font-bold">Pilih foto pendukung</p>
                                            <p x-show="reviewPhotoName" x-text="reviewPhotoName" class="text-xs text-brand-green font-bold truncate max-w-[200px]"></p>
                                            <input id="review-photo" name="photo" type="file" accept="image/jpg,image/jpeg,image/png" class="sr-only" @change="reviewPhotoName = $event.target.files[0]?.name || ''">
                                        </div>
                                    </label>
                                    @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" class="bg-brand-green text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-brand-green-hover transition-colors shadow-sm">
                                        Kirim Ulasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>

            {{-- List Review --}}
            @forelse($restaurant->reviews as $review)
                <div class="bg-white rounded-2xl border border-black/5 p-4 mb-3">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center gap-3">
                            {{-- Avatar --}}
                            @if($review->user->profile_photo)
                                <img src="{{ Storage::url($review->user->profile_photo) }}"
                                     alt="{{ $review->user->name }}"
                                     class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-full bg-brand-green/20 flex items-center justify-center text-brand-green text-sm font-bold flex-shrink-0">
                                    {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-brand-dark">{{ $review->user->name }}</p>
                                <div class="flex gap-0.5 mt-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-200 text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="text-xs text-brand-gray flex-shrink-0">
                                {{ $review->created_at->diffForHumans() }}
                            </span>
                            @auth
                                @if(Auth::id() === $review->user_id || Auth::user()->isAdmin())
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <p class="text-sm text-brand-gray leading-relaxed">{{ $review->comment }}</p>
                    @if($review->photo)
                        <img src="{{ Storage::url($review->photo) }}"
                             alt="Foto ulasan"
                             class="mt-3 w-20 h-20 object-cover rounded-xl">
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-black/5 p-6 text-center">
                    <p class="text-sm text-brand-gray">Belum ada ulasan. Jadilah yang pertama! 🍽️</p>
                </div>
            @endforelse
        </div>

        {{-- Kanan: Info Detail (sticky di desktop) --}}
        <div class="md:sticky md:top-4">
            <div class="bg-white rounded-2xl border border-black/5 p-4">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm font-bold text-brand-dark">Info Detail</span>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $restaurant->latitude }},{{ $restaurant->longitude }}"
                       target="_blank"
                       class="flex items-center gap-1 px-3 py-1.5 rounded-full bg-brand-green text-white text-xs font-bold hover:bg-brand-green-hover transition-colors">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Navigasi
                    </a>
                </div>

                {{-- Alamat --}}
                <div class="flex gap-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-brand-green/10 flex items-center justify-center flex-shrink-0 text-brand-green">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-brand-gray uppercase tracking-wider mb-1">Alamat</p>
                        <p class="text-sm text-brand-dark font-medium leading-snug">{{ $restaurant->address }}</p>
                    </div>
                </div>

                {{-- Jam Buka --}}
                <div class="flex gap-3 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-brand-green/10 flex items-center justify-center flex-shrink-0 text-brand-green">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-brand-gray uppercase tracking-wider mb-1">Jam Buka</p>
                        <p class="text-sm text-brand-dark font-medium">{{ $restaurant->open_hours }}</p>
                    </div>
                </div>

                {{-- Range Harga --}}
                <div class="flex gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-brand-green/10 flex items-center justify-center flex-shrink-0 text-brand-green">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-brand-gray uppercase tracking-wider mb-1">Range Harga</p>
                        <p class="text-sm text-brand-dark font-medium">Rp {{ $restaurant->price_range }}</p>
                    </div>
                </div>

                {{-- Patokan --}}
                @if($restaurant->landmark)
                    <p class="text-sm font-bold text-brand-dark mb-1">Patokan</p>
                    <p class="text-sm text-brand-gray mb-2">{{ $restaurant->landmark }}</p>
                    @if($restaurant->landmark_photo)
                        <img src="{{ Storage::url($restaurant->landmark_photo) }}"
                             alt="Foto patokan"
                             class="w-full h-[120px] object-cover rounded-xl">
                    @endif
                @endif
            </div>
        </div>

    </div>
</div>

{{-- Toast --}}
<div id="toast"
     class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-brand-dark text-white px-5 py-2 rounded-full text-sm font-semibold opacity-0 transition-opacity duration-300 pointer-events-none z-50">
    Link berhasil disalin! 🔗
</div>

<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).catch(() => {});
    const toast = document.getElementById('toast');
    toast.classList.remove('opacity-0');
    toast.classList.add('opacity-100');
    setTimeout(() => {
        toast.classList.remove('opacity-100');
        toast.classList.add('opacity-0');
    }, 2200);
}
</script>
@endsection