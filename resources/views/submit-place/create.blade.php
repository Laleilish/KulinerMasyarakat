@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-[#FDF8F0] py-12 flex items-center justify-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex flex-col md:flex-row gap-8 items-center">
            
            <!-- Left Side Information -->
            <div class="w-full md:w-1/2 flex flex-col justify-center items-start md:pr-10">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-800 mb-2 tracking-tight">
                    Punya Info
                </h1>
                <div class="bg-white inline-block px-4 py-2 md:px-6 md:py-3 rounded-2xl shadow-sm mb-6">
                    <span class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#9e1c1f]">Hidden Gem?</span>
                </div>
                <p class="text-gray-500 text-base md:text-lg lg:text-xl max-w-md leading-relaxed">
                    Bantu yang lain nemuin tempat makan enak, porsi kuli, dan ramah di kantong akhir bulan
                </p>
            </div>

            <!-- Right Side Form -->
            <div class="w-full md:w-1/2 flex justify-center mt-8 md:mt-0">
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] w-full max-w-md p-6 md:p-8" 
                     x-data="{ step: 1 }">
                    
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

                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- STEP 1 -->
                        <div x-show="step === 1" x-transition.opacity.duration.300ms class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Restoran <span class="text-red-500">*</span></label>
                                <input type="text" name="name" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Padang Banjir">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="category" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700">
                                    <option value="">Pilih Kategori</option>
                                    <option value="makanan_berat">Makanan Berat</option>
                                    <option value="jajanan">Jajanan</option>
                                    <option value="minuman">Minuman</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Jenis Makanan</label>
                                <input type="text" name="food_type" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Nasi, Mie, Ayam, Sapi, dll">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Foto Restoran <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-emerald-400 border-dashed rounded-2xl bg-white hover:bg-emerald-50 transition-colors cursor-pointer group">
                                    <div class="space-y-2 text-center flex flex-col items-center">
                                        <svg class="h-8 w-8 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div class="text-sm text-gray-600 font-medium">
                                            <label for="file-upload" class="relative cursor-pointer rounded-md font-bold text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                <span>Seret foto ke sini atau klik</span>
                                                <input id="file-upload" name="restaurant_photo" type="file" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500 font-medium">Maks 5MB (JPG/PNG)</p>
                                        <div class="mt-2">
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold text-emerald-600 border border-emerald-500">
                                                Pilih File
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
                                <textarea name="description" rows="3" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700 resize-none" placeholder="Restoran cukup kecil...."></textarea>
                            </div>

                            <div class="flex justify-between items-center pt-4">
                                <button type="button" class="text-gray-600 font-bold text-sm px-4 py-2 hover:text-gray-800">
                                    Batal
                                </button>
                                <button type="button" @click="step = 2" class="bg-emerald-500 text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-emerald-600 transition-colors shadow-sm">
                                    Lanjut
                                </button>
                            </div>
                        </div>

                        <!-- STEP 2 -->
                        <div x-show="step === 2" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="address" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Jl Padang Banjir">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Jam Buka</label>
                                <input type="text" name="opening_hours" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="9.30-15.00">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Range Harga</label>
                                <input type="text" name="price_range" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="15.000 - 30.000">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Link Google Maps <span class="text-red-500">*</span></label>
                                <input type="url" name="maps_link" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="link">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Patokan</label>
                                <input type="text" name="landmark" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Depan indomaret...">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Foto Patokan <span class="text-red-500">*</span></label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-emerald-400 border-dashed rounded-2xl bg-white hover:bg-emerald-50 transition-colors cursor-pointer group">
                                    <div class="space-y-2 text-center flex flex-col items-center">
                                        <svg class="h-8 w-8 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div class="text-sm text-gray-600 font-medium">
                                            <label for="landmark-upload" class="relative cursor-pointer rounded-md font-bold text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                <span>Seret foto ke sini atau klik</span>
                                                <input id="landmark-upload" name="landmark_photo" type="file" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500 font-medium">Maks 5MB (JPG/PNG)</p>
                                        <div class="mt-2">
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold text-emerald-600 border border-emerald-500">
                                                Pilih File
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-4">
                                <button type="button" @click="step = 1" class="text-gray-600 font-bold text-sm px-4 py-2 hover:text-gray-800">
                                    Kembali
                                </button>
                                <button type="button" @click="step = 3" class="bg-emerald-500 text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-emerald-600 transition-colors shadow-sm">
                                    Lanjut
                                </button>
                            </div>
                        </div>

                        <!-- STEP 3 -->
                        <div x-show="step === 3" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Rating <span class="text-red-500">*</span></label>
                                <div class="flex justify-center gap-2 text-gray-300">
                                    <template x-for="i in 5">
                                        <svg class="w-8 h-8 cursor-pointer hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </template>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Review</label>
                                <textarea name="review" rows="4" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700 resize-none" placeholder="Pelayanannya bagus, makanannya enak"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Foto Tambahan</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-emerald-400 border-dashed rounded-2xl bg-white hover:bg-emerald-50 transition-colors cursor-pointer group">
                                    <div class="space-y-2 text-center flex flex-col items-center">
                                        <svg class="h-8 w-8 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div class="text-sm text-gray-600 font-medium">
                                            <label for="extra-upload" class="relative cursor-pointer rounded-md font-bold text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                <span>Seret foto ke sini atau klik</span>
                                                <input id="extra-upload" name="extra_photo" type="file" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500 font-medium">Maks 5MB (JPG/PNG)</p>
                                        <div class="mt-2">
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold text-emerald-600 border border-emerald-500">
                                                Pilih File
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-4">
                                <button type="button" @click="step = 2" class="text-gray-600 font-bold text-sm px-4 py-2 hover:text-gray-800">
                                    Kembali
                                </button>
                                <button type="submit" class="bg-emerald-500 text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-emerald-600 transition-colors shadow-sm">
                                    Kirim
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            
        </div>
    </div>
@endsection
