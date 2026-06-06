@extends('layouts.app')

@section('content')

    {{-- HERO --}}
    @include('home.hero')

    {{-- CATEGORY --}}
    @include('home.category')

    {{-- RESTO --}}
    @include('home.resto')

@endsection