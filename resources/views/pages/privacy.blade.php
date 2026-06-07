@extends('layouts.plain')
@section('title', 'Privasi & Keamanan')

@section('content')
{{-- Judul di luar kotak --}}
<div class="mb-8 text-center">
    <span class="inline-flex items-center px-4 py-2 rounded-full bg-[#965D15]/10 text-[#965D15] text-sm font-semibold mb-4">
        Privasi Pengguna KUMAR
    </span>
    <h1 class="text-4xl font-bold text-dark mb-3">Privasi & Keamanan</h1>
    <p class="text-gray-500 font-medium">Terakhir Diperbarui: {{ date('d F Y') }}</p>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 sm:p-10 border border-gray-100">
    <p class="text-gray-700 mb-8 text-sm md:text-base leading-relaxed">
        KUMAR (Kuliner Masyarakat) berkomitmen untuk menjaga privasi dan keamanan data pengguna.
        Halaman ini menjelaskan bagaimana KUMAR mengumpulkan, menggunakan, menyimpan, dan melindungi
        informasi yang diberikan oleh pengguna saat menggunakan layanan kami.
    </p>

    {{-- Accordion --}}
    <div x-data="{ activeAccordion: 'privacy-1' }" class="w-full flex flex-col gap-3">

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'privacy-1' ? '' : 'privacy-1'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">1. Informasi yang Kami Kumpulkan</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'privacy-1' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'privacy-1'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed space-y-3">
                    <p>Kami dapat mengumpulkan informasi yang diperlukan untuk menjalankan fitur utama KUMAR, seperti:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Nama pengguna, email, username, dan data akun lainnya.</li>
                        <li>Nomor telepon jika digunakan untuk verifikasi atau komunikasi.</li>
                        <li>Ulasan, rating, komentar, dan foto yang diunggah pengguna.</li>
                        <li>Informasi tempat makan yang dikirimkan melalui fitur submit tempat.</li>
                        <li>Alamat, titik lokasi, atau tautan Google Maps sebagai referensi tempat makan.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'privacy-2' ? '' : 'privacy-2'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">2. Penggunaan Informasi</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'privacy-2' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'privacy-2'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed space-y-3">
                    <p>Informasi yang dikumpulkan digunakan untuk:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Membuat dan mengelola akun pengguna.</li>
                        <li>Menampilkan informasi dan rekomendasi tempat makan.</li>
                        <li>Memproses ulasan, rating, komentar, dan foto.</li>
                        <li>Memverifikasi tempat makan yang diajukan pengguna.</li>
                        <li>Meningkatkan kualitas layanan dan pengalaman pengguna.</li>
                        <li>Menjaga keamanan sistem dari spam, penyalahgunaan, atau aktivitas mencurigakan.</li>
                    </ul>
                    <p>KUMAR tidak menjual data pribadi pengguna kepada pihak lain.</p>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'privacy-3' ? '' : 'privacy-3'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">3. Keamanan Akun dan Data</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'privacy-3' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'privacy-3'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    KUMAR menerapkan langkah keamanan yang wajar untuk melindungi data pengguna, seperti penyimpanan password dalam bentuk hash,
                    validasi input, pembatasan akses admin, dan pemeriksaan aktivitas yang mencurigakan. Pengguna juga bertanggung jawab
                    menjaga kerahasiaan password, kode OTP, dan akses akun masing-masing.
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'privacy-4' ? '' : 'privacy-4'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">4. Data Lokasi dan Informasi Tempat</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'privacy-4' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'privacy-4'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    KUMAR dapat menampilkan informasi lokasi tempat makan berdasarkan data yang diberikan pengguna, pemilik tempat,
                    admin, atau referensi seperti Google Maps. Data lokasi digunakan untuk membantu pengguna menemukan tempat makan
                    dengan lebih mudah. KUMAR tidak melakukan pelacakan lokasi pengguna secara terus-menerus tanpa persetujuan.
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'privacy-5' ? '' : 'privacy-5'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">5. Konten dari Pengguna</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'privacy-5' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'privacy-5'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    Ulasan, komentar, rating, foto, dan data tempat makan yang dikirimkan pengguna dapat ditampilkan di platform KUMAR.
                    KUMAR berhak meninjau, menyunting, menyembunyikan, atau menghapus konten yang dianggap tidak sesuai, menyesatkan,
                    mengandung spam, promosi berlebihan, ujaran kebencian, atau melanggar ketentuan yang berlaku.
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg bg-white overflow-hidden hover:border-[#965D15]/30 transition-colors">
            <button @click="activeAccordion = activeAccordion === 'privacy-6' ? '' : 'privacy-6'" class="flex items-center justify-between w-full p-4 text-left select-none transition-colors hover:bg-gray-50">
                <span class="text-base font-semibold text-dark">6. Hak Pengguna</span>
                <svg class="w-5 h-5 duration-200 ease-out text-gray-500" :class="{ 'rotate-180': activeAccordion === 'privacy-6' }" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div x-show="activeAccordion === 'privacy-6'" x-collapse x-cloak>
                <div class="px-4 pb-4 pt-1 text-gray-600 text-sm leading-relaxed">
                    Pengguna dapat meminta pembaruan, perubahan, atau penghapusan data akun sesuai ketentuan yang berlaku.
                    Jika terdapat data yang tidak akurat atau digunakan secara tidak semestinya, pengguna dapat menghubungi pengelola KUMAR.
                </div>
            </div>
        </div>
    </div>

    {{-- Divider --}}
    <hr class="my-8 border-gray-200">

    {{-- Butuh Bantuan --}}
    <div class="text-center pb-2">
        <h3 class="text-xl font-bold text-dark mb-2">Butuh Bantuan?</h3>
        <p class="text-gray-500 text-sm mb-6">Jika Anda memiliki pertanyaan tentang privasi dan keamanan data, silakan hubungi tim kami.</p>
        <a href="mailto:support@kumar.com" class="inline-flex items-center justify-center gap-2 bg-[#965D15] hover:bg-[#784A11] text-white px-8 py-3 rounded-full font-semibold transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            Hubungi Tim Privasi
        </a>
    </div>
</div>
@endsection