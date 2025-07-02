@extends('components.base-layout')

@section('title', 'PawPal - Pets')
@section('header')
    <x-Navbar />
@endsection

@section('content')
    <h1>Available Pets</h1>
    <section class="container *:mx-auto">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($pets as $pet)
                <x-pet-card :pet="$pet" />
            @endforeach
            {{ $pets->links() }}
        </div>
    </section>
@endsection
