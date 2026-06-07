@extends('layouts.app')
@section('title', 'Semua Restoran')

@section('content')

<div class="bg-[#FCF5E9] min-h-screen pb-8 font-sans text-dark">

    @include('semua-resto.cards')

</div>

@endsection