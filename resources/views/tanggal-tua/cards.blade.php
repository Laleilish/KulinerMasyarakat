<section class="grid grid-cols-2 md:grid-cols-4 gap-4 px-4 pb-6">

    @foreach($restaurants as $restaurant)

        <div class="bg-white rounded-brand shadow-card overflow-hidden">

            <img
                src="{{ asset('storage/'.$restaurant->image) }}"
                class="aspect-[4/3] w-full object-cover">

            <div class="p-3">

                <h3 class="font-bold">
                    {{ $restaurant->name }}
                </h3>

                <p class="text-xs text-muted">
                    {{ $restaurant->address }}
                </p>

                <div class="flex justify-between mt-2">

                    <span class="text-xs">
                        📍 1.8 Km
                    </span>

                    <span class="font-bold">
                        Rp{{ number_format($restaurant->price) }}
                    </span>

                </div>

            </div>

        </div>

    @endforeach

</section>