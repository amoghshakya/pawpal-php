@extends('components.base-layout')

@section('title', 'PawPal - Home')

@section('header')
    <x-Navbar />
@endsection

@section('content')
    <section
        class="h-screen items-center pt-24 *:m-auto"
        id="home-banner"
    >
        <div class="container flex flex-col items-center justify-center gap-4 p-8 text-center">
            <h1 class="md:text-6xl! text-center">Meet your new best friend today.</h1>
            <img
                class="drop-shadow-2xl md:-mt-20 md:w-1/3"
                src="{{ asset('images/dog-png-22648.png') }}"
                alt="Dog Image"
                draggable="false"
            />
        </div>
    </section>
    <section class="h-screen">
    </section>
@endsection
