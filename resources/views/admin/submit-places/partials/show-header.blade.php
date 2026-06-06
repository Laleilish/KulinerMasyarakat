{{-- Photo Header --}}
<div class="relative h-64 sm:h-80 bg-gray-150">
    @if($submitPlace->photo)
        <img src="{{ Storage::url($submitPlace->photo) }}" alt="{{ $submitPlace->name }}" class="w-full h-full object-cover">
    @else
        <div class="w-full h-full bg-emerald-50 flex items-center justify-center text-emerald-300 text-3xl font-extrabold">
            KUMAR
        </div>
    @endif
    
    <div class="absolute top-4 right-4">
        @if($submitPlace->status === 'pending')
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100 shadow-sm">
                <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                Pending
            </span>
        @elseif($submitPlace->status === 'approved')
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm">
                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                Disetujui
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100 shadow-sm">
                <span class="w-2 h-2 bg-rose-500 rounded-full"></span>
                Ditolak
            </span>
        @endif
    </div>
</div>
