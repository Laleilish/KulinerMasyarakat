<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi OTP - {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <!-- Auth Navbar -->
    <header class="flex justify-between items-center px-4 md:px-10 py-3 bg-cream-bg shadow-navbar sticky top-0 z-50">
        <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
            <img src="{{ asset('assets/img/icon-kumar.png') }}" alt="KUMAR" class="h-10">
        </a>
        
        <div class="flex items-center gap-2 font-semibold text-muted cursor-pointer">
            <span class="text-dark">ID</span>
            <span>|</span>
            <span>EN</span>
        </div>
    </header>

    <div class="min-h-[calc(100vh-64px)] flex items-center justify-center bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mb-4">
                    <svg class="w-20 h-20 mx-auto text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-dark mb-2">Verifikasi Email</h1>
                <p class="text-gray-600 text-sm">Kami telah mengirimkan kode OTP ke</p>
                <p class="text-dark font-semibold mt-1">{{ $email }}</p>
            </div>

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100/70 backdrop-blur-sm border-2 border-green-300 rounded-xl text-green-700 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.otp.submit') }}" class="space-y-6">
                @csrf

                <!-- OTP Input -->
                <div>
                    <label for="otp" class="block text-sm font-semibold text-gray-700 mb-3 text-center">
                        Masukkan Kode OTP (6 Digit)
                    </label>

                    <input
                        id="otp"
                        type="text"
                        name="otp"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        placeholder="000000"
                        inputmode="numeric"
                        required
                        autofocus
                        class="w-full px-4 py-4 text-center text-3xl tracking-[1em] font-mono rounded-xl border-2 border-muted-light bg-white/70 backdrop-blur-sm focus:border-muted focus:bg-white focus:ring-0 text-gray-800 placeholder:text-gray-300 transition-all"
                    />

                    <x-input-error :messages="$errors->get('otp')" class="mt-2 text-center" />
                </div>

                <!-- Info Box -->
                <div class="bg-orange-100/70 backdrop-blur-sm border-l-4 border-secondary p-4 rounded-r-xl">
                    <p class="text-sm text-dark">
                        <span class="font-semibold">💡 Tips:</span>
                    </p>
                    <ul class="text-sm text-gray-600 mt-2 space-y-1 ml-4">
                        <li>• Cek folder spam/junk jika tidak menerima email</li>
                        <li>• Kode OTP berlaku selama <span class="font-semibold">10 menit</span></li>
                        <li>• Jangan bagikan kode ini kepada siapapun</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-secondary hover:bg-secondary-dark shadow-2xs text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02]"
                >
                    Verifikasi & Aktifkan Akun
                </button>
            </form>

            <!-- Resend OTP -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 mb-3">Tidak menerima kode?</p>
                <form method="POST" action="{{ route('register.otp.resend') }}" class="inline">
                    @csrf
                    <button
                        type="submit"
                        class="text-blue hover:text-orange-600 font-semibold text-sm"
                    >
                        Kirim Ulang Kode OTP
                    </button>
                </form>
            </div>

            <!-- Back to Register -->
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-800">
                    ← Kembali ke halaman pendaftaran
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto format OTP input (hanya angka)
        const otpInput = document.getElementById('otp');

        otpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Auto submit saat 6 digit terisi
        otpInput.addEventListener('input', function(e) {
            if (this.value.length === 6) {
                this.form.submit();
            }
        });

        // Auto focus on input
        otpInput.focus();
    </script>
</body>
</html>
