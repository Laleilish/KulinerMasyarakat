@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-[#FDF8F0] py-12 flex items-center justify-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex flex-col md:flex-row gap-8 md:gap-16 lg:gap-64 items-center">
            
            <!-- Left Side Information -->
            <div class="w-full md:w-1/2 flex justify-center md:justify-end">
                <div class="max-w-md w-full">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-800 mb-2 tracking-tight">
                        Punya Info
                    </h1>
                    <div class="bg-white inline-block px-4 py-2 md:px-6 md:py-3 rounded-2xl shadow-sm mb-6">
                        <span class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#9e1c1f]">Hidden Gem?</span>
                    </div>
                    <p class="text-gray-500 text-base md:text-lg lg:text-xl leading-relaxed">
                        Bantu yang lain nemuin tempat makan enak, porsi kuli, dan ramah di kantong akhir bulan
                    </p>
                </div>
            </div>

            <!-- Right Side Form -->
            <div class="w-full md:w-1/2 flex justify-center md:justify-start mt-8 md:mt-0">
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] w-full max-w-md p-6 md:p-8" 
                     x-data="submitPlaceForm()">
                    
                    <!-- Progress Bar & Steps -->
                    <div class="relative flex justify-between items-center mb-8">
                        <div class="absolute left-0 right-0 top-5 transform -translate-y-1/2 h-1 bg-gray-200 z-0"></div>
                        <div class="absolute left-0 top-5 transform -translate-y-1/2 h-1 bg-emerald-500 transition-all duration-500 z-0"
                            :style="'width: calc(20px + ' + ((step - 1) / 2) + ' * (100% - 40px))'"></div>

                        <!-- Step 1 -->
                        <div class="relative z-10 flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300 shadow-sm"
                                :class="step >= 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'">
                                1
                            </div>
                            <span class="text-xs font-semibold" :class="step >= 1 ? 'text-emerald-500' : 'text-gray-400'">Info Dasar</span>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative z-10 flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300 shadow-sm"
                                :class="step >= 2 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'">
                                2
                            </div>
                            <span class="text-xs font-semibold" :class="step >= 2 ? 'text-emerald-500' : 'text-gray-400'">Detail & Lokasi</span>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative z-10 flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-300 shadow-sm"
                                :class="step >= 3 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'">
                                3
                            </div>
                            <span class="text-xs font-semibold" :class="step >= 3 ? 'text-emerald-500' : 'text-gray-400'">Review</span>
                        </div>
                    </div>

                    <form action="{{ route('submit-places.store') }}" method="POST" enctype="multipart/form-data" x-ref="submitForm">
                        @csrf
                        
                        <!-- STEP 1: Info Dasar -->
                        <div x-show="step === 1" x-transition.opacity.duration.300ms class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Restoran <span class="text-red-500">*</span></label>
                                <input type="text" name="name" x-model="form.name" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Padang Banjir">
                                <p x-show="errors.name" x-text="errors.name" class="text-red-500 text-xs mt-1"></p>
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                <div class="relative w-full"
                                     @keydown.escape="if(selectOpen){ selectOpen=false; }"
                                     @keydown.down="if(selectOpen){ selectableItemActiveNext(); } else { selectOpen=true; } event.preventDefault();"
                                     @keydown.up="if(selectOpen){ selectableItemActivePrevious(); } else { selectOpen=true; } event.preventDefault();"
                                     @keydown.enter="if(selectOpen){ form.category=selectableItemActive.value; selectOpen=false; $refs.selectButton.focus(); event.preventDefault(); }"
                                     @keydown="selectKeydown($event);">
                                    
                                    {{-- Hidden Input for form submission --}}
                                    <input type="hidden" name="category" :value="form.category">

                                    {{-- Select Button --}}
                                    <button type="button" x-ref="selectButton" @click="selectOpen=!selectOpen"
                                        class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700 text-left flex items-center justify-between cursor-pointer focus:outline-none">
                                        <span x-text="form.category ? (selectableItems.find(i => i.value === form.category)?.title || 'Pilih Kategori') : 'Pilih Kategori'" class="truncate">Pilih Kategori</span>
                                        <span class="flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path></svg>
                                        </span>
                                    </button>

                                    {{-- Options List --}}
                                    <ul x-show="selectOpen"
                                        x-ref="selectableItemsList"
                                        @click.away="selectOpen = false"
                                        x-transition:enter="transition ease-out duration-50"
                                        x-transition:enter-start="opacity-0 -translate-y-1"
                                        x-transition:enter-end="opacity-100"
                                        :class="{ 'bottom-0 mb-14' : selectDropdownPosition == 'top', 'top-0 mt-14' : selectDropdownPosition == 'bottom' }"
                                        class="absolute z-30 w-full py-1 mt-1 overflow-auto text-sm bg-white rounded-xl shadow-lg border border-gray-100 max-h-56 focus:outline-none"
                                        x-cloak>

                                        <template x-for="item in selectableItems" :key="item.value">
                                            <li 
                                                @click="form.category=item.value; selectOpen=false; $refs.selectButton.focus();"
                                                :id="item.value + '-' + selectId"
                                                :data-disabled="item.disabled"
                                                :class="{ 'bg-emerald-500 text-white' : form.category == item.value, 'bg-gray-100 text-gray-900' : (selectableItemIsActive(item) && form.category != item.value), 'text-gray-700 hover:bg-gray-50' : (!selectableItemIsActive(item) && form.category != item.value) }"
                                                @mousemove="selectableItemActive=item"
                                                class="relative flex items-center h-full py-2.5 pl-8 pr-4 cursor-pointer select-none rounded-lg mx-1 my-0.5 transition-colors">
                                                <svg x-show="form.category == item.value" class="absolute left-2 w-4 h-4 stroke-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                <span class="block font-semibold truncate" x-text="item.title"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <p x-show="errors.category" x-text="errors.category" class="text-red-500 text-xs mt-1"></p>
                                @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Jenis Makanan <span class="text-red-500">*</span></label>
                                <input type="text" name="food_type" x-model="form.food_type" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Nasi, Mie, Ayam, Sapi, dll">
                                <p x-show="errors.food_type" x-text="errors.food_type" class="text-red-500 text-xs mt-1"></p>
                                @error('food_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Foto Restoran  --}}
                            <div>
                                <span class="block text-sm font-bold text-gray-700 mb-1">Foto Restoran <span class="text-red-500">*</span></span>
                                
                                {{-- Preview --}}
                                <template x-if="photoPreview">
                                    <div class="relative inline-block mb-2">
                                        <img :src="photoPreview" class="w-full h-40 object-cover rounded-2xl border border-gray-200">
                                        <button type="button" @click="removePhoto()" 
                                                class="absolute top-2 right-2 w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-md transition-colors border-none cursor-pointer">
                                            ✕
                                        </button>
                                    </div>
                                </template>

                                {{-- Upload Area --}}
                                <label x-show="!photoPreview" for="file-upload" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-emerald-400 border-dashed rounded-2xl bg-white hover:bg-emerald-50 transition-colors cursor-pointer group">
                                    <div class="space-y-2 text-center flex flex-col items-center">
                                        <svg class="h-8 w-8 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm text-emerald-600 font-bold">Seret foto ke sini atau klik</p>
                                        <p class="text-xs text-gray-500 font-medium">Maks 5MB (JPG/PNG)</p>
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold text-emerald-600 border border-emerald-500">
                                            Pilih File
                                        </span>
                                    </div>
                                </label>
                                <input id="file-upload" name="photo" type="file" accept="image/jpg,image/jpeg,image/png" class="sr-only" @change="handlePhoto($event)">
                                <p x-show="errors.photo" x-text="errors.photo" class="text-red-500 text-xs mt-1"></p>
                                @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="description" rows="3" x-model="form.description" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700 resize-none" placeholder="Restoran cukup kecil...."></textarea>
                                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex justify-between items-center pt-4">
                                <a href="{{ route('home') }}" class="text-gray-600 font-bold text-sm px-4 py-2 hover:text-gray-800">
                                    Batal
                                </a>
                                <button type="button" @click="nextStep(1)" class="bg-emerald-500 text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-emerald-600 transition-colors shadow-sm">
                                    Lanjut
                                </button>
                            </div>
                        </div>

                        <!-- STEP 2: Detail & Lokasi -->
                        <div x-show="step === 2" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="address" x-model="form.address" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Jl Padang Banjir">
                                <p x-show="errors.address" x-text="errors.address" class="text-red-500 text-xs mt-1"></p>
                                @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Jam Buka --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Jam Buka <span class="text-red-500">*</span></label>
                                <div class="flex items-center gap-1 sm:gap-2">
                                    {{-- Open Time --}}
                                    <div class="flex-1">
                                        <input 
                                            type="time" 
                                            x-model="form.open_time" 
                                            class="hidden sm:block min-w-0 w-full bg-gray-50 border-0 rounded-xl px-4 py-3 text-sm sm:text-base focus:ring-2 focus:ring-emerald-500 text-gray-700"
                                        >
                                        <select 
                                            x-model="form.open_time" 
                                            class="block sm:hidden min-w-0 w-full bg-gray-50 border-0 rounded-lg px-2 py-2 text-sm focus:ring-2 focus:ring-emerald-500 text-gray-700"
                                        >
                                            <option value="">Jam Buka</option>
                                            <template x-for="time in timeOptions" :key="time">
                                                <option :value="time" x-text="time"></option>
                                            </template>
                                        </select>
                                    </div>

                                    <span class="text-gray-400 font-bold text-sm sm:text-base">—</span>

                                    {{-- Close Time --}}
                                    <div class="flex-1">
                                        <input 
                                            type="time" 
                                            x-model="form.close_time" 
                                            class="hidden sm:block min-w-0 w-full bg-gray-50 border-0 rounded-xl px-4 py-3 text-sm sm:text-base focus:ring-2 focus:ring-emerald-500 text-gray-700"
                                        >
                                        <select 
                                            x-model="form.close_time" 
                                            class="block sm:hidden min-w-0 w-full bg-gray-50 border-0 rounded-lg px-2 py-2 text-sm focus:ring-2 focus:ring-emerald-500 text-gray-700"
                                        >
                                            <option value="">Jam Tutup</option>
                                            <template x-for="time in timeOptions" :key="time">
                                                <option :value="time" x-text="time"></option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="open_hours" :value="form.open_time && form.close_time ? form.open_time + ' - ' + form.close_time : ''">
                                <p x-show="errors.open_hours" x-text="errors.open_hours" class="text-red-500 text-xs mt-1"></p>
                                @error('open_hours')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Range Harga --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Range Harga <span class="text-red-500">*</span></label>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-semibold">Rp</span>
                                        <input type="number" x-model="form.price_min" min="0" step="1000" class="w-full bg-gray-50 border-0 rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="10000">
                                    </div>
                                    <span class="text-gray-400 font-bold">—</span>
                                    <div class="flex-1 relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-semibold">Rp</span>
                                        <input type="number" x-model="form.price_max" min="0" step="1000" class="w-full bg-gray-50 border-0 rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="30000">
                                    </div>
                                </div>
                                <input type="hidden" name="price_range" :value="form.price_min && form.price_max ? 'Rp ' + Number(form.price_min).toLocaleString('id-ID') + ' - Rp ' + Number(form.price_max).toLocaleString('id-ID') : ''">
                                <p x-show="errors.price_range" x-text="errors.price_range" class="text-red-500 text-xs mt-1"></p>
                                @error('price_range')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Link Google Maps <span class="text-red-500">*</span></label>
                                <input type="url" name="gmaps_link" x-model="form.gmaps_link" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="https://maps.app.goo.gl/...">
                                <p x-show="errors.gmaps_link" x-text="errors.gmaps_link" class="text-red-500 text-xs mt-1"></p>
                                @error('gmaps_link')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Patokan</label>
                                <input type="text" name="landmark" x-model="form.landmark" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Depan indomaret...">
                                @error('landmark')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Foto Patokan --}}
                            <div>
                                <span class="block text-sm font-bold text-gray-700 mb-1">Foto Patokan <span class="text-red-500">*</span></span>

                                {{-- Preview --}}
                                <template x-if="landmarkPreview">
                                    <div class="relative inline-block mb-2">
                                        <img :src="landmarkPreview" class="w-full h-40 object-cover rounded-2xl border border-gray-200">
                                        <button type="button" @click="removeLandmark()" 
                                                class="absolute top-2 right-2 w-7 h-7 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-md transition-colors border-none cursor-pointer">
                                            ✕
                                        </button>
                                    </div>
                                </template>

                                {{-- Upload Area --}}
                                <label x-show="!landmarkPreview" for="landmark-upload" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-emerald-400 border-dashed rounded-2xl bg-white hover:bg-emerald-50 transition-colors cursor-pointer group">
                                    <div class="space-y-2 text-center flex flex-col items-center">
                                        <svg class="h-8 w-8 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm text-emerald-600 font-bold">Seret foto ke sini atau klik</p>
                                        <p class="text-xs text-gray-500 font-medium">Maks 5MB (JPG/PNG)</p>
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold text-emerald-600 border border-emerald-500">
                                            Pilih File
                                        </span>
                                    </div>
                                </label>
                                <input id="landmark-upload" name="landmark_photo" type="file" accept="image/jpg,image/jpeg,image/png" class="sr-only" @change="handleLandmark($event)">
                                <p x-show="errors.landmark_photo" x-text="errors.landmark_photo" class="text-red-500 text-xs mt-1"></p>
                                @error('landmark_photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex justify-between items-center pt-4">
                                <button type="button" @click="step = 1" class="text-gray-600 font-bold text-sm px-4 py-2 hover:text-gray-800 bg-transparent border-none cursor-pointer">
                                    Kembali
                                </button>
                                <button type="button" @click="nextStep(2)" class="bg-emerald-500 text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-emerald-600 transition-colors shadow-sm">
                                    Lanjut
                                </button>
                            </div>
                        </div>

                        <!-- STEP 3: Review -->
                        <div x-show="step === 3" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Rating <span class="text-red-500">*</span></label>
                                <input type="hidden" name="initial_rating" :value="form.rating">
                                <div class="flex justify-center gap-2">
                                    <template x-for="i in 5" :key="i">
                                        <svg @click="form.rating = i" 
                                             class="w-8 h-8 cursor-pointer transition-colors" 
                                             :class="i <= form.rating ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-300'"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </template>
                                </div>
                                <p x-show="errors.rating" x-text="errors.rating" class="text-red-500 text-xs mt-1 text-center"></p>
                                @error('initial_rating')<p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Review</label>
                                <textarea name="initial_review" rows="4" x-model="form.review" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700 resize-none" placeholder="Pelayanannya bagus, makanannya enak"></textarea>
                                @error('initial_review')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Foto Review --}}
                            <div>
                                <span class="block text-sm font-bold text-gray-700 mb-1">Foto Tambahan <span class="text-gray-400 font-normal">(maks 5)</span></span>

                                {{-- Preview Grid  --}}
                                <div class="flex gap-2 mb-3 flex-wrap" x-show="reviewPreviews.length > 0">
                                    <template x-for="(preview, idx) in reviewPreviews" :key="idx">
                                        <div class="relative">
                                            <img :src="preview" class="w-20 h-20 object-cover rounded-xl border border-gray-200">
                                            <button type="button" @click="removeReviewPhoto(idx)"
                                                    class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center text-[10px] font-bold shadow-md transition-colors border-none cursor-pointer">
                                                ✕
                                            </button>
                                        </div>
                                    </template>

                                    <label x-show="reviewPreviews.length > 0 && reviewPreviews.length < 5" 
                                           for="review-upload" 
                                           class="w-20 h-20 rounded-xl border-2 border-emerald-400 border-dashed bg-white hover:bg-emerald-50 flex flex-col items-center justify-center cursor-pointer transition-colors group">
                                        <svg class="h-6 w-6 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span class="text-[8px] text-emerald-600 font-bold mt-0.5">Tambah</span>
                                    </label>
                                </div>

                                {{-- Large Upload Area --}}
                                <label x-show="reviewPreviews.length === 0" for="review-upload" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-emerald-400 border-dashed rounded-2xl bg-white hover:bg-emerald-50 transition-colors cursor-pointer group">
                                    <div class="space-y-2 text-center flex flex-col items-center">
                                        <svg class="h-8 w-8 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm text-emerald-600 font-bold">Seret foto ke sini atau klik</p>
                                        <p class="text-xs text-gray-500 font-medium">Maks 5MB per file (JPG/PNG)</p>
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold text-emerald-600 border border-emerald-500">
                                            Pilih File
                                        </span>
                                    </div>
                                </label>

                                <input id="review-upload" name="initial_review_photos[]" type="file" accept="image/jpg,image/jpeg,image/png" class="sr-only" multiple @change="handleReviewPhotos($event)">
                                @error('initial_review_photos')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                @error('initial_review_photos.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex justify-between items-center pt-4">
                                <button type="button" @click="step = 2" class="text-gray-600 font-bold text-sm px-4 py-2 hover:text-gray-800 bg-transparent border-none cursor-pointer">
                                    Kembali
                                </button>
                                <button type="button" @click="submitForm()" class="bg-emerald-500 text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-emerald-600 transition-colors shadow-sm">
                                    Kirim
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            
        </div>
    </div>

<script>
function submitPlaceForm() {
    return {
        step: 1,
        photoPreview: null,
        landmarkPreview: null,
        reviewPreviews: [],
        reviewFiles: [],
        errors: {},
        timeOptions: [],
        selectOpen: false,
        selectableItems: [
            { title: 'Makanan Berat', value: 'makanan_berat', disabled: false },
            { title: 'Jajanan', value: 'jajanan', disabled: false },
            { title: 'Minuman', value: 'minuman', disabled: false }
        ],
        selectableItemActive: null,
        selectId: 'category-select',
        selectKeydownValue: '',
        selectKeydownTimeout: 1000,
        selectKeydownClearTimeout: null,
        selectDropdownPosition: 'bottom',

        form: {
            name: '{{ old("name", "") }}',
            category: '{{ old("category", "") }}',
            food_type: '{{ old("food_type", "") }}',
            description: '{{ old("description", "") }}',
            address: '{{ old("address", "") }}',
            open_time: '{{ old("open_time", "") }}',
            close_time: '{{ old("close_time", "") }}',
            price_min: '{{ old("price_min", "") }}',
            price_max: '{{ old("price_max", "") }}',
            gmaps_link: '{{ old("gmaps_link", "") }}',
            landmark: '{{ old("landmark", "") }}',
            rating: {{ old('initial_rating', 0) }},
            review: '{{ old("initial_review", "") }}',
        },

        // Photo Handlers
        handlePhoto(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => this.photoPreview = ev.target.result;
            reader.readAsDataURL(file);
        },
        removePhoto() {
            this.photoPreview = null;
            document.getElementById('file-upload').value = '';
        },

        handleLandmark(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => this.landmarkPreview = ev.target.result;
            reader.readAsDataURL(file);
        },
        removeLandmark() {
            this.landmarkPreview = null;
            document.getElementById('landmark-upload').value = '';
        },

        handleReviewPhotos(e) {
            const files = Array.from(e.target.files);
            const remaining = 5 - this.reviewPreviews.length;
            const toAdd = files.slice(0, remaining);

            toAdd.forEach(file => {
                this.reviewFiles.push(file);
                const reader = new FileReader();
                reader.onload = (ev) => this.reviewPreviews.push(ev.target.result);
                reader.readAsDataURL(file);
            });

            // Rebuild file input
            this.syncReviewFileInput();
        },
        removeReviewPhoto(idx) {
            this.reviewPreviews.splice(idx, 1);
            this.reviewFiles.splice(idx, 1);
            this.syncReviewFileInput();
        },
        syncReviewFileInput() {
            const dt = new DataTransfer();
            this.reviewFiles.forEach(f => dt.items.add(f));
            document.getElementById('review-upload').files = dt.files;
        },

        // Validation
        validateStep(stepNum) {
            this.errors = {};
            let valid = true;

            if (stepNum === 1) {
                if (!this.form.name.trim()) { this.errors.name = 'Nama restoran wajib diisi'; valid = false; }
                if (!this.form.category) { this.errors.category = 'Kategori wajib dipilih'; valid = false; }
                if (!this.form.food_type.trim()) { this.errors.food_type = 'Jenis makanan wajib diisi'; valid = false; }
                if (!this.photoPreview) { this.errors.photo = 'Foto restoran wajib diupload'; valid = false; }
            }

            if (stepNum === 2) {
                if (!this.form.address.trim()) { this.errors.address = 'Alamat wajib diisi'; valid = false; }
                if (!this.form.open_time || !this.form.close_time) { this.errors.open_hours = 'Jam buka dan tutup wajib diisi'; valid = false; }
                if (!this.form.price_min || !this.form.price_max) { this.errors.price_range = 'Range harga wajib diisi'; valid = false; }
                if (!this.form.gmaps_link.trim()) { this.errors.gmaps_link = 'Link Google Maps wajib diisi'; valid = false; }
                if (!this.landmarkPreview) { this.errors.landmark_photo = 'Foto patokan wajib diupload'; valid = false; }
            }

            if (stepNum === 3) {
                if (this.form.rating < 1) { this.errors.rating = 'Rating wajib dipilih'; valid = false; }
            }

            return valid;
        },

        nextStep(currentStep) {
            if (this.validateStep(currentStep)) {
                this.step = currentStep + 1;
            }
        },

        submitForm() {
            if (this.validateStep(3)) {
                this.$refs.submitForm.submit();
            }
        },

        init() {
            // Generate timeOptions (every 15 minutes)
            this.timeOptions = [];
            for (let hour = 0; hour < 24; hour++) {
                const hourStr = String(hour).padStart(2, '0');
                for (let minute = 0; minute < 60; minute += 15) {
                    const minuteStr = String(minute).padStart(2, '0');
                    this.timeOptions.push(`${hourStr}:${minuteStr}`);
                }
            }

            this.$watch('step', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            this.$watch('selectOpen', (value) => {
                if (value) {
                    const currentItem = this.selectableItems.find(i => i.value === this.form.category);
                    this.selectableItemActive = currentItem || this.selectableItems[0];
                    setTimeout(() => {
                        this.selectScrollToActiveItem();
                    }, 10);
                    this.selectPositionUpdate();
                }
            });
            window.addEventListener('resize', () => { this.selectPositionUpdate(); });
        },

        selectableItemIsActive(item) {
            return this.selectableItemActive && this.selectableItemActive.value == item.value;
        },

        selectableItemActiveNext() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index < this.selectableItems.length - 1) {
                this.selectableItemActive = this.selectableItems[index + 1];
                this.selectScrollToActiveItem();
            }
        },

        selectableItemActivePrevious() {
            let index = this.selectableItems.indexOf(this.selectableItemActive);
            if (index > 0) {
                this.selectableItemActive = this.selectableItems[index - 1];
                this.selectScrollToActiveItem();
            }
        },

        selectScrollToActiveItem() {
            if (this.selectableItemActive && this.$refs.selectableItemsList) {
                const activeElement = document.getElementById(this.selectableItemActive.value + '-' + this.selectId);
                if (activeElement) {
                    const newScrollPos = (activeElement.offsetTop + activeElement.offsetHeight) - this.$refs.selectableItemsList.offsetHeight;
                    this.$refs.selectableItemsList.scrollTop = newScrollPos > 0 ? newScrollPos : 0;
                }
            }
        },

        selectKeydown(event) {
            if (event.keyCode >= 65 && event.keyCode <= 90) {
                this.selectKeydownValue += event.key;
                const selectedItemBestMatch = this.selectItemsFindBestMatch();
                if (selectedItemBestMatch) {
                    if (this.selectOpen) {
                        this.selectableItemActive = selectedItemBestMatch;
                        this.selectScrollToActiveItem();
                    } else {
                        this.form.category = selectedItemBestMatch.value;
                        this.selectableItemActive = selectedItemBestMatch;
                    }
                }
                if (this.selectKeydownValue != '') {
                    clearTimeout(this.selectKeydownClearTimeout);
                    this.selectKeydownClearTimeout = setTimeout(() => {
                        this.selectKeydownValue = '';
                    }, this.selectKeydownTimeout);
                }
            }
        },

        selectItemsFindBestMatch() {
            const typedValue = this.selectKeydownValue.toLowerCase();
            let bestMatch = null;
            let bestMatchIndex = -1;
            for (let i = 0; i < this.selectableItems.length; i++) {
                const title = this.selectableItems[i].title.toLowerCase();
                const index = title.indexOf(typedValue);
                if (index > -1 && (bestMatchIndex == -1 || index < bestMatchIndex) && !this.selectableItems[i].disabled) {
                    bestMatch = this.selectableItems[i];
                    bestMatchIndex = index;
                }
            }
            return bestMatch;
        },

        selectPositionUpdate() {
            if (this.$refs.selectButton && this.$refs.selectableItemsList) {
                const selectDropdownBottomPos = this.$refs.selectButton.getBoundingClientRect().top + this.$refs.selectButton.offsetHeight + parseInt(window.getComputedStyle(this.$refs.selectableItemsList).maxHeight || '224');
                if (window.innerHeight < selectDropdownBottomPos) {
                    this.selectDropdownPosition = 'top';
                } else {
                    this.selectDropdownPosition = 'bottom';
                }
            }
        }
    }
}
</script>

@endsection
