@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-[#FDF8F0] py-12 flex items-center justify-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex flex-col md:flex-row gap-8 md:gap-16 lg:gap-64 items-center">
            
            <!-- Left Side Information -->
            <div class="w-full md:w-1/2 flex justify-center md:justify-end">
                <div class="max-w-md w-full">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-800 mb-2 tracking-tight">
                        Punya Info
                    </h1>
                    <div class="bg-white inline-block px-4 py-2 md:px-6 md:py-3 rounded-2xl shadow-sm mb-6">
                        <span class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#9e1c1f]">Hidden Gem?</span>
                    </div>
                    <p class="text-gray-500 text-base md:text-lg lg:text-xl leading-relaxed">
                        Bantu yang lain nemuin tempat makan enak, porsi kuli, dan ramah di kantong akhir bulan
                    </p>
                </div>
            </div>

            <!-- Right Side Form -->
            <div class="w-full md:w-1/2 flex justify-center md:justify-start mt-8 md:mt-0">
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] w-full max-w-md p-6 md:p-8" 
                     x-data="submitPlaceForm()">
                    
                    @include('submit-place.partials.progress-bar')

                    <form action="{{ route('submit-places.store') }}" method="POST" enctype="multipart/form-data" x-ref="submitForm">
                        @csrf
                        
                        @include('submit-place.partials.step-1')

                        @include('submit-place.partials.step-2')

                        @include('submit-place.partials.step-3')

                    </form>
                </div>
            </div>
            
        </div>
    </div>

@include('submit-place.partials.scripts')

@endsection
