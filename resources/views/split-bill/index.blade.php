<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Split Bill — {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        
        .back-header-border::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: -1rem;
            right: -1rem;
            height: 1px;
            background: linear-gradient(90deg, transparent, #E8D5B0 20%, #E8D5B0 80%, transparent);
        }
    </style>
</head>
<body class="m-0 font-sans bg-cream-bg antialiased min-h-screen">
    <div class="w-full max-w-[960px] mx-auto px-4 min-h-screen flex flex-col" x-data="splitBill()" x-cloak>

        {{-- ═══ Back Header ═══ --}}
        <header class="flex items-center gap-3 py-4 md:py-5 sticky top-0 z-50 bg-cream-bg back-header-border relative">
            <a href="{{ url()->previous() }}" class="flex items-center justify-center w-[36px] h-[36px] md:w-[40px] md:h-[40px] rounded-[10px] md:rounded-xl bg-transparent hover:bg-black/5 text-dark text-lg md:text-xl transition-colors shrink-0 no-underline" aria-label="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-lg md:text-xl font-bold text-dark m-0">Split Bill</h1>
        </header>

        {{-- ═══ Main Content ═══ --}}
        <div class="bg-cream-dark rounded-[20px] p-6 md:p-7 shadow-card my-8">
            <div class="flex flex-col md:flex-row gap-5 md:gap-6 flex-1">

                {{-- ─── Left Panel: Form ─── --}}
                <div class="flex flex-col gap-4 flex-1 min-w-0">
                    <div>
                        <h2 class="m-0 mb-0.5 text-xl font-extrabold text-dark">Split Bill</h2>
                        <p class="m-0 text-[13px] text-muted">Atur Jumlah yang Kamu Inginkan</p>
                    </div>

                    {{-- Input Nominal --}}
                    <div class="flex items-center justify-center gap-3 bg-cream-bg rounded-xl py-4 px-5">
                        <span class="text-xl font-bold text-dark">Rp</span>
                        <input
                            type="number"
                            placeholder="0"
                            min="0"
                            x-model="rawInput"
                            @input="handleNominalInput($event)"
                            class="flex-1 w-full bg-transparent text-center text-xl font-bold text-dark outline-none placeholder:text-[#c5c5c5] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        >
                        <i class="fas fa-pencil text-dark"></i>
                    </div>

                    {{-- Jumlah Anggota --}}
                    <div>
                        <div class="text-xs font-medium text-muted mb-2">Jumlah Anggota</div>
                        <div class="flex items-center justify-between bg-cream-bg rounded-xl py-3 px-4">
                            <div class="flex items-center gap-2.5">
                                <img
                                    src="{{ asset('assets/img/Icon-Profile.png') }}"
                                    alt="Icon Profile"
                                    class="w-12 h-12 object-contain"
                                >
                                <h3 class="text-sm font-semibold text-dark m-0">Tambah anggota</h3>
                            </div>

                            <div class="flex items-center gap-1">
                                <button type="button" @click="if(jumlahOrang > 0) jumlahOrang--" :disabled="jumlahOrang <= 0" class="flex items-center justify-center w-[34px] h-[34px] rounded-full bg-transparent hover:bg-black/5 text-dark text-xl font-bold leading-none transition-colors disabled:text-muted-light disabled:cursor-not-allowed disabled:hover:bg-transparent">−</button>
                                <span class="min-w-[28px] text-center text-[22px] font-extrabold text-dark" x-text="jumlahOrang"></span>
                                <button type="button" @click="if(jumlahOrang < 15) jumlahOrang++" :disabled="jumlahOrang >= 15" class="flex items-center justify-center w-[34px] h-[34px] rounded-full bg-transparent hover:bg-black/5 text-dark text-xl font-bold leading-none transition-colors disabled:text-muted-light disabled:cursor-not-allowed disabled:hover:bg-transparent">+</button>
                            </div>
                        </div>
                    </div>

                    {{-- Tab Mode --}}
                    <div class="flex bg-cream-bg rounded-full p-1">
                        <button type="button" @click="activeTab = 'bagi'" :class="{'bg-[#B3700B] text-white shadow-[0_2px_6px_rgba(179,112,11,0.25)]': activeTab === 'bagi'}" class="flex-1 rounded-full py-2.5 px-3 text-[13px] font-semibold text-muted-light  transition-all border-none cursor-pointer">Bagi Rata</button>
                        <button type="button" @click="activeTab = 'nominal'" :class="{'bg-[#B3700B] text-white shadow-[0_2px_6px_rgba(179,112,11,0.25)]': activeTab === 'nominal'}" class="flex-1 rounded-full py-2.5 px-3 text-[13px] font-semibold text-muted-light transition-all border-none cursor-pointer">Tentuin Nominal</button>
                    </div>

                    {{-- Bersihkan Desktop --}}
                    <button type="button" @click="resetAll()" class="hidden md:block w-full rounded-full py-3.5 px-4 text-base font-bold text-white bg-[#B3700B] hover:bg-[#8a6008] active:scale-[0.98] transition-all border-none cursor-pointer disabled:bg-[#ccc] disabled:opacity-60 disabled:cursor-not-allowed mt-auto">
                        Bersihkan
                    </button>
                </div>

                {{-- Right Panel: Hasil --}}
                <div class="flex flex-col gap-4 flex-1 min-w-0">
                    {{-- Summary Card --}}
                    <div class="flex flex-col items-center gap-1.5 bg-[#FADEB5] rounded-xl py-4 px-[18px] transition-all">
                        <div class="text-base font-extrabold text-dark text-center leading-tight">
                            <span :class="(activeTab === 'nominal' && totalTerkumpul >= totalInput && totalInput > 0) ? 'text-[#10B981]' : 'text-[#7A5200]'" x-text="formatRupiah(totalTerkumpul)"></span>
                            dari
                            <span x-text="formatRupiah(totalInput)"></span>
                        </div>
                        <div class="text-xs font-semibold text-[#5A3D00] text-center">Hitungan Semua Biaya</div>
                    </div>

                    {{-- Hasil Wrap --}}
                    <div class="flex flex-col w-full rounded-xl border border-[#E8D5B0] bg-cream-bg overflow-hidden max-h-[320px] md:max-h-[350px]">
                        <div class="flex justify-between py-3 px-4 bg-[#F0E0C0] text-xs font-bold tracking-[0.3px] text-muted-light sticky top-0 z-10 shrink-0">
                            <span>Orang</span>
                            <span>Bayar</span>
                        </div>
                        <div class="overflow-y-auto flex-1">
                            <template x-if="jumlahOrang <= 0 || totalInput <= 0">
                                <div class="flex items-center justify-center py-8 px-4 text-center text-[13px] text-muted-light">
                                    Tambahkan anggota dan masukkan nominal untuk melihat hasil split.
                                </div>
                            </template>

                            <template x-if="jumlahOrang > 0 && totalInput > 0">
                                <div>
                                    <!-- TAB: BAGI RATA -->
                                    <template x-if="activeTab === 'bagi'">
                                        <template x-for="i in jumlahOrang" :key="'bagi-'+i">
                                            <div class="flex items-center py-3 px-4 border-b border-[#E8D5B0] gap-3 last:border-b-0">
                                                <div class="text-sm font-bold text-dark min-w-[24px]" x-text="i + '.'"></div>
                                                <div class="flex-1 text-right text-sm font-semibold text-dark" x-text="formatRupiah(Math.floor(totalInput / jumlahOrang) + (i <= (totalInput % jumlahOrang) ? 1 : 0))"></div>
                                            </div>
                                        </template>
                                    </template>

                                    <!-- TAB: TENTUIN NOMINAL -->
                                    <template x-if="activeTab === 'nominal'">
                                        <template x-for="i in jumlahOrang" :key="'nominal-'+i">
                                            <div class="flex items-center py-3 px-4 border-b border-[#E8D5B0] gap-3 last:border-b-0">
                                                <div class="text-sm font-bold text-dark min-w-[24px]" x-text="i + '.'"></div>
                                                <div class="text-xs font-bold text-muted-light ml-1">Rp</div>
                                                <input type="number"
                                                    class="flex-1 bg-transparent border-b-2 border-[#E8D5B0] focus:border-[#B3700B] outline-none text-right text-sm font-semibold text-dark py-1 transition-colors placeholder:text-[#c5c5c5] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                                    placeholder="0"
                                                    :value="customValues[i] || ''"
                                                    @input="handleCustomInput(i, $event)"
                                                >
                                            </div>
                                        </template>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Bersihkan Mobile --}}
                    <button type="button" @click="resetAll()" class="block md:hidden w-full rounded-full py-3.5 px-4 text-base font-bold text-white bg-[#B3700B] hover:bg-[#8a6008] active:scale-[0.98] transition-all border-none cursor-pointer disabled:bg-[#ccc] disabled:opacity-60 disabled:cursor-not-allowed mt-auto">
                        Bersihkan
                    </button>
                </div>

            </div>
        </div>

    </div>

    @include('split-bill.partials.script')
</body>
</html>