<div class="bg-white rounded-3xl border border-gray-100 p-5 shadow-sm">
    <div class="flex justify-between items-start mb-3">
        {{-- Avatar & Info User --}}
        <div class="flex items-center gap-3">
            @if($review->user->avatar)
                <img src="{{ $review->user->avatar }}"
                     alt="{{ $review->user->name }}"
                     class="w-12 h-12 rounded-full object-cover">
            @else
                <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 text-sm font-bold">
                    {{ strtoupper(substr($review->user->name, 0, 2)) }}
                </div>
            @endif
            <div>
                <p class="text-sm font-bold text-gray-800">{{ $review->user->name }}</p>
                <div class="flex gap-0.5 mt-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-yellow-400 text-yellow-400' : 'fill-gray-200 text-gray-200' }}" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Waktu & Tombol Hapus --}}
        <div class="flex flex-col items-end gap-1">
            <span class="text-[11px] text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
            @auth
                @if(Auth::id() === $review->user_id || Auth::user()->isAdmin())
                    <button type="button"
                            @click="$dispatch('open-delete-modal', { url: '{{ route('reviews.destroy', $review->id) }}' })"
                            class="text-[11px] text-red-500 hover:text-red-700 font-medium">
                        Hapus
                    </button>
                @endif
            @endauth
        </div>
    </div>

    {{-- Komentar --}}
    <p class="text-[14px] text-gray-600 leading-relaxed">{{ $review->comment }}</p>

    {{-- Foto Ulasan --}}
    @if($review->photos && count($review->photos) > 0)
        <div class="flex gap-2 mt-3 flex-wrap">
            @foreach($review->photos as $photo)
                <img src="{{ Storage::url($photo) }}"
                     alt="Foto ulasan"
                     @click="previewImage = '{{ Storage::url($photo) }}'"
                     class="w-24 h-24 object-cover rounded-xl shadow-sm border border-gray-100 cursor-pointer hover:opacity-80 transition-opacity">
            @endforeach
        </div>
    @endif
</div>
