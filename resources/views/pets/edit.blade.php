@php
    $vaccinated = $pet->vaccinated;
    $photos = $pet->images
        ->map(function ($image) {
            return [
                'image_path' => asset('storage/' . $image->image_path),
                'caption' => $image->caption,
                'id' => $image->id,
            ];
        })
        ->toArray();
@endphp

@extends('components.base-layout')

@section('title', "Edit Listing for $pet->name")

@section('content')
    <x-banner variant="{{ $pet->status === 'available' ? 'default' : 'warning' }}">
        <div class="flex flex-col items-center justify-center gap-2 md:flex-row md:justify-between">
            <p class="px-2 text-sm/6 md:w-2/3">
                @if ($pet->status === 'available')
                    This listing is currently set as available for adoption. Please ensure all details are
                    accurate before
                    updating.
                @else
                    This listing is currently set as adopted. Users will not be able to apply for adoption while it is
                    marked as adopted.
                @endif
            </p>
            <div class="flex items-center gap-2">
                <form
                    id="toggle-status-form"
                    method="POST"
                    action="{{ route('pets.update.status', $pet) }}"
                >
                    @csrf
                    @method('PATCH')
                    @if ($pet->status === 'available')
                        <input
                            name="status"
                            type="hidden"
                            value="adopted"
                        />
                        <x-button
                            type="submit"
                            variant="secondary"
                        >
                            @svg('heroicon-o-check-circle', 'size-5')
                            Mark as adopted
                        </x-button>
                    @else
                        <input
                            name="status"
                            type="hidden"
                            value="available"
                        />
                        <x-button
                            type="submit"
                            variant="secondary"
                        >
                            @svg('heroicon-o-plus-circle', 'size-5')
                            Mark as available
                        </x-button>
                    @endif
                </form>
                <x-button
                    id="delete-listing-button"
                    variant="danger"
                >
                    @svg('heroicon-o-trash', 'size-5')
                    Delete Listing
                </x-button>
            </div>
        </div>
    </x-banner>

    {{-- Delete confirmation modal --}}
    <x-modal
        id="delete-confirmation-modal"
        title="Delete {{ $pet->name }} listing?"
    >
        <form
            class="flex flex-col items-center justify-center gap-4"
            method="POST"
            action="{{ route('pets.delete', $pet) }}"
        >
            @csrf
            @method('DELETE')
            <p class="text-sm/6 text-gray-600">
                Are you sure you want to delete this listing? This action cannot be undone.
            </p>
            <div class="flex w-full items-center gap-2">
                <x-button
                    variant="secondary"
                    onclick="document.getElementById('delete-confirmation-modal').classList.add('hidden')"
                >Cancel</x-button>
                <x-button
                    type="submit"
                    variant="danger"
                >Delete</x-button>
            </div>
        </form>
    </x-modal>

    <section class="p-8">
        <form
            id="create-pet-form"
            method="POST"
            action="{{ route('pets.update', $pet) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-gray-900">Edit Details for {{ $pet->name }}</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">
                        This information will be displayed publicly so please include key details about your pet.
                    </p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                        <div class="">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="name"
                            >Name
                                <span class="text-accent text-xs/snug">*</span>
                            </label>
                            <div class="mt-2">
                                <x-input
                                    id="name"
                                    name="name"
                                    value="{{ $pet->name }}"
                                    placeholder="Buddy"
                                    required
                                />
                            </div>
                            <x-error-field name="name" />
                        </div>

                        <div class="">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="species"
                            >Species
                                <span class="text-accent text-xs/snug">*</span>
                            </label>
                            <div class="mt-2">
                                <x-input
                                    id="species"
                                    name="species"
                                    value="{{ $pet->species }}"
                                    placeholder="Dog, Cat, Bird, ..."
                                    required
                                />
                            </div>
                            <x-error-field name="species" />
                        </div>

                        <div class="">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="breed"
                            >Breed
                                <span class="text-accent text-xs/snug">*</span>
                            </label>
                            <div class="mt-2">
                                <x-input
                                    id="breed"
                                    name="breed"
                                    value="{{ $pet->breed }}"
                                    placeholder="Golden Retriever, Siamese, ..."
                                    required
                                />
                            </div>
                            <x-error-field name="breed" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="">
                                <label
                                    class="block text-sm/6 font-medium text-gray-900"
                                    for="age"
                                >Age
                                    <span class="text-accent text-xs/snug">*</span>
                                </label>
                                <div class="mt-2">
                                    <x-input
                                        id="age"
                                        name="age"
                                        value="{{ $pet->age }}"
                                        placeholder="6 weeks, 1 year, ..."
                                        required
                                    />
                                </div>
                                <x-error-field name="age" />
                            </div>

                            <div class="">
                                <label
                                    class="block text-sm/6 font-medium text-gray-900"
                                    for="gender"
                                >Gender
                                    <span class="text-accent text-xs/snug">*</span>
                                </label>
                                <x-select-dropdown
                                    name="gender"
                                    selected="{{ ucwords($pet->gender) }}"
                                    :options="['Male', 'Female', 'Unknown']"
                                />
                            </div>
                        </div>

                        <div class="">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="location"
                            >Location
                                <span class="text-accent text-xs/snug">*</span>
                            </label>
                            <div class="mt-2">
                                <x-input
                                    id="location"
                                    name="location"
                                    value="{{ $pet->location }}"
                                    placeholder="Where are you based?"
                                    required
                                />
                            </div>
                            <x-error-field name="location" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="">
                                <label
                                    class="block text-sm/6 font-medium text-gray-900"
                                    for="special_needs"
                                >Special Needs</label>
                                <div class="mt-2">
                                    <x-input
                                        id="special_needs"
                                        name="special_needs"
                                        value="{{ $pet->special_needs }}"
                                        placeholder="Blind in one eye, requires medication..."
                                    />
                                </div>
                                <x-error-field name="special_needs" />
                            </div>

                            <div class="">
                                <label
                                    class="block text-sm/6 font-medium text-gray-900"
                                    for="vaccinated"
                                >Vaccinated
                                    <span class="text-accent text-xs/snug">*</span>
                                </label>
                                <div class="mt-2">
                                    <div class="flex items-center gap-8 rounded-md bg-white p-2">
                                        <div class="flex items-center">
                                            <input
                                                class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600"
                                                id="yes-vaccinated"
                                                name="vaccinated"
                                                type="radio"
                                                value="true"
                                                {{ $vaccinated === 1 ? 'checked' : '' }}
                                            >
                                            <label
                                                class="ms-2 text-sm font-medium text-gray-900"
                                                for="yes-vaccinated"
                                            >Yes</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input
                                                class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600"
                                                id="no-vaccinated"
                                                name="vaccinated"
                                                type="radio"
                                                value="false"
                                                {{ $vaccinated === 0 ? 'checked' : '' }}
                                            >
                                            <label
                                                class="ms-2 text-sm font-medium text-gray-900"
                                                for="no-vaccinated"
                                            >No</label>
                                        </div>
                                    </div>
                                </div>
                                <x-error-field name="vaccinated" />
                            </div>
                        </div>

                        <div
                            class="col-span-full hidden"
                            id="vaccination-details-container"
                        >
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="vaccination_details"
                            >Vaccination Details
                                <span class="text-accent text-xs/snug">*</span>
                            </label>
                            <div class="mt-2">
                                <textarea
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base sm:text-sm/6"
                                    id="vaccination_details"
                                    name="vaccination_details"
                                    rows="3"
                                    placeholder="Vaccinated against rabies, distemper, and parvovirus."
                                    maxlength="1000"
                                    minlength="10"
                                    required
                                >{{ $pet->vaccination_details }}</textarea>
                            </div>
                            <x-error-field name="vaccination_details" />
                        </div>


                        <div class="col-span-full">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="description"
                            >About
                                <span class="text-accent text-xs/snug">*</span>
                            </label>
                            <div class="mt-2">
                                <textarea
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base sm:text-sm/6"
                                    id="description"
                                    name="description"
                                    rows="3"
                                    placeholder="A friendly dog who loves to play fetch."
                                    maxlength="2000"
                                    minlength="10"
                                    required
                                >{{ $pet->description }}</textarea>
                            </div>
                            <x-error-field name="description" />
                            <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences about the pet.</p>
                        </div>

                        <div class="col-span-full">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="photos"
                            >Photos
                                <span class="text-accent text-xs/snug">*</span>
                            </label>
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 transition"
                                id="drop-zone"
                            >
                                <div class="text-center">
                                    @svg('heroicon-o-photo', 'mx-auto size-12 text-gray-300')
                                    <div class="mt-4 flex text-sm/6 text-gray-600">
                                        <label
                                            class="focus-within:outline-hidden relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500"
                                            for="file-upload"
                                        >
                                            <span>Upload a file</span>
                                            <input
                                                class="sr-only"
                                                id="file-upload"
                                                name="photos[]"
                                                type="file"
                                                accept="image/png, image/jpeg"
                                                multiple
                                            />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs/5 text-gray-600">PNG or JPG up to 10MB</p>
                                </div>
                            </div>
                            <x-error-field name="photos" />

                            <div
                                class="flex gap-2"
                                id="preview-container"
                            >
                            </div>
                        </div>
                    </div>
                </div>
                <input
                    id="captions_json"
                    name="captions_json"
                    type="hidden"
                    value=""
                />
                <x-button
                    type="submit"
                    variant="primary"
                >Update</x-button>
        </form>
    </section>
    <x-modal
        id="caption-modal"
        title="Edit Image Caption"
    >
        <div class="flex flex-col rounded-lg bg-white shadow-lg">
            {{-- Preview --}}
            <img
                class="aspect-4/3 mb-3 rounded-md object-cover shadow"
                id="caption-modal-image"
                src="#"
                alt="Image preview"
            />
            <x-input
                class="mb-4"
                id="caption-modal-input"
                type="text"
                placeholder="Enter caption..."
            />
            <div class="flex justify-end space-x-2">
                <x-button
                    id="caption-cancel-btn"
                    type="button"
                    variant="secondary"
                >Cancel</x-button>
                <x-button
                    id="caption-save-btn"
                    type="button"
                    variant="primary"
                >Save</x-button>
            </div>
        </div>
    </x-modal>

@endsection

@push('scripts')
    <script>
        const deleteConfirmationModal = document.getElementById('delete-confirmation-modal');
        const deleteListingButton = document.getElementById('delete-listing-button');

        deleteListingButton.addEventListener('click', function() {
            deleteConfirmationModal.classList.remove('hidden');
        });
    </script>
    {{-- Get existing images --}}
    <script>
        const existingImages = @json($photos);
        const existingImageWrappers = new Map(); // key: photo ID, value: wrapper div
    </script>
    @vite('resources/js/pets/edit.js')
@endpush
