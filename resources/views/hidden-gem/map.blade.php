<section class="px-5 pb-8">

    <h2 class="text-[20px] font-extrabold text-center text-dark mb-5">Peta Kampus</h2>

    <iframe src="{{ $kampusList[$selectedKampus]['map_embed'] ?? '' }}" class=" w-full h-[260px] rounded-3xl border border-black/5 shadow-card " loading="lazy"></iframe>

</section>