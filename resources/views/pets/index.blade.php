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
                {{-- <div class="">
                    <img
                        class="h-auto w-10"
                        src="{{ asset('storage/' . $pet->images[0]->image_path) }}"
                        alt="{{ $pet->name }}'s image"
                    />
                    {{ $pet->name }} - {{ $pet->species }}
                </div> --}}
            @endforeach
            {{ $pets->links() }}
        </div>
    </section>
@endsection
