@extends('layouts.plain')
@section('title', 'Syarat & Ketentuan')

@section('content')
{{-- Judul di luar kotak --}}
<div class="mb-8 text-center">
    <span class="inline-flex items-center px-4 py-2 rounded-full bg-[#965D15]/10 text-[#965D15] text-sm font-semibold mb-4">
        Ketentuan Layanan KUMAR
    </span>
    <h1 class="text-4xl font-bold text-dark mb-3">Syarat & Ketentuan</h1>
    <p class="text-gray-500 font-medium">Terakhir Diperbarui: {{ date('d F Y') }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 sm:p-10 border border-gray-100">
    <p class="text-gray-700 mb-8 text-sm md:text-base leading-relaxed">
        Dengan menggunakan KUMAR (Kuliner Masyarakat), pengguna dianggap telah membaca, memahami,
        dan menyetujui syarat serta ketentuan yang berlaku. Jika pengguna tidak menyetujui ketentuan ini,
        pengguna dapat berhenti menggunakan layanan KUMAR.
    </p>

    {{-- Accordion --}}
    <div x-data="{ activeAccordion: 'terms-1' }" class="w-full flex flex-col gap-3">

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'terms-1' ? '' : 'terms-1'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">1. Tentang KUMAR</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'terms-1' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'terms-1'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    KUMAR adalah platform yang membantu pengguna menemukan informasi tempat makan, terutama tempat makan murah,
                    enak, dan hidden gem di sekitar kampus atau area tertentu. Informasi di KUMAR dapat berasal dari pengguna,
                    pemilik tempat, admin, atau sumber referensi lain yang relevan.
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'terms-2' ? '' : 'terms-2'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">2. Penggunaan Layanan</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'terms-2' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'terms-2'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed space-y-3">
                    <p>Pengguna dapat menggunakan KUMAR untuk:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Mencari tempat makan berdasarkan lokasi, budget, kategori, atau kebutuhan tertentu.</li>
                        <li>Melihat detail tempat makan, seperti alamat, kisaran harga, rating, dan ulasan.</li>
                        <li>Memberikan rating, komentar, dan ulasan berdasarkan pengalaman pribadi.</li>
                        <li>Mengirim rekomendasi tempat makan melalui fitur submit tempat.</li>
                    </ul>
                    <p>Pengguna wajib menggunakan KUMAR secara wajar dan tidak merugikan pengguna lain, pemilik tempat makan, maupun sistem KUMAR.</p>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'terms-3' ? '' : 'terms-3'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">3. Akun Pengguna</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'terms-3' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'terms-3'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    Beberapa fitur KUMAR mungkin membutuhkan akun pengguna. Pengguna bertanggung jawab atas keamanan akun,
                    data login, dan seluruh aktivitas yang terjadi melalui akun tersebut. Pengguna dilarang menggunakan identitas palsu,
                    mengambil alih akun orang lain, atau menggunakan akun untuk aktivitas yang melanggar hukum maupun ketentuan KUMAR.
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'terms-4' ? '' : 'terms-4'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">4. Ulasan, Rating, dan Komentar</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'terms-4' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'terms-4'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    Pengguna dapat memberikan ulasan, rating, dan komentar berdasarkan pengalaman yang sebenarnya.
                    Ulasan harus jujur, sopan, dan tidak mengandung hinaan, spam, promosi berlebihan, informasi palsu,
                    ujaran kebencian, atau konten yang merugikan pihak lain. KUMAR berhak menghapus atau menyembunyikan
                    ulasan yang dianggap melanggar ketentuan.
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'terms-5' ? '' : 'terms-5'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">5. Submit Tempat Makan</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'terms-5' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'terms-5'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    Pengguna dapat mengirimkan rekomendasi tempat makan melalui fitur submit tempat. Data yang dikirimkan sebaiknya
                    akurat, seperti nama tempat, alamat, kisaran harga, kategori, foto, jam operasional, dan tautan lokasi jika tersedia.
                    Setiap tempat makan yang dikirimkan dapat melalui proses pemeriksaan oleh admin sebelum ditampilkan di KUMAR.
                    Admin berhak menerima, menolak, atau meminta perbaikan data jika informasi belum lengkap atau tidak sesuai.
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'terms-6' ? '' : 'terms-6'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">6. Keakuratan Informasi</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'terms-6' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'terms-6'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    KUMAR berupaya menampilkan informasi tempat makan seakurat mungkin. Namun, informasi seperti harga, menu,
                    jam buka, jarak, dan fasilitas dapat berubah sewaktu-waktu. Pengguna disarankan untuk melakukan pengecekan ulang,
                    terutama sebelum mengunjungi tempat makan tertentu.
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'terms-7' ? '' : 'terms-7'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">7. Larangan Penggunaan</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'terms-7' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'terms-7'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed space-y-3">
                    <p>Pengguna dilarang menggunakan KUMAR untuk:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Mengunggah konten palsu, menyesatkan, atau merugikan pihak lain.</li>
                        <li>Menyebarkan ujaran kebencian, SARA, pornografi, kekerasan, atau konten ilegal.</li>
                        <li>Melakukan spam, promosi tidak relevan, atau manipulasi rating.</li>
                        <li>Mengganggu sistem, server, keamanan, atau kenyamanan pengguna lain.</li>
                        <li>Mengunggah foto atau konten yang bukan miliknya tanpa izin.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'terms-8' ? '' : 'terms-8'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">8. Hak Admin dan Batasan Tanggung Jawab</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'terms-8' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'terms-8'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    Admin KUMAR berhak mengelola data, memverifikasi tempat makan, meninjau ulasan, menghapus konten yang tidak sesuai,
                    serta membatasi akses pengguna yang melanggar ketentuan. KUMAR tidak bertanggung jawab atas perubahan harga,
                    kualitas makanan, pelayanan tempat makan, atau pengalaman pribadi pengguna setelah menggunakan informasi dari platform.
                </div>
            </div>
        </div>
    </div>

    {{-- Divider --}}
    <hr class="my-8 border-gray-200">

    {{-- Butuh Bantuan --}}
    <div class="text-center pb-2">
        <h3 class="text-xl font-bold text-dark mb-2">Ada Pertanyaan?</h3>
        <p class="text-gray-500 text-sm mb-6">Jika Anda memiliki pertanyaan tentang syarat dan ketentuan layanan KUMAR, silakan hubungi tim kami.</p>
        <a href="mailto:support@kumar.com" class="inline-flex items-center justify-center gap-2 bg-[#965D15] hover:bg-[#784A11] text-white px-8 py-3 rounded-full font-semibold transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            Hubungi Tim KUMAR
        </a>
    </div>
</div>
@endsection