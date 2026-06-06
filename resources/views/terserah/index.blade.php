@extends('layouts.app')

@section('content')

<style>
    @media (max-width: 767px) {
        nav,
        footer {
            display: none !important;
        }
    }
</style>

<div class="flex h-[52px] items-center gap-3 bg-[#F8E8D0] px-5 shadow-md md:hidden">
    <a href="{{ route('home') }}" class="flex items-center justify-center">
        <i class="ri-arrow-left-line text-[26px] text-dark"></i>
    </a>

    <h1 class="text-[18px] font-extrabold text-dark">
        Terserah
    </h1>
</div>

@include('terserah.content')

{{-- JS --}}
<script src="{{ asset('assets/js/terserah-script.js') }}"></script>

@endsection