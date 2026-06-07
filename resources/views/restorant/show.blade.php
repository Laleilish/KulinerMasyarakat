@extends('layouts.app')
@section('title', $restaurant->name)

@section('content')
<div class="min-h-screen bg-[#FDF8F0] pb-12">

    @include('restorant.partials.hero')

    @include('restorant.partials.mobile-actions')

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-4 md:px-6 md:mt-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">

            {{-- LEFT COLUMN --}}
            <div class="md:col-span-2 flex flex-col gap-8">

                {{-- Desktop: About --}}
                <div class="hidden md:block">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">About</h2>
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <p class="text-gray-600 leading-relaxed text-[15px]">{{ $restaurant->description ?? 'Deskripsi belum tersedia.' }}</p>
                    </div>
                </div>

                {{-- Mobile: About--}}
                <div class="md:hidden bg-white rounded-3xl p-5 shadow-sm border border-gray-100 mb-2">
                    <h2 class="text-xl font-bold text-gray-800 mb-3">About</h2>
                    <p class="text-gray-600 text-[15px] leading-relaxed mb-6">{{ $restaurant->description ?? 'Deskripsi belum tersedia.' }}</p>

                    <h3 class="font-bold text-gray-800 mb-4 text-base">Info Detail</h3>
                    @include('restorant.partials.info-detail')
                </div>

                {{-- Ulasan Section --}}
                <div x-data="{ showForm: false, previewImage: null }">
                    {{-- Header Ulasan --}}
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Ulasan</h2>
                        @auth
                            @if(!$hasReviewed)
                                <button @click="showForm = !showForm"
                                        class="px-5 py-2 bg-[#00A896] hover:bg-[#028c7d] text-white text-sm font-bold rounded-full flex items-center gap-2 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    <span x-text="showForm ? 'Batal' : 'Tulis Ulasan'"></span>
                                </button>
                            @endif
                        @endauth
                    </div>

                    {{-- Form Tulis Ulasan --}}
                    @auth
                        @if(!$hasReviewed)
                            @include('restorant.partials.review-form')
                        @endif
                    @endauth

                    {{-- List Ulasan --}}
                    <div class="flex flex-col gap-4">
                        @forelse($restaurant->reviews->sortByDesc('created_at') as $review)
                            @include('restorant.partials.review-item', ['review' => $review])
                        @empty
                            <div class="bg-white rounded-3xl border border-gray-100 p-8 text-center shadow-sm">
                                <p class="text-gray-500">Belum ada ulasan. Jadilah yang pertama!</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Image Preview Modal (Lightbox) --}}
                    <div x-show="previewImage" 
                         style="display: none;"
                         x-transition.opacity.duration.300ms
                         class="fixed inset-0 z-[5000] bg-black/90 flex items-center justify-center p-4 backdrop-blur-sm"
                         @click="previewImage = null"
                         @keydown.escape.window="previewImage = null">
                         
                        <button @click="previewImage = null" class="absolute top-4 right-4 md:top-6 md:right-6 text-white hover:text-gray-300 w-10 h-10 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded-full transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                        
                        <img :src="previewImage" 
                             @click.stop
                             class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" 
                             alt="Preview Ulasan">
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: Info Detail (Desktop, sticky) --}}
            <div class="hidden md:block col-span-1">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 sticky top-8">
                    <h3 class="font-bold text-gray-800 text-[15px] mb-5">Info Detail</h3>
                    @include('restorant.partials.info-detail')
                </div>
            </div>

        </div>
    </div>
</div>

@include('restorant.partials.delete-modal')

{{-- Salin Link --}}
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-6 py-3 rounded-full text-sm font-semibold opacity-0 transition-opacity duration-300 pointer-events-none z-50 shadow-xl">
    Tautan disalin ke clipboard!
</div>

<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).catch(() => {});
    const toast = document.getElementById('toast');
    toast.classList.remove('opacity-0');
    toast.classList.add('opacity-100');
    setTimeout(() => {
        toast.classList.remove('opacity-100');
        toast.classList.add('opacity-0');
    }, 2200);
}
</script>
@endsection