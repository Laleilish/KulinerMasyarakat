<div class="p-6 border-b border-gray-100/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex flex-wrap gap-3" x-data="{ openCampus: false, openCategory: false }">
        {{-- Filter Kampus --}}
        <div class="relative">
            <button @click="openCampus = !openCampus; openCategory = false" class="px-4 py-2 bg-[#F8F4EC] hover:bg-[#F2E0BE] text-gray-700 font-medium text-sm rounded-lg flex items-center gap-2 transition-colors border-none cursor-pointer {{ request('campus') ? 'bg-[#F2E0BE] ring-1 ring-[#D98A2C]' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                {{ request('campus') ? ($campuses->firstWhere('id', request('campus'))->name ?? 'Filter Kampus') : 'Filter Kampus' }}
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openCampus" @click.away="openCampus = false" x-transition x-cloak class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50 max-h-60 overflow-y-auto">
                <a href="{{ route('admin.submit-places.index', request()->except('campus', 'page')) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ !request('campus') ? 'font-bold text-gray-900' : '' }}">Semua Kampus</a>
                @foreach($campuses as $campus)
                    <a href="{{ route('admin.submit-places.index', array_merge(request()->except('page'), ['campus' => $campus->id])) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ request('campus') == $campus->id ? 'font-bold text-gray-900 bg-[#F2E0BE]/30' : '' }}">{{ $campus->name }}</a>
                @endforeach
            </div>
        </div>

        {{-- Filter Kategori --}}
        <div class="relative">
            <button @click="openCategory = !openCategory; openCampus = false" class="px-4 py-2 bg-[#F8F4EC] hover:bg-[#F2E0BE] text-gray-700 font-medium text-sm rounded-lg transition-colors border-none cursor-pointer flex items-center gap-2 {{ request('category') ? 'bg-[#F2E0BE] ring-1 ring-[#D98A2C]' : '' }}">
                {{ request('category') ? str_replace('_', ' ', ucwords(request('category'), '_')) : 'Kategori' }}
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="openCategory" @click.away="openCategory = false" x-transition x-cloak class="absolute top-full left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                <a href="{{ route('admin.submit-places.index', request()->except('category', 'page')) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ !request('category') ? 'font-bold text-gray-900' : '' }}">Semua Kategori</a>
                @foreach($categories as $cat)
                    <a href="{{ route('admin.submit-places.index', array_merge(request()->except('page'), ['category' => $cat])) }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#F2E0BE]/50 no-underline {{ request('category') === $cat ? 'font-bold text-gray-900 bg-[#F2E0BE]/30' : '' }}">{{ str_replace('_', ' ', ucwords($cat, '_')) }}</a>
                @endforeach
            </div>
        </div>

        {{-- Pines UI Status Filter Tabs --}}
        @php
            $status = request('status');
            $tabSelected = match($status) {
                'pending' => 2,
                'approved' => 3,
                'rejected' => 4,
                default => 1,
            };
            $translateClass = match($tabSelected) {
                1 => 'translate-x-0',
                2 => 'translate-x-full',
                3 => 'translate-x-[200%]',
                4 => 'translate-x-[300%]',
            };
        @endphp
        <div x-data="{ tabSelected: {{ $tabSelected }} }" class="relative w-full sm:w-auto">
            
            <div class="relative inline-grid items-center justify-center w-full h-10 grid-cols-4 p-1 text-gray-500 bg-[#F8F4EC] rounded-lg select-none">
                <a href="{{ route('admin.submit-places.index', request()->except('status', 'page')) }}" 
                   @click="tabSelected = 1"
                   class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-xs font-semibold transition-all rounded-md cursor-pointer whitespace-nowrap no-underline"
                   :class="tabSelected == 1 ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900'">
                   Semua
                </a>
                <a href="{{ route('admin.submit-places.index', array_merge(request()->except('page'), ['status' => 'pending'])) }}" 
                   @click="tabSelected = 2"
                   class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-xs font-semibold transition-all rounded-md cursor-pointer whitespace-nowrap no-underline"
                   :class="tabSelected == 2 ? 'text-amber-600' : 'text-gray-500 hover:text-gray-900'">
                   Pending
                </a>
                <a href="{{ route('admin.submit-places.index', array_merge(request()->except('page'), ['status' => 'approved'])) }}" 
                   @click="tabSelected = 3"
                   class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-xs font-semibold transition-all rounded-md cursor-pointer whitespace-nowrap no-underline"
                   :class="tabSelected == 3 ? 'text-emerald-600' : 'text-gray-500 hover:text-gray-900'">
                   Terbit
                </a>
                <a href="{{ route('admin.submit-places.index', array_merge(request()->except('page'), ['status' => 'rejected'])) }}" 
                   @click="tabSelected = 4"
                   class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-xs font-semibold transition-all rounded-md cursor-pointer whitespace-nowrap no-underline"
                   :class="tabSelected == 4 ? 'text-rose-600' : 'text-gray-500 hover:text-gray-900'">
                   Ditolak
                </a>
                
                <div class="absolute left-0 top-0 bottom-0 z-10 w-1/4 duration-300 ease-out p-1 transition-transform {{ $translateClass }}" 
                     :class="{
                         'translate-x-0': tabSelected == 1,
                         'translate-x-full': tabSelected == 2,
                         'translate-x-[200%]': tabSelected == 3,
                         'translate-x-[300%]': tabSelected == 4
                     }">
                    <div class="w-full h-full bg-white rounded-md shadow-sm border border-gray-200/50"></div>
                </div>
            </div>
        </div>

    </div>
    <div class="text-xs text-gray-500 shrink-0">
        Menampilkan {{ $submitPlaces->firstItem() ?? 0 }}–{{ $submitPlaces->lastItem() ?? 0 }} dari {{ $submitPlaces->total() }} hasil
    </div>
</div>
