@extends('components.base-layout')

@section('title', 'Pet Details')

@section('header')
    <x-navbar />
@endsection

@section('content')
    <section class="p-2 md:p-6">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-4">
                <x-carousel :images="$pet->images" />
            </div>
            <div class="p-4">
                <div class="mb-2 flex items-center justify-between">
                    <h1 class="mb-2 text-2xl font-bold">{{ $pet->name }}</h1>
                    <span class="text-primary text-xl font-semibold">
                        {{ $pet->species }}
                    </span>
                </div>
                <div>
                    <p class="text-muted mb-4 text-sm">
                        Listed by <span class="font-semibold">{{ $pet->lister->name }}</span>
                        on <span class="font-semibold">{{ $pet->created_at->format('F j, Y') }}</span>
                    </p>
                </div>
                <div class="mb-4">
                    <h4 class="text-lg font-semibold">Description</h2>
                        <p class="text-gray-700">
                            {{ $pet->description ?? 'No description provided.' }}
                        </p>
                </div>
                <div class="flex flex-col gap-4 text-sm text-gray-600">
                    <div><strong>Breed:</strong> {{ $pet->breed ?? 'Unknown' }}</div>
                    <div><strong>Age:</strong> {{ $pet->age }} years</div>
                    <div><strong>Gender:</strong> {{ ucfirst($pet->gender) }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
