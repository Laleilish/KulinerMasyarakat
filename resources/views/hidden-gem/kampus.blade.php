<div class="hero">
    <h1>Pilih Kampus Yang Kamu Inginkan</h1>

    <div class="kampus-grid">
        @foreach ($kampusList as $kampus)
        <div class="kampus-item {{ $loop->index === $selectedKampus ? 'active' : '' }}"
             onclick="selectKampus({{ $kampus['id'] }}, '{{ $kampus['map_embed'] }}')">
            <div class="kampus-icon">
                <img src="{{ asset('assets/img/' . $kampus['logo']) }}" alt="{{ $kampus['name'] }}">
            </div>
            <div class="kampus-name">{{ $kampus['name'] }}</div>
        </div>
        @endforeach
    </div>

    <p class="tagline">
        Bingung Mau Makan Setelah Jadwal Kelas? Ayo, cari Makanan Hingga ke Pelosok Daerah Sekitar Kampusmu!
    </p>
</div>