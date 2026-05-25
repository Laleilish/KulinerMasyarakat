<section class="relative overflow-hidden">

    <h1 class="text-center text-[21px] font-extrabold text-dark leading-[1.35] pt-7 px-6"> Pilih Kampus Yang Kamu Inginkan</h1>

    <div class="grid grid-cols-3 gap-y-6 gap-x-4 px-5 pt-6 pb-6">

        @foreach ($kampusList as $kampus)

        <div class="text-center cursor-pointer">

            <div class="w-20 h-20 rounded-3xl bg-[#F5A623] flex items-center justify-center mx-auto mb-2 shadow-lg hover:scale-105 transition">
                <img src="{{ asset($kampus['logo']) }}" class="w-13 h-13 object-contain">
            </div>

            <p class="text-[11px] font-bold text-dark leading-[1.35]">{{ $kampus['name'] }}</p>
        </div>

        @endforeach

    </div>

    <p class="text-center px-7 pb-6 text-[12px] text-muted leading-[1.7]"> Bingung Mau Makan Setelah Jadwal Kelas? Ayo cari makanan hingga ke pelosok daerah sekitar kampusmu!</p>
</section>