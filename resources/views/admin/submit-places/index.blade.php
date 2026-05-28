@extends('layouts.admin')

@section('content')
<div class="max-w-6xl space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manajemen Resto</h1>
            <p class="text-sm text-gray-700 mt-1">Melakukan review, edit, dan mengakurasi sesuai dengan kebutuhan pengguna.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    @include('admin.submit-places.partials.stats')

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-gray-100/50 shadow-sm overflow-hidden">
        <!-- Filter Bar -->
        @include('admin.submit-places.partials.filters')

        <!-- Table -->
        @include('admin.submit-places.partials.table')

        {{-- Pagination --}}
        @if ($submitPlaces->hasPages())
            <div class="px-6 py-6 border-t border-gray-100/50 flex justify-center">
                {{ $submitPlaces->links('admin.partials.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
