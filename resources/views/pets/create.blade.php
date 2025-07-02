@extends('components.base-layout')

@section('title', 'Create Pet')

@section('content')
    <section class="p-8">
        <form
            id="create-pet-form"
            method="POST"
            action="{{ route('pets.store') }}"
            enctype="multipart/form-data"
        >
            @csrf
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-gray-900">Create a new pet listing</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">
                        This information will be displayed publicly so please include key details about your pet.
                    </p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                        <div class="">
                            <x-label
                                for="name"
                                required
                            >Name
                            </x-label>
                            <div class="mt-2">
                                <x-input
                                    id="name"
                                    name="name"
                                    placeholder="Buddy"
                                    required
                                />
                            </div>
                            <x-error-field name="name" />
                        </div>

                        <div class="">
                            <x-label
                                for="species"
                                required
                            >Species
                            </x-label>
                            <div class="mt-2">
                                <x-input
                                    id="species"
                                    name="species"
                                    placeholder="Dog, Cat, Bird, ..."
                                    required
                                />
                            </div>
                            <x-error-field name="species" />
                        </div>

                        <div class="">
                            <x-label
                                for="breed"
                                required
                            >Breed
                            </x-label>
                            <div class="mt-2">
                                <x-input
                                    id="breed"
                                    name="breed"
                                    placeholder="Golden Retriever, Siamese, ..."
                                    required
                                />
                            </div>
                            <x-error-field name="breed" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="">
                                <x-label
                                    for="age"
                                    required
                                >Age
                                </x-label>
                                <div class="mt-2">
                                    <x-input
                                        id="age"
                                        name="age"
                                        placeholder="6 weeks, 1 year, ..."
                                        required
                                    />
                                </div>
                                <x-error-field name="age" />
                            </div>

                            <div class="">
                                <x-label
                                    for="gender"
                                    required
                                >Gender
                                </x-label>
                                <x-select-dropdown
                                    name="gender"
                                    selected="Unknown"
                                    :options="['Male', 'Female', 'Unknown']"
                                />
                            </div>
                        </div>

                        <div class="">
                            <x-label
                                for="location"
                                required
                            >Location
                            </x-label>
                            <div class="mt-2">
                                <x-input
                                    id="location"
                                    name="location"
                                    placeholder="Where are you based?"
                                    required
                                />
                            </div>
                            <x-error-field name="location" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="">
                                <x-label for="special_needs">Special Needs</x-label>
                                <div class="mt-2">
                                    <x-input
                                        id="special_needs"
                                        name="special_needs"
                                        placeholder="Blind in one eye, requires medication..."
                                    />
                                </div>
                                <x-error-field name="special_needs" />
                            </div>

                            <div class="">
                                <x-label
                                    for="vaccinated"
                                    required
                                >Vaccinated
                                </x-label>
                                <div class="mt-2">
                                    <div class="flex items-center gap-8 rounded-md bg-white p-2">
                                        <div class="flex items-center">
                                            <input
                                                class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600"
                                                id="yes-vaccinated"
                                                name="vaccinated"
                                                type="radio"
                                                value="true"
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
                                                checked
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
                            <x-label
                                for="vaccination_details"
                                required
                            >Vaccination Details
                            </x-label>
                            <div class="mt-2">
                                <textarea
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base sm:text-sm/6"
                                    id="vaccination_details"
                                    name="vaccination_details"
                                    value="{{ old('vaccination_details') }}"
                                    rows="3"
                                    placeholder="Vaccinated against rabies, distemper, and parvovirus."
                                    maxlength="1000"
                                    minlength="10"
                                    required
                                ></textarea>
                            </div>
                            <x-error-field name="vaccination_details" />
                        </div>


                        <div class="col-span-full">
                            <x-label
                                for="description"
                                required
                            >About
                            </x-label>
                            <div class="mt-2">
                                <textarea
                                    class="block w-full rounded-md bg-white px-3 py-1.5 text-base sm:text-sm/6"
                                    id="description"
                                    name="description"
                                    value="{{ old('description') }}"
                                    rows="3"
                                    placeholder="A friendly dog who loves to play fetch."
                                    maxlength="2000"
                                    minlength="10"
                                    required
                                ></textarea>
                            </div>
                            <x-error-field name="description" />
                            <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences about the pet.</p>
                        </div>

                        <div class="col-span-full">
                            <x-label
                                for="photos"
                                required
                            >Photos
                            </x-label>
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
                >Create Listing</x-button>
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
        const vaccinatedRadios = document.querySelectorAll('input[name="vaccinated"]');
        const container = document.getElementById('vaccination-details-container');
        const detailsInput = document.getElementById('vaccination_details');

        if (document.getElementById('yes-vaccinated').checked) {
            container.classList.remove('hidden');
            detailsInput.required = true;
        } else {
            container.classList.add('hidden');
            detailsInput.required = false;
        }

        vaccinatedRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (document.getElementById('yes-vaccinated').checked) {
                    container.classList.remove('hidden');
                    detailsInput.required = true;
                } else {
                    container.classList.add('hidden');
                    detailsInput.required = false;
                }
            });
        });


        const form = document.getElementById('create-pet-form');
        form.addEventListener('submit', (e) => {
            // Serialize captions map to object
            const captionsObj = {};
            for (const [key, value] of Object.entries(captions)) {
                captionsObj[key] = value;
            }

            // Update hidden input value
            document.getElementById('captions_json').value = JSON.stringify(captionsObj);
        });

        const files = []; // We store the uploaded files here temporarily
        // const captions = []; // and captions here
        const captions = new Map(); // we map file => caption for easier access

        const fileInput = document.getElementById('file-upload');
        const dropZone = document.getElementById('drop-zone');
        const previewZone = document.getElementById('preview-container');

        // Modal
        let currentEditingIndex = null;
        const modal = document.getElementById('caption-modal');
        const modalInput = document.getElementById('caption-modal-input');
        const saveBtn = document.getElementById('caption-save-btn');
        const cancelBtn = document.getElementById('caption-cancel-btn');


        const removeStyles = () => {
            dropZone.classList.add('border-gray-900/25');
            dropZone.classList.remove('bg-gray-200', 'border-gray-900');
        }

        const addStyles = () => {
            dropZone.classList.remove('border-gray-900/25');
            dropZone.classList.add('bg-gray-200', 'border-gray-900');
        }

        const showPreview = (file, index) => {
            const reader = new FileReader();

            reader.onload = (event) => {
                // container
                const wrapper = document.createElement('div');
                wrapper.classList.add('relative', 'group', 'inline-block');

                // image
                const img = document.createElement('img');
                img.src = event.target.result;
                img.draggable = false;
                img.classList.add('w-32', 'h-32', 'rounded-md', 'object-cover', 'm-2');
                img.alt = file.name;

                // buttons
                const removeButton = document.createElement('button');
                removeButton.innerHTML =
                    `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"> <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>`;
                removeButton.type = 'button';
                removeButton.classList.add(
                    'absolute', 'top-0', 'right-0',
                    'bg-red-500', 'rounded-full', 'p-1', '*:text-white',
                    'cursor-pointer', 'shadow',
                    'md:hidden', 'group-hover:md:block', 'block' // show on md and below
                );
                removeButton.addEventListener('click', () => {
                    files.splice(index, 1); // remove from array
                    const key = `${file.name}-${file.size}`;
                    delete captions[key];
                    syncInputFiles();
                    updatePreviews();
                });
                const editButton = document.createElement('button');
                editButton.innerHTML =
                    `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>`;
                editButton.type = 'button';
                editButton.classList.add(
                    'absolute', 'bottom-12', 'right-12', 'md:hidden', 'block', 'group-hover:md:block',
                    'bg-gray-300/50', 'rounded-full', 'text-xs', 'p-3', 'cursor-pointer',
                    'hover:bg-gray-300/75'
                );
                editButton.addEventListener('click', () => {
                    currentEditingIndex = index;
                    const key = `${file.name}-${file.size}`;
                    modalInput.value = captions[key] || '';

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        document.getElementById('caption-modal-image').src = e.target.result;
                        modal.classList.add('flex');
                        modal.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                });


                wrapper.appendChild(img);
                wrapper.appendChild(removeButton);
                wrapper.appendChild(editButton);
                previewZone.appendChild(wrapper);
            }

            if (file.type.startsWith('image/')) {
                reader.readAsDataURL(file);
            }
        }

        // helper to regenerate all previews
        const updatePreviews = () => {
            previewZone.innerHTML = ''; // Clear all previews
            files.forEach((file, i) => showPreview(file, i));
        };

        // helper to sync input element
        const syncInputFiles = () => {
            const dataTransfer = new DataTransfer();
            files.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        };

        dropZone.addEventListener('dragover', (event) => {
            const items = event.dataTransfer.items;
            const isOnlyImages = [...items].every(item =>
                item.kind === 'file' && item.type.startsWith('image/')
            );

            if (isOnlyImages) {
                event.preventDefault(); // Allow drop
                addStyles();
            } else {
                removeStyles(); // reset styling if invalid drag
            }
        });

        dropZone.addEventListener('dragleave', removeStyles);

        dropZone.addEventListener('drop', (event) => {
            event.preventDefault(); // same thing, prevent from being opened
            const items = event.dataTransfer.items;

            if (items) {
                [...items].forEach((item) => {
                    if (item.kind === 'file' && item.type.startsWith('image/')) {
                        const file = item.getAsFile();

                        // avoid duplicates
                        const exists = files.some(f => f.name === file.name && f.size === file.size);
                        if (!exists) {
                            files.push(file);
                        }
                    }
                });
            }

            syncInputFiles();
            updatePreviews();
            removeStyles();
        });

        // another thing to worry about is to also listen to the input
        // so we update the previews when the user just uses the input
        fileInput.addEventListener('change', (event) => {
            const selected = [...event.target.files];

            selected.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const exists = files.some(f => f.name === file.name && f.size === file.size);
                    if (!exists) {
                        files.push(file);
                    }
                }
            });

            syncInputFiles();
            updatePreviews();
        });

        // Modal button logic
        saveBtn.addEventListener('click', () => {
            if (currentEditingIndex !== null) {
                const file = files[currentEditingIndex];
                const key = `${file.name}-${file.size}`;
                captions[key] = modalInput.value;

                modal.classList.remove('flex');
                modal.classList.add('hidden');
                updatePreviews();
                currentEditingIndex = null;
            }
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            currentEditingIndex = null;
        });
    </script>
@endpush
