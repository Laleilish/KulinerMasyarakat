@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FDF8F0] py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Back Link --}}
        <a href="{{ route('admin.submit-places.index') }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-gray-700 mb-6 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar
        </a>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- Main Card --}}
        <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] overflow-hidden">

            {{-- Photo Header --}}
            <div class="relative h-56 sm:h-72 bg-gray-200">
                <img src="{{ Storage::url($submitPlace->photo) }}" alt="{{ $submitPlace->name }}"
                     class="w-full h-full object-cover">
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold shadow-sm
                        {{ $submitPlace->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $submitPlace->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : '' }}
                        {{ $submitPlace->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($submitPlace->status) }}
                    </span>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 md:p-8 space-y-6">
                {{-- Title & Category --}}
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">{{ $submitPlace->name }}</h1>
                    <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-bold
                        {{ $submitPlace->category === 'makanan_berat' ? 'bg-orange-100 text-orange-700' : '' }}
                        {{ $submitPlace->category === 'jajanan' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $submitPlace->category === 'minuman' ? 'bg-blue-100 text-blue-700' : '' }}">
                        {{ str_replace('_', ' ', ucfirst($submitPlace->category)) }}
                    </span>
                    @if ($submitPlace->food_type)
                        <span class="inline-flex items-center mt-2 ml-1 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                            {{ $submitPlace->food_type }}
                        </span>
                    @endif
                </div>

                {{-- Info Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pengirim</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $submitPlace->user->name ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kampus Terdekat</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $submitPlace->campus->name ?? '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jam Buka</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $submitPlace->open_hours ?: '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Range Harga</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $submitPlace->price_range ?: '-' }}</p>
                    </div>
                </div>

                {{-- Address --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat</p>
                    <p class="text-sm text-gray-700">{{ $submitPlace->address }}</p>
                </div>

                {{-- Description --}}
                @if ($submitPlace->description)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Deskripsi</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $submitPlace->description }}</p>
                    </div>
                @endif

                {{-- Google Maps & Coordinates --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Google Maps</p>
                    <a href="{{ $submitPlace->gmaps_link }}" target="_blank" rel="noopener"
                       class="text-sm text-emerald-600 hover:text-emerald-700 font-medium break-all">
                        {{ $submitPlace->gmaps_link }}
                    </a>
                    @if ($submitPlace->latitude && $submitPlace->longitude)
                        <p class="text-xs text-gray-500 mt-1">Koordinat: {{ $submitPlace->latitude }}, {{ $submitPlace->longitude }}</p>
                    @else
                        <p class="text-xs text-red-400 mt-1">Koordinat tidak berhasil diekstrak</p>
                    @endif
                </div>

                {{-- Landmark --}}
                @if ($submitPlace->landmark || $submitPlace->landmark_photo)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Patokan</p>
                        @if ($submitPlace->landmark)
                            <p class="text-sm text-gray-700 mb-2">{{ $submitPlace->landmark }}</p>
                        @endif
                        @if ($submitPlace->landmark_photo)
                            <img src="{{ Storage::url($submitPlace->landmark_photo) }}" alt="Foto Patokan"
                                 class="w-full max-w-sm rounded-xl object-cover">
                        @endif
                    </div>
                @endif

                {{-- Initial Review --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Review Awal</p>
                    <div class="flex items-center gap-1 mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $submitPlace->initial_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                        <span class="text-sm text-gray-500 ml-1">({{ $submitPlace->initial_rating }}/5)</span>
                    </div>
                    @if ($submitPlace->initial_review)
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $submitPlace->initial_review }}</p>
                    @endif
                    @if ($submitPlace->initial_review_photo)
                        <img src="{{ Storage::url($submitPlace->initial_review_photo) }}" alt="Foto Review"
                             class="mt-2 w-full max-w-sm rounded-xl object-cover">
                    @endif
                </div>

                {{-- Submitted At --}}
                <p class="text-xs text-gray-400">Diusulkan pada {{ $submitPlace->created_at->format('d M Y, H:i') }}</p>

                {{-- Action Buttons --}}
                @if ($submitPlace->status === 'pending')
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                        <form action="{{ route('admin.submit-places.approve', $submitPlace) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    onclick="return confirm('Yakin ingin menyetujui usulan ini?')"
                                    class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm px-6 py-2.5 rounded-full transition-colors shadow-sm">
                                ✓ Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.submit-places.reject', $submitPlace) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    onclick="return confirm('Yakin ingin menolak usulan ini?')"
                                    class="bg-red-500 hover:bg-red-600 text-white font-bold text-sm px-6 py-2.5 rounded-full transition-colors shadow-sm">
                                ✕ Tolak
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
