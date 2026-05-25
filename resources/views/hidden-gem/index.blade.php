@extends('layouts.app')

@section('title', 'Hidden Gem - KUMAR')

@section('content')
    @include('hidden-gem.search')
    @include('hidden-gem.kampus')
    @include('hidden-gem.map')
    @include('hidden-gem.rating')
@endsection