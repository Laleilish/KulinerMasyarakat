@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="editForm()">
    {{-- Back Link --}}
    <div>
        <a href="{{ route('admin.submit-places.show', $submitPlace) }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-emerald-600 transition-colors no-underline">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Detail Usulan
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 max-w-7xl">
        <div class="xl:col-span-7 bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Usulan Tempat</h2>
                    @if ($submitPlace->status === 'approved')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            Terbit
                        </span>
                    @elseif ($submitPlace->status === 'pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                            Pending
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                            Ditolak
                        </span>
                    @endif
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.submit-places.update', $submitPlace) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Foto Utama --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Utama</label>
                        <div class="flex items-start gap-4">
                            <div class="w-28 h-28 rounded-xl bg-gray-100 overflow-hidden shrink-0 border-2 border-dashed border-gray-200">
                                <img :src="previewPhoto" class="w-full h-full object-cover" x-show="previewPhoto">
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold" x-show="!previewPhoto">
                                    KMR
                                </div>
                            </div>
                            <div class="flex-1">
                                <label class="block w-full cursor-pointer">
                                    <input type="file" name="photo" accept="image/*" class="hidden" @change="handlePhotoChange($event)">
                                    <div class="px-4 py-3 border-2 border-dashed border-gray-200 rounded-xl text-center hover:border-blue-400 hover:bg-blue-50/30 transition-all">
                                        <svg class="w-6 h-6 mx-auto mb-1 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                        <p class="text-xs font-semibold text-gray-600">Klik untuk ganti foto</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">JPG, PNG, WEBP (maks. 2MB)</p>
                                    </div>
                                </label>
                                @error('photo')
                                    <p class="mt-2 text-xs text-rose-500 font-semibold">{{ $message }}</p>
                                @enderror
                                <button type="button" x-show="photoChanged" @click="resetPhoto()" class="mt-2 text-xs text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">
                                    ✕ Batalkan perubahan foto
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Nama Tempat --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Tempat</label>
                            <input type="text" name="name" id="name" x-model="name" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors">
                        </div>

                        {{-- Kampus --}}
                        <div>
                            <label for="campus_id" class="block text-sm font-semibold text-gray-700 mb-1">Kampus Terdekat</label>
                            <select name="campus_id" id="campus_id" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors">
                                <option value="">Pilih Kampus...</option>
                                @foreach ($campuses as $campus)
                                    <option value="{{ $campus->id }}" {{ old('campus_id', $submitPlace->campus_id) == $campus->id ? 'selected' : '' }}>
                                        {{ $campus->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label for="category" class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                            <select name="category" id="category" x-model="category" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors">
                                <option value="">Pilih Kategori...</option>
                                <option value="makanan_berat">Makanan Berat</option>
                                <option value="jajanan">Jajanan</option>
                                <option value="minuman">Minuman</option>
                            </select>
                        </div>

                        {{-- Tipe Makanan --}}
                        <div>
                            <label for="food_type" class="block text-sm font-semibold text-gray-700 mb-1">Tipe Makanan <span class="text-rose-500">*</span></label>
                            <input type="text" name="food_type" id="food_type" x-model="food_type" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors"
                                placeholder="Contoh: Nasi Goreng, Ayam Geprek">
                        </div>

                        {{-- Rentang Harga --}}
                        <div>
                            <label for="price_range" class="block text-sm font-semibold text-gray-700 mb-1">Rentang Harga <span class="text-rose-500">*</span></label>
                            <input type="text" name="price_range" id="price_range" x-model="price_range" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors"
                                placeholder="Contoh: Rp 15.000 - 30.000">
                        </div>

                        {{-- Jam Buka --}}
                        <div>
                            <label for="open_hours" class="block text-sm font-semibold text-gray-700 mb-1">Jam Buka <span class="text-rose-500">*</span></label>
                            <input type="text" name="open_hours" id="open_hours" x-model="open_hours" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors"
                                placeholder="Contoh: 08:00 - 22:00">
                        </div>

                        {{-- Patokan (Landmark) --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="landmark" class="block text-sm font-semibold text-gray-700 mb-1">Patokan (Landmark)</label>
                            <input type="text" name="landmark" id="landmark" x-model="landmark"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors"
                                placeholder="Samping minimarket...">
                        </div>
                        
                        {{-- Foto Patokan --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Patokan (Opsional)</label>
                            <div class="flex items-start gap-4">
                                <div class="w-20 h-20 rounded-xl bg-gray-100 overflow-hidden shrink-0 border-2 border-dashed border-gray-200">
                                    <img :src="previewLandmarkPhoto" class="w-full h-full object-cover" x-show="previewLandmarkPhoto">
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-[10px] font-bold" x-show="!previewLandmarkPhoto">
                                        KOSONG
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label class="block w-full cursor-pointer">
                                        <input type="file" name="landmark_photo" accept="image/*" class="hidden" @change="handleLandmarkPhotoChange($event)">
                                        <div class="px-4 py-4 border-2 border-dashed border-gray-200 rounded-xl text-center hover:border-orange/50 hover:bg-orange/5 transition-all">
                                            <svg class="w-5 h-5 mx-auto mb-1 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                            <p class="text-xs font-semibold text-gray-600">Klik untuk pilih foto patokan</p>
                                        </div>
                                    </label>
                                    <button type="button" x-show="landmarkPhotoChanged" @click="resetLandmarkPhoto()" class="mt-2 text-xs text-rose-500 hover:text-rose-700 font-semibold cursor-pointer">
                                        ✕ Batalkan perubahan
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" id="description" rows="3" required x-model="description"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors"></textarea>
                        </div>

                        {{-- Alamat Lengkap --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="address" id="address" rows="2" required x-model="address"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors"></textarea>
                        </div>

                        {{-- Link Google Maps --}}
                        <div class="col-span-1 md:col-span-2">
                            <label for="gmaps_link" class="block text-sm font-semibold text-gray-700 mb-1">Link Google Maps <span class="text-rose-500">*</span></label>
                            <input type="url" name="gmaps_link" id="gmaps_link" value="{{ old('gmaps_link', $submitPlace->gmaps_link) }}" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors">
                        </div>

                        {{-- Latitude --}}
                        <div>
                            <label for="latitude" class="block text-sm font-semibold text-gray-700 mb-1">Latitude</label>
                            <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $submitPlace->latitude) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors">
                        </div>

                        {{-- Longitude --}}
                        <div>
                            <label for="longitude" class="block text-sm font-semibold text-gray-700 mb-1">Longitude</label>
                            <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $submitPlace->longitude) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange/20 focus:border-orange transition-colors">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex flex-wrap justify-end gap-3">
                        <a href="{{ route('admin.submit-places.show', $submitPlace) }}"
                           class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-xl transition-all shadow-sm shrink-0 cursor-pointer text-center no-underline">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 bg-orange hover:bg-orange/90 text-white font-bold text-sm rounded-xl transition-all shadow-sm hover:shadow shrink-0 cursor-pointer border-none">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @include('admin.submit-places.partials.live-preview')

    </div>
</div>

<script>
function editForm() {
    return {
        name: @js(old('name', $submitPlace->name)),
        category: @js(old('category', $submitPlace->category)),
        food_type: @js(old('food_type', $submitPlace->food_type)),
        description: @js(old('description', $submitPlace->description)),
        address: @js(old('address', $submitPlace->address)),
        open_hours: @js(old('open_hours', $submitPlace->open_hours)),
        price_range: @js(old('price_range', $submitPlace->price_range)),
        landmark: @js(old('landmark', $submitPlace->landmark)),
        previewPhoto: @js($submitPlace->photo ? Storage::url($submitPlace->photo) : null),
        originalPhoto: @js($submitPlace->photo ? Storage::url($submitPlace->photo) : null),
        photoChanged: false,

        previewLandmarkPhoto: @js($submitPlace->landmark_photo ? Storage::url($submitPlace->landmark_photo) : null),
        originalLandmarkPhoto: @js($submitPlace->landmark_photo ? Storage::url($submitPlace->landmark_photo) : null),
        landmarkPhotoChanged: false,

        handlePhotoChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.previewPhoto = URL.createObjectURL(file);
                this.photoChanged = true;
            }
        },

        resetPhoto() {
            this.previewPhoto = this.originalPhoto;
            this.photoChanged = false;
            // Clear the file input
            const input = document.querySelector('input[name="photo"]');
            if (input) input.value = '';
        },

        handleLandmarkPhotoChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.previewLandmarkPhoto = URL.createObjectURL(file);
                this.landmarkPhotoChanged = true;
            }
        },

        resetLandmarkPhoto() {
            this.previewLandmarkPhoto = this.originalLandmarkPhoto;
            this.landmarkPhotoChanged = false;
            const input = document.querySelector('input[name="landmark_photo"]');
            if (input) input.value = '';
        }
    }
}
</script>
@endsection
