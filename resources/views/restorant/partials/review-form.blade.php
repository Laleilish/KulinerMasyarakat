<div x-show="showForm" x-collapse class="mb-6">
    <form action="{{ route('reviews.store', $restaurant->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6"
          x-data="{
              rating: {{ old('rating', 0) }},
              reviewPreviews: [],
              handleReviewPhotos(e) {
                  const files = e.target.files;
                  this.reviewPreviews = [];
                  for (let i = 0; i < files.length && i < 5; i++) {
                      const reader = new FileReader();
                      reader.onload = (ev) => this.reviewPreviews.push(ev.target.result);
                      reader.readAsDataURL(files[i]);
                  }
              }
          }">
        @csrf

        {{-- Rating --}}
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-800 mb-2">Rating <span class="text-red-500">*</span></label>
            <input type="hidden" name="rating" :value="rating">
            <div class="flex items-center justify-center gap-2">
                <template x-for="i in 5">
                    <button type="button" @click="rating = i" class="focus:outline-none transition-transform hover:scale-110">
                        <svg class="w-8 h-8" :class="i <= rating ? 'text-yellow-400 fill-yellow-400' : 'text-gray-200 fill-gray-200'" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </button>
                </template>
            </div>
        </div>

        {{-- Komentar --}}
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-800 mb-2">Komentar</label>
            <textarea name="comment" rows="3"
                      class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 focus:ring-2 focus:ring-[#00A896] text-sm resize-none"
                      placeholder="Ceritain pengalamanmu makan di sini... ">{{ old('comment') }}</textarea>
        </div>

        {{-- Foto --}}
        <div class="mb-5">
            <span class="block text-sm font-bold text-gray-800 mb-2">Foto (Opsional, maks 5)</span>
            <label class="inline-flex w-48 justify-center px-4 pt-4 pb-5 border-2 border-teal-100 border-dashed rounded-xl bg-gray-50 hover:bg-teal-50/50 transition-colors cursor-pointer group">
                <div class="space-y-1 text-center flex flex-col items-center">
                    <svg class="h-6 w-6 text-teal-400 group-hover:text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-xs text-teal-600 font-bold" x-text="reviewPreviews.length ? reviewPreviews.length + ' foto dipilih' : 'Upload Foto'"></p>
                    <input name="photos[]" type="file" accept="image/jpg,image/jpeg,image/png" class="sr-only" multiple
                           @change="handleReviewPhotos($event)">
                </div>
            </label>

            {{-- Preview Grid --}}
            <div class="flex gap-2 mt-3 flex-wrap" x-show="reviewPreviews.length > 0">
                <template x-for="(src, idx) in reviewPreviews" :key="idx">
                    <div class="relative">
                        <img :src="src" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                    </div>
                </template>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-[#00A896] text-white font-bold text-sm px-6 py-2.5 rounded-full hover:bg-[#028c7d] transition-colors shadow-sm">
                Kirim Ulasan
            </button>
        </div>
    </form>
</div>
