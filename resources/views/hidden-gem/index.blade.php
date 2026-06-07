@extends('layouts.app')
@section('title', 'Hidden Gem')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
@endpush

@section('content')
    @include('hidden-gem.search')
    @include('hidden-gem.kampus')
    @include('hidden-gem.map')
    @include('hidden-gem.rating')
    
    @include('hidden-gem.fs-map')
@endsection

@include('hidden-gem.styles')
@include('hidden-gem.scripts')