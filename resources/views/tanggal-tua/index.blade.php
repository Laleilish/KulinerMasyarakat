@extends('layouts.app')

@section('content')

<div class="bg-cream-bg min-h-screen">

    @include('tanggal-tua.search')

    @include('tanggal-tua.hero')

    @include('tanggal-tua.category')

    @include('tanggal-tua.cards')

</div>

@endsection