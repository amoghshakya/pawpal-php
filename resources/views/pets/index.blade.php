@extends('components.base-layout')

@section('title', 'PawPal - Pets')
@section('header')
    <x-Navbar />
@endsection

@section('content')
    <h1>Available Pets</h1>
    <ul>
        {{-- TODO: UI --}}
        @forelse ($pets as $pet)
            <li>
                <strong>{{ $pet->name }}</strong> ({{ $pet->species }})<br>
                Breed: {{ $pet->breed ?? 'N/A' }}<br>
                Age: {{ $pet->age }}<br>
                Gender: {{ ucfirst($pet->gender) ?? 'Unknown' }}<br>
                Description: {{ $pet->description ?? 'No description' }}
            </li>
        @empty
            <li>No pets available.</li>
        @endforelse
    </ul>
@endsection
