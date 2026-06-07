@extends('layouts.admin')
{{-- title --}}
@section('title', 'Dashboard')


@section('content')
<div class="max-w-6xl space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard</h1>
            <p class="text-sm text-gray-700 mt-1">Selamat datang, {{ auth()->user()->name }}. Ini laporan hari ini</p>
        </div>
        <a href="{{ route('admin.submit-places.report') }}" target="_blank" class="px-5 py-2.5 bg-[#B87A29] hover:bg-[#9d6722] text-white font-semibold text-sm rounded-lg shadow-sm transition-colors cursor-pointer border-none flex items-center gap-2">
            Cetak Laporan
        </a>
    </div>

    <!-- Stats Grid -->
    @include('admin.partials.stats')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Aktivitas Platform Chart  -->
        @include('admin.partials.chart')

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
