@props(['pet'])

<div class="rounded-lg bg-white p-4 shadow-md">
    <div class="flex items-center space-x-4">
        @php
            // This should never happen, but just in case
            if (isset($pet->images[0])) {
                $imagePath = asset('storage/' . $pet->images[0]->image_path);
            } else {
                $imagePath = asset('images/default-pet.png'); // Fallback image
            }
        @endphp
        <img
            class="md:w-3xl h-auto w-[80vw] rounded-md object-cover"
            src="{{ asset('storage/' . $pet->images[0]->image_path) }}"
            alt="{{ $pet->name }}'s image"
        />
    </div>
    <div class="mt-4">
        <h3 class="text-xl font-semibold text-gray-900">
            {{ $pet->name }}
        </h3>
        <p class="text-gray-700">{{ $pet->description }}</p>
    </div>
    <div class="mt-2 space-y-2">
        <x-badge>
            {{ $pet->species }}
        </x-badge>
        <x-badge variant="primary">
            {{ $pet->breed }}
        </x-badge>
        <x-badge variant="secondary">
            {{ $pet->age }} years old
        </x-badge>
        <x-badge variant="{{ $pet->status === 'available' ? 'success' : 'stale' }}">
            {{ ucwords($pet->status) }}
        </x-badge>
    </div>
    <div class="mt-4">
        <a
            class="text-blue-500 hover:underline"
            href="{{ route('pets.show', $pet->id) }}"
        >
            View Details
        </a>
    </div>
</div>
