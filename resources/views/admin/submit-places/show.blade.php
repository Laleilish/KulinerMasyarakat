@extends('layouts.admin')
@section('title', 'Detail Usulan Tempat')

@section('content')
<div class="space-y-6">
    {{-- Back Link --}}
    <div>
        <a href="{{ session('admin_submit_places_url', route('admin.submit-places.index')) }}" class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-emerald-600 transition-colors no-underline">
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

{{-- Modal Alasan Penolakan --}}
<div x-data="{
        open: false,
        placeId: null,
        placeName: '',
        reason: '',
        init() {
            window.addEventListener('open-reject-modal', (e) => {
                this.placeId = e.detail.placeId;
                this.placeName = e.detail.placeName;
                this.reason = '';
                this.open = true;
            });
        }
    }"
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
    @keydown.escape.window="open = false"
    @click.self="open = false"
>
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="bg-white rounded-2xl shadow-xl w-full max-w-md">
        <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-gray-900">Tolak Usulan Tempat</h3>
                <p class="text-xs text-gray-500 mt-0.5">Isi alasan penolakan yang akan dikirim ke pengguna.</p>
            </div>
            <button type="button" @click="open = false" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors bg-transparent border-none cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form :action="`{{ url('admin/submit-places') }}/${placeId}/reject`" method="POST">
            @csrf
            @method('PATCH')

            <div class="px-6 py-5">
                <div class="mb-4 px-3 py-2.5 bg-rose-50 border border-rose-100 rounded-xl">
                    <p class="text-xs text-rose-700">
                        Kamu akan menolak usulan: <span class="font-bold" x-text="placeName"></span>
                    </p>
                </div>

                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                    Alasan Penolakan <span class="text-rose-500">*</span>
                </label>
                <textarea
                    name="rejection_reason"
                    x-model="reason"
                    rows="4"
                    placeholder="Contoh: Foto kurang jelas, alamat tidak lengkap, dll."
                    class="w-full border border-gray-200 rounded-xl text-sm text-gray-700 p-3 focus:ring-[#B87A29] focus:border-[#B87A29] resize-none"
                    required
                ></textarea>
                <p class="text-xs text-gray-400 mt-1" x-text="`${reason.length}/1000 karakter`"></p>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" @click="open = false"
                        class="px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                        :disabled="reason.trim().length === 0"
                        class="px-4 py-2 text-sm font-semibold text-white bg-rose-500 border border-rose-500 rounded-xl hover:bg-rose-600 transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                    Tolak Usulan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
