@extends('components.base-layout')

@section('title', 'Pet Details')

@section('header')
    <x-navbar />
@endsection

@section('content')
    <section class="p-2 md:p-6">
        <div class="grid grid-cols-1 md:grid-cols-[40vw_1fr]">
            <div class="p-4">
                <x-carousel :images="$pet->images" />
            </div>
            <div class="p-4">
                <div class="mb-2 flex items-center justify-between">
                    <div>
                        <h1 class="mb-2 text-2xl font-bold">{{ $pet->name }}</h1>
                        <span class="text-primary text-xl font-semibold">
                            {{ $pet->species }}
                        </span>
                    </div>
                </div>
                <div>
                    <p class="text-muted mb-4 text-sm">
                        Listed by <span class="font-semibold">{{ $pet->lister->name }}</span>
                        on <span class="font-semibold">{{ $pet->created_at->format('F j, Y') }}</span>
                    </p>
                </div>
                <div class="mb-4">
                    <h4 class="text-lg font-semibold">Description</h2>
                        <pre class="whitespace-break-spaces font-sans text-sm text-gray-700">{{ $pet->description ?? 'No description provided.' }}</pre>
                </div>
                <div class="flex flex-col gap-4 text-sm">
                    <h4 class="mb-2 mt-6 text-lg font-semibold">Details</h4>
                    <div class="grid grid-cols-1 gap-x-8 gap-y-2 text-sm text-gray-700 sm:grid-cols-2">
                        <div><span class="font-semibold">Breed:</span> {{ $pet->breed ?? 'Unknown' }}</div>
                        <div><span class="font-semibold">Age:</span> {{ $pet->age ?? 'Unknown' }}</div>
                        <div><span class="font-semibold">Gender:</span> {{ ucfirst($pet->gender) }}</div>
                        <div><span class="font-semibold">Vaccinated:</span> {{ $pet->vaccinated ? 'Yes' : 'No' }}</div>
                        @if ($pet->vaccinated && $pet->vaccination_details)
                            <div class="sm:col-span-2"><span class="font-semibold">Vaccination Details:</span>
                                <pre class="mt-1 whitespace-pre-wrap font-sans text-sm">{{ $pet->vaccination_details }}</pre>
                            </div>
                        @endif
                        @if ($pet->special_needs)
                            <div class="sm:col-span-2"><span class="font-semibold">Special Needs:</span>
                                <pre class="mt-1 whitespace-pre-wrap font-sans text-sm text-red-700">{{ $pet->special_needs }}</pre>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
