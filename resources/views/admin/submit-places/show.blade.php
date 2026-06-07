@extends('layouts.admin')
@section('title', 'Detail Usulan Tempat')

@section('content')
<div class="space-y-6">
    {{-- Back Link --}}
    <div>
        <a href="{{ route('admin.submit-places.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-emerald-600 transition-colors no-underline">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Usulan
        </a>
    </div>

    {{-- Main Container Card --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden max-w-4xl">
        {{-- Photo Header --}}
        @include('admin.submit-places.partials.show-header')

        {{-- Content --}}
        <div class="p-6 sm:p-8 space-y-8">
            {{-- Details --}}
            @include('admin.submit-places.partials.show-details')

            {{-- Action Buttons --}}
            @include('admin.submit-places.partials.show-actions')
        </div>
    </div>
</div>
@endsection
