<section class="bg-cream-bg text-center px-5 pt-4 pb-6 md:px-10 md:py-[30px]">

    <h2 class="text-2xl md:text-3xl font-bold text-dark mb-6">Restoran Terfavorit</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-left">

        @forelse($restaurants as $restaurant)
        <div class="flex flex-col bg-white rounded-xl overflow-hidden cursor-pointer shadow-card transition-all duration-200 hover:-translate-y-1 hover:shadow-card-hover"
             onclick="window.location.href='{{ route('restoran.show', $restaurant->id) }}'">
            <img src="{{ $restaurant->photo ? asset('storage/' . $restaurant->photo) : asset('assets/img/Restoran Favorit/Nasi Goreng Kambing.png') }}" alt="{{ $restaurant->name }}"
                 class="w-full h-[130px] md:h-[230px] object-cover">
            <div class="flex flex-col flex-1 p-3 min-h-[90px]">
                <h3 class="text-base font-bold text-dark leading-snug mb-1">{{ $restaurant->name }}{{ $restaurant->landmark ? ', ' . $restaurant->landmark : '' }}</h3>
                <p class="text-sm text-muted mb-1 whitespace-nowrap overflow-hidden text-ellipsis">{{ $restaurant->category }}{{ $restaurant->food_type ? ', ' . $restaurant->food_type : '' }}</p>
                <span class="mt-auto text-sm text-secondary font-semibold flex items-center gap-1"><i class="fa-solid fa-star text-yellow-500"></i> {{ number_format($restaurant->reviews_avg_rating ?? 0, 1) }} ({{ $restaurant->reviews_count }})</span>
            </div>
        </div>
        @empty
            <p class="col-span-2 lg:col-span-4 text-center text-muted">Belum ada restoran terfavorit.</p>
        @endforelse

    </div>

    <div class="mt-6">
