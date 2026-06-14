                        <!-- STEP 2: Detail & Lokasi -->
                        <div x-show="step === 2" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="address" x-model="form.address" maxlength="500" minlength="5" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Jl Padang Banjir">
                                <p x-show="errors.address" x-text="errors.address" class="text-red-500 text-xs mt-1"></p>
                                <p x-show="!errors.address && form.address.length > 0 && form.address.length < 5" class="text-amber-500 text-xs mt-1">Minimal 5 karakter</p>
                                <p x-show="!errors.address && form.address.length >= 500" class="text-red-500 text-xs mt-1 font-semibold">Maksimal karakter tercapai</p>
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
                                <input type="hidden" name="open_time" :value="form.open_time">
                                <input type="hidden" name="close_time" :value="form.close_time">
                                <p x-show="errors.open_hours" x-text="errors.open_hours" class="text-red-500 text-xs mt-1"></p>
                                @error('open_hours')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Range Harga --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Range Harga <span class="text-red-500">*</span></label>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-semibold">Rp</span>
                                        <input type="number" x-model="form.price_min" min="0" max="99999999" step="1000" class="w-full bg-gray-50 border-0 rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="10000">
                                    </div>
                                    <span class="text-gray-400 font-bold">—</span>
                                    <div class="flex-1 relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-semibold">Rp</span>
                                        <input type="number" x-model="form.price_max" min="0" max="99999999" step="1000" class="w-full bg-gray-50 border-0 rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="30000">
                                    </div>
                                </div>
                                <input type="hidden" name="price_range" :value="form.price_min && form.price_max ? 'Rp ' + Number(form.price_min).toLocaleString('id-ID') + ' - Rp ' + Number(form.price_max).toLocaleString('id-ID') : ''">
                                <input type="hidden" name="price_min" :value="form.price_min">
                                <input type="hidden" name="price_max" :value="form.price_max">
                                <p x-show="errors.price_range" x-text="errors.price_range" class="text-red-500 text-xs mt-1"></p>
                                @error('price_range')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Peta Lokasi --}}
                            <div class="mt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-sm font-bold text-gray-700">Peta Lokasi & Titik Koordinat</label>
                                    <button type="button" @click="detectLocation()" class="text-xs bg-[#F5A623] hover:bg-orange-500 text-white font-bold py-1.5 px-3 rounded-full transition-colors flex items-center gap-1 shadow-sm">
                                        <i class="fas fa-crosshairs"></i> Deteksi Lokasi
                                    </button>
                                </div>
                                
                                <div class="relative rounded-2xl overflow-hidden border-2 border-gray-100 shadow-sm mb-2" wire:ignore>
                                    {{-- Loading Overlay --}}
                                    <div x-show="isLocating" class="absolute inset-0 bg-white/80 backdrop-blur-sm z-[999] flex flex-col items-center justify-center transition-opacity duration-300" style="display: none;">
                                        <div class="w-8 h-8 rounded-full border-4 border-[#F5A623] border-t-transparent animate-spin mb-2"></div>
                                        <span class="text-xs font-bold text-gray-600">Mencari lokasi...</span>
                                    </div>
                                    
                                    <div class="relative">
                                        <div id="submit-map" class="w-full h-64 rounded-xl z-0"></div>
                                        <img 
                                            src="/assets/img/icon-loc.png" 
                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -100%); width: 28px; z-index: 1000; pointer-events: none;"
                                            alt="pin"
                                        >
                                    </div>
                                </div>

                                <div class="text-xs text-gray-500 mb-4 bg-gray-50 p-2.5 rounded-lg border border-gray-100 flex items-start gap-2">
                                    <i class="fas fa-info-circle text-[#F5A623] mt-0.5"></i>
                                    <p>Geser marker <i class="fas fa-map-marker-alt text-red-500 mx-0.5"></i> di peta untuk titik yang lebih akurat. Alamat dan link Maps akan otomatis terisi.</p>
                                </div>
                                
                                <input type="hidden" name="latitude" x-model="form.latitude">
                                <input type="hidden" name="longitude" x-model="form.longitude">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Link Maps <span class="text-red-500">*</span></label>
                                <input type="url" name="gmaps_link" x-model="form.gmaps_link" maxlength="2048" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="https://maps.app.goo.gl/...">
                                <p x-show="errors.gmaps_link" x-text="errors.gmaps_link" class="text-red-500 text-xs mt-1"></p>
                                <p x-show="!errors.gmaps_link && form.gmaps_link.length >= 2048" class="text-red-500 text-xs mt-1 font-semibold">Maksimal karakter tercapai</p>
                                @error('gmaps_link')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Patokan</label>
                                <input type="text" name="landmark" x-model="form.landmark" maxlength="255" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 text-gray-700" placeholder="Depan indomaret...">
                                <p x-show="form.landmark.length >= 255" class="text-red-500 text-xs mt-1 font-semibold">Maksimal karakter tercapai</p>
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
                                <label x-show="!landmarkPreview" 
                                       for="landmark-upload" 
                                       @dragover.prevent="$el.classList.add('bg-emerald-50')" 
                                       @dragleave.prevent="$el.classList.remove('bg-emerald-50')" 
                                       @drop.prevent="$el.classList.remove('bg-emerald-50'); handleLandmark($event)"
                                       class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-emerald-400 border-dashed rounded-2xl bg-white hover:bg-emerald-50 transition-colors cursor-pointer group">
                                    <div class="space-y-2 text-center flex flex-col items-center">
                                        <svg class="h-8 w-8 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm text-emerald-600 font-bold">Seret foto ke sini atau klik</p>
                                        <p class="text-xs text-gray-500 font-medium">Maks 2MB (JPG/PNG)</p>
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
