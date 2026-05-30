{{-- Aktivitas Platform Chart --}}
<div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm flex flex-col">
    <div class="flex items-start justify-between mb-8">
        <div>
            <h3 class="text-lg font-bold text-gray-900">Aktivitas Platform</h3>
            <p class="text-[11px] text-gray-500 mt-1">
                Perkembangan restoran dan ulasan
            </p>
        </div>

        {{-- Range Dropdown --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                    class="px-3 py-1.5 text-xs text-gray-600 bg-white border border-gray-200 rounded-lg flex items-center gap-2 hover:border-gray-300 transition-colors cursor-pointer">
                @if($range === '1y')
                    1 Tahun
                @elseif($range === '1m')
                    1 Bulan
                @else
                    7 Hari
                @endif
                <svg class="w-3.5 h-3.5 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div x-show="open" 
                 x-cloak
                 @click.away="open = false" 
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-1.5 w-36 bg-white border border-gray-200 rounded-xl shadow-lg z-10 py-1 overflow-hidden">
                
                <a href="{{ route('admin.dashboard', ['range' => '7d']) }}" 
                   class="block px-4 py-2 text-xs font-medium no-underline transition-colors
                          {{ $range === '7d' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                    7 Hari Terakhir
                </a>
                <a href="{{ route('admin.dashboard', ['range' => '1m']) }}" 
                   class="block px-4 py-2 text-xs font-medium no-underline transition-colors
                          {{ $range === '1m' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                    1 Bulan Terakhir
                </a>
                <a href="{{ route('admin.dashboard', ['range' => '1y']) }}" 
                   class="block px-4 py-2 text-xs font-medium no-underline transition-colors
                          {{ $range === '1y' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                    1 Tahun Terakhir
                </a>
            </div>
        </div>
    </div>
    
    {{-- Legend --}}
    <div class="flex items-center gap-5 mb-4">
        <div class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
            <span class="text-[11px] text-gray-500 font-medium">Resto Baru</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
            <span class="text-[11px] text-gray-500 font-medium">Ulasan</span>
        </div>
    </div>

    {{-- SVG Chart --}}
    @php
        $maxVal = max($chartData->max('restaurants'), $chartData->max('reviews'), 1);
        $chartWidth = 600;
        $chartHeight = 180;
        $padding = 25;
        $usableWidth = $chartWidth - ($padding * 2);
        $stepX = $usableWidth / max(count($chartData) - 1, 1);

        // Resto Baru line
        $restoPoints = [];
        foreach ($chartData as $i => $day) {
            $x = $padding + ($i * $stepX);
            $y = $chartHeight - ($padding + ($day['restaurants'] / $maxVal) * ($chartHeight - $padding * 2));
            $restoPoints[] = round($x, 1) . ',' . round($y, 1);
        }

        // Reviews line
        $revPoints = [];
        foreach ($chartData as $i => $day) {
            $x = $padding + ($i * $stepX);
            $y = $chartHeight - ($padding + ($day['reviews'] / $maxVal) * ($chartHeight - $padding * 2));
            $revPoints[] = round($x, 1) . ',' . round($y, 1);
        }

        // Area path for resto baru
        $restoAreaPath = 'M' . $restoPoints[0] . ' L' . implode(' L', $restoPoints) 
            . ' L' . round($padding + (count($chartData) - 1) * $stepX) . ',' . $chartHeight 
            . ' L' . $padding . ',' . $chartHeight . ' Z';

        // Area path for reviews
        $revAreaPath = 'M' . $revPoints[0] . ' L' . implode(' L', $revPoints)
            . ' L' . round($padding + (count($chartData) - 1) * $stepX) . ',' . $chartHeight
            . ' L' . $padding . ',' . $chartHeight . ' Z';

        // Y-axis gridlines
        $gridLines = 4;
    @endphp

    <div class="flex-1 min-h-[200px] mt-auto relative">
        <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight + 30 }}" preserveAspectRatio="none" class="w-full h-full absolute inset-0">
            <defs>
                <linearGradient id="restoGradient" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#bbf7d0" stop-opacity="0.8"/>
                    <stop offset="100%" stop-color="#f0fdf4" stop-opacity="0.1"/>
                </linearGradient>
                <linearGradient id="revGradient" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#bfdbfe" stop-opacity="0.6"/>
                    <stop offset="100%" stop-color="#eff6ff" stop-opacity="0.1"/>
                </linearGradient>
            </defs>

            {{-- Horizontal gridlines --}}
            @for($g = 0; $g <= $gridLines; $g++)
                @php $gy = $padding + ($g / $gridLines) * ($chartHeight - $padding * 2); @endphp
                <line x1="{{ $padding }}" y1="{{ $gy }}" x2="{{ $chartWidth - $padding }}" y2="{{ $gy }}" stroke="#f3f4f6" stroke-width="1"/>
                <text x="{{ $padding - 5 }}" y="{{ $gy + 3 }}" text-anchor="end" font-size="8" fill="#d1d5db" font-family="sans-serif">{{ round($maxVal - ($g / $gridLines) * $maxVal) }}</text>
            @endfor

            {{-- Area fills --}}
            <path d="{{ $restoAreaPath }}" fill="url(#restoGradient)"/>
            <path d="{{ $revAreaPath }}" fill="url(#revGradient)"/>

            {{-- Lines --}}
            <polyline points="{{ implode(' ', $restoPoints) }}" fill="none" stroke="#22c55e" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round"/>
            <polyline points="{{ implode(' ', $revPoints) }}" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke-dasharray="6,3"/>

            {{-- Data dots - Resto Baru --}}
            @foreach($restoPoints as $point)
                <circle cx="{{ explode(',', $point)[0] }}" cy="{{ explode(',', $point)[1] }}" r="3.5" fill="#22c55e" stroke="white" stroke-width="2"/>
            @endforeach

            {{-- Data dots - Reviews --}}
            @foreach($revPoints as $point)
                <circle cx="{{ explode(',', $point)[0] }}" cy="{{ explode(',', $point)[1] }}" r="3" fill="#3b82f6" stroke="white" stroke-width="2"/>
            @endforeach

            {{-- Day labels --}}
            @foreach($chartData as $i => $day)
                @php
                    $showLabel = true;
                    // For 1 month range (30 data points), only show every 5th label to prevent overlap
                    if ($range === '1m' && $i % 5 !== 0 && $i !== count($chartData) - 1) {
                        $showLabel = false;
                    }
                @endphp
                @if($showLabel)
                    <text x="{{ $padding + ($i * $stepX) }}" y="{{ $chartHeight + 20 }}" text-anchor="middle" font-size="{{ $range === '1m' ? '8' : '10' }}" fill="#9ca3af" font-family="sans-serif">{{ $day['label'] }}</text>
                @endif
            @endforeach

            {{-- Bottom baseline --}}
            <line x1="{{ $padding }}" y1="{{ $chartHeight }}" x2="{{ $chartWidth - $padding }}" y2="{{ $chartHeight }}" stroke="#e5e7eb" stroke-width="1" stroke-dasharray="4,4"/>
        </svg>
    </div>
</div>
