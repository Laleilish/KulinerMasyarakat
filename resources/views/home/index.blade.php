@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

<div class="max-w-[1400px] mx-auto w-full">
    {{-- HERO --}}
    @include('home.hero')

    {{-- CATEGORY --}}
    @include('home.category')

    {{-- RESTO --}}
    @include('home.resto')
</div>

@endsection