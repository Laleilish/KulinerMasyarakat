@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FDF8F0] py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800">Daftar Usulan Tempat</h1>
                <p class="text-gray-500 mt-1">Kelola usulan tempat makan dari pengguna</p>
            </div>

            {{-- Filter --}}
            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('admin.submit-places.index') }}"
                   class="px-4 py-2 rounded-full text-sm font-bold transition-colors {{ !request('status') ? 'bg-emerald-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                    Semua
                </a>
                <a href="{{ route('admin.submit-places.index', ['status' => 'pending']) }}"
                   class="px-4 py-2 rounded-full text-sm font-bold transition-colors {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                    Pending
                </a>
                <a href="{{ route('admin.submit-places.index', ['status' => 'approved']) }}"
                   class="px-4 py-2 rounded-full text-sm font-bold transition-colors {{ request('status') === 'approved' ? 'bg-emerald-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                    Disetujui
                </a>
                <a href="{{ route('admin.submit-places.index', ['status' => 'rejected']) }}"
                   class="px-4 py-2 rounded-full text-sm font-bold transition-colors {{ request('status') === 'rejected' ? 'bg-red-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                    Ditolak
                </a>
            </div>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-[0_4px_20px_rgb(0,0,0,0.06)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pengirim</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kampus</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($submitPlaces as $place)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ Storage::url($place->photo) }}" alt="{{ $place->name }}"
                                             class="w-10 h-10 rounded-lg object-cover">
                                        <span class="font-semibold text-gray-800 text-sm">{{ $place->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                        {{ $place->category === 'makanan_berat' ? 'bg-orange-100 text-orange-700' : '' }}
                                        {{ $place->category === 'jajanan' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $place->category === 'minuman' ? 'bg-blue-100 text-blue-700' : '' }}">
                                        {{ str_replace('_', ' ', ucfirst($place->category)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $place->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $place->campus->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                        {{ $place->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $place->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $place->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ ucfirst($place->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $place->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.submit-places.show', $place) }}"
                                       class="text-emerald-600 hover:text-emerald-700 font-bold text-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">
                                    Belum ada usulan tempat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($submitPlaces->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $submitPlaces->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
