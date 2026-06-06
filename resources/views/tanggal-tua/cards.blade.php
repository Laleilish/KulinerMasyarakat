<section class="grid grid-cols-2 md:grid-cols-4 gap-4 px-5 pb-6">

    @foreach($restaurants as $restaurant)

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col relative border border-gray-100 pb-2">

            {{-- Background Leaf Image / Placeholder --}}
            <div class="relative w-full h-[120px] bg-gray-200">
                <img
                    src="{{ asset('storage/'.$restaurant->image) }}"
                    class="w-full h-full object-cover rounded-b-[20px]"
                    onerror="this.src='https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=400'">
            </div>

            <div class="px-3 pt-3 flex-1 flex flex-col">

                {{-- Rating --}}
                <div class="flex items-center gap-1 mb-1">
                    <div class="flex text-[#F5A623] text-[9px]">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-500">{{ number_format($restaurant->average_rating, 1) }} <span class="font-normal">({{ $restaurant->reviews_count }})</span></span>
                </div>

                {{-- Title & Address --}}
                <h3 class="font-extrabold text-[12px] text-dark leading-tight line-clamp-2 mb-1">
                    {{ $restaurant->name }}
                </h3>

                <p class="text-[10px] text-gray-400 font-medium line-clamp-2 flex-1 mb-2">
                    {{ $restaurant->address }}
                </p>

                {{-- Footer: Distance & Price --}}
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex items-center gap-1">
                        <i class="fas fa-map-marker-alt text-[#02b176] text-[10px]"></i>
                        <span class="text-[10px] font-bold text-dark">
                            {{-- Placeholder for distance calculation, can be dynamic --}}
                            1.8 km
                        </span>
                    </div>

                    <span class="font-extrabold text-[12px] text-dark">
                        {{ $restaurant->price_range }}
                    </span>
                </div>

            </div>

        </div>

    @endforeach

</section>