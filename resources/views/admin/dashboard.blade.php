@extends('layouts.admin')

@section('content')
<div class="max-w-6xl space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard</h1>
            <p class="text-sm text-gray-700 mt-1">Selamat datang, {{ auth()->user()->name }}. Ini laporan hari ini</p>
        </div>
        
        <button class="px-5 py-2.5 bg-[#B87A29] hover:bg-[#9d6722] text-white font-semibold text-sm rounded-lg shadow-sm transition-colors cursor-pointer border-none flex items-center gap-2">
            Cetak Laporan
        </button>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Resto --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm flex flex-col justify-between aspect-[4/3]">
            <div class="w-10 h-10 rounded-lg bg-[#F2E0BE] flex items-center justify-center text-gray-800 mb-4 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="mt-auto">
                <h4 class="text-gray-900 font-medium text-[15px] mb-2">Jumlah Resto</h4>
                <div class="text-3xl font-medium text-gray-900">{{ number_format($stats['restaurants_count']) }}</div>
            </div>
        </div>

        {{-- Total Ulasan --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm flex flex-col justify-between aspect-[4/3]">
            <div class="w-10 h-10 rounded-lg bg-[#F2E0BE] flex items-center justify-center text-gray-800 mb-4 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <div class="mt-auto">
                <h4 class="text-gray-900 font-medium text-[15px] mb-2">Jumlah Ulasan</h4>
                <div class="text-3xl font-medium text-gray-900">{{ number_format($stats['reviews_count']) }}</div>
            </div>
        </div>

        {{-- Pengguna Aktif --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm flex flex-col justify-between aspect-[4/3]">
            <div class="w-10 h-10 rounded-lg bg-[#F2E0BE] flex items-center justify-center text-gray-800 mb-4 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="mt-auto">
                <h4 class="text-gray-900 font-medium text-[15px] mb-2">Pengguna Aktif</h4>
                <div class="text-3xl font-medium text-gray-900">{{ number_format($stats['users_count']) }}</div>
            </div>
        </div>

        {{-- Usulan Baru --}}
        <div class="bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm flex flex-col justify-between aspect-[4/3]">
            <div class="w-10 h-10 rounded-lg bg-[#F2E0BE] flex items-center justify-center text-gray-800 mb-4 shrink-0">
                <span class="text-[10px] font-bold tracking-wider">NEW</span>
            </div>
            <div class="mt-auto">
                <h4 class="text-gray-900 font-medium text-[15px] mb-2">Usulan Baru</h4>
                <div class="text-3xl font-medium text-gray-900">{{ number_format($stats['pending_places_count']) }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Popularitas Chart  -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm flex flex-col">
            <div class="flex items-start justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Popularitas</h3>
                    <p class="text-[11px] text-gray-500 mt-1">Submissions & ulasan 7 hari terakhir</p>
                </div>
                <span class="px-3 py-1.5 text-xs text-gray-600 bg-white border border-gray-200 rounded-lg flex items-center gap-2">
                    7 Hari Terakhir
                </span>
            </div>
            
            <!-- Chart-->
            @php
                $maxVal = max($chartData->max('submissions'), $chartData->max('reviews'), 1);
                $points = [];
                $chartWidth = 500;
                $chartHeight = 180;
                $padding = 20;
                $usableWidth = $chartWidth - ($padding * 2);
                $stepX = $usableWidth / max(count($chartData) - 1, 1);
                
                foreach ($chartData as $i => $day) {
                    $x = $padding + ($i * $stepX);
                    $y = $chartHeight - ($padding + (($day['submissions'] + $day['reviews']) / $maxVal) * ($chartHeight - $padding * 2));
                    $points[] = round($x) . ',' . round($y);
                }
                $linePath = implode(' L', $points);
                $areaPath = 'M' . $points[0] . ' L' . implode(' L', $points) . ' L' . round($padding + (count($chartData) - 1) * $stepX) . ',' . $chartHeight . ' L' . $padding . ',' . $chartHeight . ' Z';
            @endphp
            <div class="flex-1 min-h-[200px] mt-auto relative">
                <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight + 30 }}" preserveAspectRatio="none" class="w-full h-full absolute inset-0">
                    <defs>
                        <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#bbf7d0" stop-opacity="1"/>
                            <stop offset="100%" stop-color="#f0fdf4" stop-opacity="0.3"/>
                        </linearGradient>
                    </defs>
                    {{-- Area fill --}}
                    <path d="{{ $areaPath }}" fill="url(#chartGradient)"/>
                    {{-- Line --}}
                    <polyline points="{{ implode(' ', $points) }}" fill="none" stroke="#22c55e" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round"/>
                    {{-- Data dots --}}
                    @foreach($points as $point)
                        <circle cx="{{ explode(',', $point)[0] }}" cy="{{ explode(',', $point)[1] }}" r="3.5" fill="#22c55e" stroke="white" stroke-width="2"/>
                    @endforeach
                    {{-- Day labels --}}
                    @foreach($chartData as $i => $day)
                        <text x="{{ $padding + ($i * $stepX) }}" y="{{ $chartHeight + 20 }}" text-anchor="middle" font-size="10" fill="#9ca3af" font-family="sans-serif">{{ $day['label'] }}</text>
                    @endforeach
                    {{-- Dashed bottom line --}}
                    <line x1="{{ $padding }}" y1="{{ $chartHeight }}" x2="{{ $chartWidth - $padding }}" y2="{{ $chartHeight }}" stroke="#e5e7eb" stroke-width="1" stroke-dasharray="4,4"/>
                </svg>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100/50 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Aktivitas Terbaru</h3>
            
            <div class="space-y-6">
                @forelse($recentActivities->take(5) as $activity)
                <div class="flex items-start gap-4">
                    @if($activity['type'] === 'approved')
                        <div class="w-6 h-6 rounded-full bg-white border border-emerald-500 flex items-center justify-center text-emerald-500 shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    @elseif($activity['type'] === 'rejected')
                        <div class="w-6 h-6 rounded-full bg-white border border-rose-500 flex items-center justify-center text-rose-500 shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                    @else
                        <div class="w-6 h-6 rounded-full bg-white border border-amber-600 flex items-center justify-center text-amber-600 shrink-0 mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </div>
                    @endif
                    <div>
                        <h4 class="text-sm font-semibold text-gray-800">{{ $activity['title'] }}</h4>
                        <p class="text-[10px] text-gray-500 mt-1">{{ $activity['subtitle'] }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-6">
                    <p class="text-sm text-gray-400">Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
