<!-- Progress Bar & Steps -->
<div class="relative mb-8">
    <div class="absolute left-5 right-5 top-5 h-1 -translate-y-1/2 rounded-full bg-gray-200"></div>

    <!-- Line Progress -->
    <div
        class="absolute left-5 top-5 h-1 -translate-y-1/2 rounded-full bg-emerald-500 transition-all duration-500"
        :style="{
            width: step === 1 ? '0%' : step === 2 ? 'calc(50% - 20px)' : 'calc(100% - 40px)'
        }"
    ></div>

    <!-- Steps -->
    <div class="relative z-10 flex justify-between">
        <!-- Step 1 -->
        <div class="flex w-20 flex-col items-center gap-2 text-center">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold shadow-sm transition-colors duration-300"
                :class="step >= 1 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'"
            >
                1
            </div>
            <span
                class="text-xs font-semibold leading-tight"
                :class="step >= 1 ? 'text-emerald-500' : 'text-gray-400'"
            >
                Info Dasar
            </span>
        </div>

        <!-- Step 2 -->
        <div class="flex w-20 flex-col items-center gap-2 text-center">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold shadow-sm transition-colors duration-300"
                :class="step >= 2 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'"
            >
                2
            </div>
            <span
                class="text-xs font-semibold leading-tight"
                :class="step >= 2 ? 'text-emerald-500' : 'text-gray-400'"
            >
                Detail & Lokasi
            </span>
        </div>

        <!-- Step 3 -->
        <div class="flex w-20 flex-col items-center gap-2 text-center">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold shadow-sm transition-colors duration-300"
                :class="step >= 3 ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500'"
            >
                3
            </div>
            <span
                class="text-xs font-semibold leading-tight"
                :class="step >= 3 ? 'text-emerald-500' : 'text-gray-400'"
            >
                Review
            </span>
        </div>
    </div>
</div>