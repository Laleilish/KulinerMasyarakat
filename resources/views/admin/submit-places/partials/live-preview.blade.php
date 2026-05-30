<div class="xl:col-span-5">
    <div class="sticky top-6 space-y-4">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            <h3 class="text-lg font-bold text-gray-800">Preview Tampilan User</h3>
        </div>
        
        {{-- Preview Card --}}
        <div class="bg-[#FDF8F0] rounded-3xl border border-gray-200 shadow-lg overflow-hidden">
            
            {{-- Hero Preview --}}
            <div class="relative w-full h-[220px] bg-gray-200">
                <img :src="previewPhoto" class="w-full h-full object-cover" x-show="previewPhoto">
                <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm font-bold bg-gray-100" x-show="!previewPhoto">
                    Tidak ada foto
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                
                <div class="absolute bottom-4 left-5 right-5">
                    <h2 class="text-2xl font-extrabold text-white mb-2 drop-shadow-md leading-tight" x-text="name || 'Nama Tempat'"></h2>
                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-200">
                        <div class="flex items-center gap-1 bg-white/20 px-2.5 py-1 rounded-full backdrop-blur-md text-white font-semibold border border-white/10">
                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            {{ $submitPlace->initial_rating ?? '0' }}
                        </div>
                        <div class="w-1 h-1 rounded-full bg-gray-400"></div>
                        <span class="font-medium drop-shadow capitalize" x-text="category ? category.replace(/_/g, ' ') : 'Kategori'"></span>
                        <template x-if="food_type">
                            <span>
                                <span class="inline-block w-1 h-1 rounded-full bg-gray-400 align-middle mx-1"></span>
                                <span class="font-medium drop-shadow" x-text="food_type"></span>
                            </span>
                        </template>
                        <template x-if="open_hours">
                            <span>
                                <span class="inline-block w-1 h-1 rounded-full bg-gray-400 align-middle mx-1"></span>
                                <span class="text-teal-400 font-bold drop-shadow" x-text="'Open ' + open_hours"></span>
                            </span>
                        </template>
                    </div>
                </div>
            </div>

            {{-- About Section --}}
            <div class="px-5 pt-5 pb-2">
                <h3 class="text-base font-bold text-gray-800 mb-3">About</h3>
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-600 leading-relaxed" x-text="description || 'Deskripsi belum tersedia.'"></p>
                </div>
            </div>

            {{-- Info Detail Section --}}
            <div class="px-5 pt-3 pb-5">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 text-[15px] mb-4">Info Detail</h3>
                    
                    {{-- Alamat --}}
                    <div class="flex gap-3.5 mb-4">
                        <div class="mt-0.5 text-teal-600 shrink-0">
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-800 mb-0.5">Alamat</p>
                            <p class="text-sm text-gray-500 leading-snug" x-text="address || '-'"></p>
                        </div>
                    </div>

                    {{-- Jam Buka --}}
                    <div class="flex gap-3.5 mb-4">
                        <div class="mt-0.5 text-teal-600 shrink-0">
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-800 mb-0.5">Jam Buka</p>
                            <p class="text-sm text-gray-500" x-text="open_hours || '-'"></p>
                        </div>
                    </div>

                    {{-- Range Harga --}}
                    <div class="flex gap-3.5" :class="landmark ? 'mb-6' : ''">
                        <div class="mt-0.5 text-teal-600 shrink-0">
                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-gray-800 mb-0.5">Range Harga</p>
                            <p class="text-sm text-gray-500" x-text="price_range || '-'"></p>
                        </div>
                    </div>

                    {{-- Patokan --}}
                    <template x-if="landmark">
                        <div>
                            <h3 class="font-bold text-gray-800 text-[15px] mb-2">Patokan</h3>
                            <p class="text-sm text-gray-500" x-text="landmark"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

