@extends('layouts.auth')


<body class="font-sans antialiased bg-cream-bg">
    @section('content')
        <div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4">
            <div class="w-full max-w-md">
            
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-dark mb-4">Masukkan Kode Verifikasi</h1>
                    <p class="text-sm text-dark mb-2">Kode OTP udah dikirimkan ke email Anda</p>
                    <p class="text-base font-semibold text-dark">{{ $email }}</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-100/70 backdrop-blur-sm border-2 border-green-300 rounded-xl text-green-700 text-sm text-center">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100/70 backdrop-blur-sm border-2 border-red-300 rounded-xl text-red-700 text-sm text-center">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register.otp.submit') }}" class="space-y-6">
                    @csrf

                    <!-- OTP Input -->
                    <div>
                        <div class="flex justify-center gap-3 mb-4">
                            <input type="text" maxlength="1" class="otp-input w-16 h-16 text-center text-2xl font-bold rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark transition-all" data-index="0" inputmode="numeric" pattern="[0-9]">
                            <input type="text" maxlength="1" class="otp-input w-16 h-16 text-center text-2xl font-bold rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark transition-all" data-index="1" inputmode="numeric" pattern="[0-9]">
                            <input type="text" maxlength="1" class="otp-input w-16 h-16 text-center text-2xl font-bold rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark transition-all" data-index="2" inputmode="numeric" pattern="[0-9]">
                            <input type="text" maxlength="1" class="otp-input w-16 h-16 text-center text-2xl font-bold rounded-xl border-2 border-muted-light bg-white focus:border-secondary focus:ring-0 text-dark transition-all" data-index="3" inputmode="numeric" pattern="[0-9]">
                        </div>

                        <input type="hidden" name="otp" id="otpValue" required>
                    </div>

                    <!-- Tidak Menerima OTP -->
                    <div class="text-center mb-16">
                        <p class="text-sm text-dark mb-2">Tidak Menerima kode OTP?</p>
                        <div id="resendContainer" class="text-sm text-dark">
                            Kirim ulang kode dalam <span id="countdown" class="text-red-400 font-semibold">59 detik</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-secondary hover:bg-secondary-dark shadow-2xs text-white font-bold py-3 rounded-xl transition-all duration-200 mb-4"
                    >
                        Lanjutkan
                    </button>

                    <!-- Nav Kembali -->
                    <div class="text-center">
                        <a href="{{ route('register') }}" class="text-sm text-dark hover:text-secondary flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke halaman pendaftaran
                        </a>
                    </div>
                </form>

                <!-- Resend OTP -->
                <form id="resendForm" method="POST" action="{{ route('register.otp.resend') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <script>
            const otpInputs = document.querySelectorAll('.otp-input');
            const otpValue = document.getElementById('otpValue');
            const submitBtn = document.getElementById('submitBtn');
            const countdownEl = document.getElementById('countdown');
            const resendContainer = document.getElementById('resendContainer');

            let countdown = 59;
            let timer;

            //Start countdown
            function startCountdown() {
                countdown = 59;

                // Reset tampilan countdown
                countdownEl.className = 'text-red-400 font-semibold';
                countdownEl.textContent = `${countdown} detik`;

               
                if (timer) clearInterval(timer);

                // Countdown timer
                timer = setInterval(() => {
                    countdown--;
                    countdownEl.textContent = `${countdown} detik`;

                    if (countdown <= 0) {
                        clearInterval(timer);
                        countdownEl.innerHTML = `
                            <button type="button" onclick="document.getElementById('resendForm').submit()"
                                    class="text-blue hover:underline font-semibold bg-transparent border-none cursor-pointer">
                                Kirim Ulang
                            </button>
                        `;
                    }
                }, 1000);
            }

            // Start countdown saat page load
            startCountdown();

            // OTP Input Handler
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;

                    if (!/^\d*$/.test(value)) {
                        e.target.value = '';
                        return;
                    }

                    updateOtpValue();

                    // Move to next input
                    if (value && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }

                    // Auto submit when all filled
                    if (index === otpInputs.length - 1 && value) {
                        const allFilled = Array.from(otpInputs).every(input => input.value);
                        if (allFilled) {
                            submitBtn.click();
                        }
                    }
                });

                // Handle backspace
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });

                // Handle paste
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').slice(0, 4);

                    if (!/^\d+$/.test(pastedData)) return;

                    pastedData.split('').forEach((char, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = char;
                        }
                    });

                    updateOtpValue();
                    otpInputs[Math.min(pastedData.length, otpInputs.length - 1)].focus();
                });
            });

            function updateOtpValue() {
                const otp = Array.from(otpInputs).map(input => input.value).join('');
                otpValue.value = otp;
            }

            // Focus first input on load
            otpInputs[0].focus();
        </script>

    @endsection
</body>
