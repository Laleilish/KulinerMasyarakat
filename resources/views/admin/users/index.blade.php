@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen User</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar pengguna terdaftar beserta hak akses dan manajemen akun.</p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm" x-data="{ openRole: false }">
        <div class="flex flex-col sm:flex-row gap-3 items-center w-full">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 flex-1 w-full">
                @if(request('role'))
                    <input type="hidden" name="role" value="{{ request('role') }}">
                @endif
                @if(request('sort_username'))
                    <input type="hidden" name="sort_username" value="{{ request('sort_username') }}">
                @endif
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama, username, atau email..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-100 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 rounded-xl text-sm transition-all outline-none text-gray-700">
                </div>
                <div class="flex gap-2">
                    @if(request('search') || request('role') || request('sort_username'))
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-bold transition-all no-underline shrink-0 flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all shrink-0 cursor-pointer border-none">
                        Cari
                    </button>
                </div>
            </form>

            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                {{-- Sort Username --}}
                <div class="relative shrink-0 w-full sm:w-auto" x-data="{ openSort: false }">
                    <button @click="openSort = !openSort" type="button" class="w-full sm:w-auto px-4 py-2.5 bg-[#F8F4EC] hover:bg-[#F2E0BE] text-gray-700 font-medium text-sm rounded-xl flex items-center justify-between gap-2 transition-colors border-none cursor-pointer {{ request('sort_username') ? 'bg-[#F2E0BE] ring-1 ring-[#D98A2C]' : '' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                            {{ request('sort_username') === 'asc' ? 'Username (A-Z)' : (request('sort_username') === 'desc' ? 'Username (Z-A)' : 'Urutkan') }}
                        </div>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="openSort" @click.away="openSort = false" x-transition x-cloak style="display: none;" class="absolute top-full right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <a href="{{ route('admin.users.index', request()->except('sort_username', 'page')) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ !request('sort_username') ? 'font-bold text-gray-900' : '' }}">Bawaan (Terbaru)</a>
                        <a href="{{ route('admin.users.index', array_merge(request()->except('page'), ['sort_username' => 'asc'])) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ request('sort_username') == 'asc' ? 'font-bold text-gray-900 bg-[#F2E0BE]/30' : '' }}">Username (A-Z)</a>
                        <a href="{{ route('admin.users.index', array_merge(request()->except('page'), ['sort_username' => 'desc'])) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ request('sort_username') == 'desc' ? 'font-bold text-gray-900 bg-[#F2E0BE]/30' : '' }}">Username (Z-A)</a>
                    </div>
                </div>

                {{-- Filter Role --}}
                <div class="relative shrink-0 w-full sm:w-auto">
                    <button @click="openRole = !openRole" type="button" class="w-full sm:w-auto px-4 py-2.5 bg-[#F8F4EC] hover:bg-[#F2E0BE] text-gray-700 font-medium text-sm rounded-xl flex items-center justify-between gap-2 transition-colors border-none cursor-pointer {{ request('role') ? 'bg-[#F2E0BE] ring-1 ring-[#D98A2C]' : '' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            {{ request('role') ? ucfirst(request('role')) : 'Filter Role' }}
                        </div>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="openRole" @click.away="openRole = false" x-transition x-cloak style="display: none;" class="absolute top-full right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <a href="{{ route('admin.users.index', request()->except('role', 'page')) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ !request('role') ? 'font-bold text-gray-900' : '' }}">Semua Role</a>
                        <a href="{{ route('admin.users.index', array_merge(request()->except('page'), ['role' => 'admin'])) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ request('role') == 'admin' ? 'font-bold text-gray-900 bg-[#F2E0BE]/30' : '' }}">Admin</a>
                        <a href="{{ route('admin.users.index', array_merge(request()->except('page'), ['role' => 'user'])) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ request('role') == 'user' ? 'font-bold text-gray-900 bg-[#F2E0BE]/30' : '' }}">User</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($users->isEmpty())
                <div class="px-6 py-12 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-2xl mx-auto mb-3 text-gray-400">
                        🔍
                    </div>
                    <h5 class="font-bold text-gray-700">Tidak ada user ditemukan</h5>
                    <p class="text-xs text-gray-400 mt-1">Coba sesuaikan kata kunci pencarian Anda.</p>
                </div>
            @else
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 uppercase text-[10px] font-bold tracking-wider">
                            <th class="px-6 py-3.5">Profil Pengguna</th>
                            <th class="px-6 py-3.5">Username</th>
                            <th class="px-6 py-3.5">Peran (Role)</th>
                            <th class="px-6 py-3.5">Tanggal Registrasi</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50/55 transition-colors {{ $user->id === auth()->id() ? 'bg-emerald-50/20' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-bold overflow-hidden shrink-0 border border-gray-100 shadow-sm">
                                            @if($user->avatar)
                                                <img src="{{ str_starts_with($user->avatar, 'http') ? $user->avatar : Storage::url($user->avatar) }}" alt="Avatar" class="w-full h-full object-cover" referrerpolicy="no-referrer">
                                            @else
                                                <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1.5">
                                                <p class="font-bold text-gray-900 leading-tight">{{ $user->name }}</p>
                                                @if($user->id === auth()->id())
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                        Anda
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="text-xs text-gray-400">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                    {{ $user->username ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                            Admin
                                        </span>
                                    @elseif($user->role === 'owner')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                                            <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>
                                            Owner
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 border border-gray-200">
                                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                            User
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs">
                                    {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($user->id !== auth()->id())
                                        @if(auth()->user()->role === 'admin' && in_array($user->role, ['admin', 'owner']))
                                            <span class="text-xs text-gray-400 italic font-medium px-3 py-1 bg-gray-50 rounded-xl border border-gray-100">
                                                Admin
                                            </span>
                                        @else
                                            <div class="flex items-center justify-end gap-2">
                                                {{-- Toggle Role --}}
                                                <form action="{{ route('admin.users.toggle-role', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="px-3 py-1.5 text-xs font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-500 hover:text-white border border-emerald-100 hover:border-emerald-500 rounded-xl transition-all cursor-pointer"
                                                            title="Ubah peran admin/user">
                                                        {{ $user->role === 'admin' ? 'Jadikan User' : 'Jadikan Admin' }}
                                                    </button>
                                                </form>

                                                {{-- Delete --}}
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" id="delete-user-{{ $user->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="p-2 text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-500 rounded-xl transition-all border border-rose-100 hover:border-rose-500 cursor-pointer"
                                                            @click="$dispatch('confirm-modal', {
                                                                title: 'Hapus Pengguna?',
                                                                message: 'Apakah Anda yakin ingin menghapus pengguna {{ $user->name }} secara permanen? Seluruh ulasan dan data terkait akan ikut terhapus.',
                                                                variant: 'danger',
                                                                confirmText: 'Ya, Hapus',
                                                                formId: 'delete-user-{{ $user->id }}'
                                                            })"
                                                            title="Hapus Pengguna">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400 italic font-medium px-3 py-1 bg-gray-50 rounded-xl border border-gray-100">
                                            Sesi Aktif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="px-6 py-6 border-t border-gray-100/50 flex justify-center">
            {{ $users->links('admin.partials.pagination') }}
        </div>
    </div>
</div>
@endsection
