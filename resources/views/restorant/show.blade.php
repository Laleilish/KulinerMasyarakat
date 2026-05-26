@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FDF8F0] pb-12">
    
    {{-- DESKTOP HERO --}}
    <div class="hidden md:block max-w-7xl mx-auto px-6 pt-6">
        <div class="relative w-full h-[500px] rounded-3xl overflow-hidden shadow-lg">
            <img src="{{ Storage::url($restaurant->photo) }}" alt="Foto {{ $restaurant->name }}" class="w-full h-full object-cover">
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

    {{-- MOBILE HERO --}}
    <div class="md:hidden relative w-full h-[350px]">
        <img src="{{ Storage::url($restaurant->photo) }}" alt="Foto {{ $restaurant->name }}" class="w-full h-full object-cover">
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

    {{-- MOBILE ACTIONS --}}
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

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6 md:mt-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            
            {{-- LEFT COLUMN --}}
            <div class="md:col-span-2 flex flex-col gap-8">
                
                {{-- Desktop About --}}
                <div class="hidden md:block">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">About</h2>
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <p class="text-gray-600 leading-relaxed text-[15px]">{{ $restaurant->description ?? 'Deskripsi belum tersedia.' }}</p>
                    </div>
                </div>

                {{-- Mobile Combined Card (About + Info + Patokan) --}}
                <div class="md:hidden bg-white rounded-3xl p-5 shadow-sm border border-gray-100 mb-2">
                    <h2 class="text-xl font-bold text-gray-800 mb-3">About</h2>
                    <p class="text-gray-600 text-[15px] leading-relaxed mb-6">{{ $restaurant->description ?? 'Deskripsi belum tersedia.' }}</p>

                    <h3 class="font-bold text-gray-800 mb-4 text-base">Info Detail</h3>
                    
                    <div class="flex gap-4 mb-4">
                        <div class="mt-0.5 text-teal-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-800 mb-0.5">Alamat</p>
                            <p class="text-sm text-gray-500 leading-snug">{{ $restaurant->address }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <div class="mt-0.5 text-teal-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-800 mb-0.5">Jam Buka</p>
                            <p class="text-sm text-gray-500">{{ $restaurant->open_hours }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-6">
                        <div class="mt-0.5 text-teal-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-800 mb-0.5">Range Harga</p>
                            <p class="text-sm text-gray-500">{{ $restaurant->price_range }}</p>
                        </div>
                    </div>

                    @if($restaurant->landmark)
                        <h3 class="font-bold text-gray-800 mb-3 text-base">Patokan</h3>
                        <p class="text-sm text-gray-500 mb-3">{{ $restaurant->landmark }}</p>
                        @if($restaurant->landmark_photo)
                            <img src="{{ Storage::url($restaurant->landmark_photo) }}" alt="Patokan" class="w-full h-[160px] object-cover rounded-xl shadow-sm">
                        @endif
                    @endif
                </div>

                {{-- Ulasan Section --}}
                <div x-data="{ showForm: false }">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Ulasan</h2>
                        @auth
                            @if(!$hasReviewed)
                                <button @click="showForm = !showForm" class="px-5 py-2 bg-[#00A896] hover:bg-[#028c7d] text-white text-sm font-bold rounded-full flex items-center gap-2 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    <span x-text="showForm ? 'Batal' : 'Tulis Ulasan'"></span>
                                </button>
                            @endif
                        @endauth
                    </div>

                    @if(session('success'))
                        <div class="mb-4 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium border border-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Form Ulasan --}}
                    @auth
                        @if(!$hasReviewed)
                            <div x-show="showForm" x-collapse class="mb-6">
                                <form action="{{ route('reviews.store', $restaurant->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6" x-data="{ rating: {{ old('rating', 0) }}, reviewPhotoName: '' }">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-sm font-bold text-gray-800 mb-2">Rating <span class="text-red-500">*</span></label>
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
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-bold text-gray-800 mb-2">Komentar</label>
                                        <textarea name="comment" rows="3" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#00A896] text-sm resize-none" placeholder="Ceritain pengalamanmu makan di sini... (opsional)">{{ old('comment') }}</textarea>
                                    </div>
                                    <div class="mb-5">
                                        <span class="block text-sm font-bold text-gray-800 mb-2">Foto (Opsional)</span>
                                        <label class="flex justify-center px-6 pt-5 pb-6 border-2 border-teal-100 border-dashed rounded-xl bg-gray-50 hover:bg-teal-50/50 transition-colors cursor-pointer group">
                                            <div class="space-y-1 text-center flex flex-col items-center">
                                                <svg class="h-6 w-6 text-teal-400 group-hover:text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p x-show="!reviewPhotoName" class="text-xs text-teal-600 font-bold">Pilih foto pendukung</p>
                                                <p x-show="reviewPhotoName" x-text="reviewPhotoName" class="text-xs text-teal-600 font-bold truncate max-w-[200px]"></p>
                                                <input name="photo" type="file" accept="image/jpg,image/jpeg,image/png" class="sr-only" @change="reviewPhotoName = $event.target.files[0]?.name || ''">
                                            </div>
                                        </label>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="bg-[#00A896] text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-[#028c7d] transition-colors shadow-sm">Kirim Ulasan</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endauth

                    {{-- List Ulasan --}}
                    <div class="flex flex-col gap-4">
                        @forelse($restaurant->reviews->sortByDesc('created_at') as $review)
                            <div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center gap-3">
                                        @if($review->user->profile_photo)
                                            <img src="{{ Storage::url($review->user->profile_photo) }}" alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 text-sm font-bold">
                                                {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $review->user->name }}</p>
                                            <div class="flex gap-0.5 mt-0.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-200 text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-1">
                                        <span class="text-[11px] text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                        @auth
                                            @if(Auth::id() === $review->user_id || Auth::user()->isAdmin())
                                                <button type="button" @click="$dispatch('open-delete-modal', { url: '{{ route('reviews.destroy', $review->id) }}' })" class="text-[11px] text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                                <p class="text-[14px] text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                                @if($review->photo)
                                    <img src="{{ Storage::url($review->photo) }}" alt="Foto ulasan" class="mt-3 w-24 h-24 object-cover rounded-xl shadow-sm border border-gray-100">
                                @endif
                            </div>
                        @empty
                            <div class="bg-white rounded-3xl border border-gray-100 p-8 text-center shadow-sm">
                                <p class="text-gray-500">Belum ada ulasan. Jadilah yang pertama!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN (Desktop Info Detail) --}}
            <div class="hidden md:block col-span-1">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 sticky top-8">
                    <h3 class="font-bold text-gray-800 text-[15px] mb-5">Info Detail</h3>
                    
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

                    <div class="flex gap-4 mb-8">
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
                                <img src="{{ Storage::url($restaurant->landmark_photo) }}" alt="Patokan" class="w-full h-[180px] object-cover">
                                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                                    <p class="text-sm text-white font-medium drop-shadow">{{ $restaurant->landmark }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">{{ $restaurant->landmark }}</p>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Custom Delete Confirmation Modal --}}
<div x-data="{ openDeleteModal: false, deleteUrl: '' }" 
     @open-delete-modal.window="openDeleteModal = true; deleteUrl = $event.detail.url"
     x-show="openDeleteModal" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;">
    <div @click.away="openDeleteModal = false" 
         class="bg-white rounded-3xl p-6 max-w-sm w-full shadow-2xl border border-gray-100 transform transition-all"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="scale-95 translate-y-4"
         x-transition:enter-end="scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="scale-100 translate-y-0"
         x-transition:leave-end="scale-95 translate-y-4">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-50 text-red-500 rounded-full mb-4">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Hapus Ulasan?</h3>
        <p class="text-sm text-gray-500 text-center mb-6 leading-relaxed">Apakah Anda yakin ingin menghapus ulasan ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex gap-3 justify-center">
            <button @click="openDeleteModal = false" class="px-5 py-2.5 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold transition">
                Batal
            </button>
            <form :action="deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 rounded-full bg-red-500 hover:bg-red-600 text-white text-sm font-bold transition shadow-sm shadow-red-200">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-6 py-3 rounded-full text-sm font-semibold opacity-0 transition-opacity duration-300 pointer-events-none z-50 shadow-xl">
    Tautan disalin ke clipboard!
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