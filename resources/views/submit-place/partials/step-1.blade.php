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
                                        <p class="text-xs text-gray-500 font-medium">Maks 2MB (JPG/PNG)</p>
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
