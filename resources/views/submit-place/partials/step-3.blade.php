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
                                           @dragover.prevent="$el.classList.add('bg-emerald-50')" 
                                           @dragleave.prevent="$el.classList.remove('bg-emerald-50')" 
                                           @drop.prevent="$el.classList.remove('bg-emerald-50'); handleReviewPhotos($event)"
                                           class="w-20 h-20 rounded-xl border-2 border-emerald-400 border-dashed bg-white hover:bg-emerald-50 flex flex-col items-center justify-center cursor-pointer transition-colors group">
                                        <svg class="h-6 w-6 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span class="text-[8px] text-emerald-600 font-bold mt-0.5">Tambah</span>
                                    </label>
                                </div>

                                {{-- Large Upload Area --}}
                                <label x-show="reviewPreviews.length === 0" 
                                       for="review-upload" 
                                       @dragover.prevent="$el.classList.add('bg-emerald-50')" 
                                       @dragleave.prevent="$el.classList.remove('bg-emerald-50')" 
                                       @drop.prevent="$el.classList.remove('bg-emerald-50'); handleReviewPhotos($event)"
                                       class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-emerald-400 border-dashed rounded-2xl bg-white hover:bg-emerald-50 transition-colors cursor-pointer group">
                                    <div class="space-y-2 text-center flex flex-col items-center">
                                        <svg class="h-8 w-8 text-emerald-500 group-hover:text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-sm text-emerald-600 font-bold">Seret foto ke sini atau klik</p>
                                        <p class="text-xs text-gray-500 font-medium">Maks 2MB per file (JPG/PNG)</p>
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
                                <button type="button" @click="submitForm()" class="bg-emerald-500 text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-emerald-600 transition-colors shadow-sm border-none cursor-pointer">
                                    Kirim
                                </button>
                            </div>
                        </div>
