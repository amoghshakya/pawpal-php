@extends('components.base-layout')

@section('title', 'PawPal - Pets')
@section('header')
    <x-Navbar />
@endsection

@section('content')
    <h1>Available Pets</h1>
    <section class="*:mx-auto">
        <div class="container">
            @foreach ($pets as $pet)
                <div class="">
                    {{ $pet->name }} - {{ $pet->species }}
                </div>
            @endforeach
            {{ $pets->links() }}
        </div>
    </section>
@endsection
