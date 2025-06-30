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
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="name"
                            >Name</label>
                            <div class="mt-2">
                                <div class="flex items-center rounded-md bg-white">
                                    <input
                                        class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        id="name"
                                        name="name"
                                        type="text"
                                        value="{{ old('name') }}"
                                        placeholder="Buddy"
                                        required
                                    />
                                </div>
                            </div>
                            @error('name')
                                <span class="text-xs/snug font-semibold text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="species"
                            >Species</label>
                            <div class="mt-2">
                                <div class="flex items-center rounded-md bg-white">
                                    <input
                                        class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        id="species"
                                        name="species"
                                        type="text"
                                        value="{{ old('species') }}"
                                        placeholder="Dog"
                                        required
                                    />
                                </div>
                            </div>
                            @error('species')
                                <span class="text-xs/snug font-semibold text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="breed"
                            >Breed</label>
                            <div class="mt-2">
                                <div class="flex items-center rounded-md bg-white">
                                    <input
                                        class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        id="breed"
                                        name="breed"
                                        type="text"
                                        value="{{ old('breed') }}"
                                        placeholder="Golden Retriever"
                                        required
                                    />
                                </div>
                            </div>
                            @error('breed')
                                <span class="text-xs/snug font-semibold text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="">
                                <label
                                    class="block text-sm/6 font-medium text-gray-900"
                                    for="age"
                                >Age</label>
                                <div class="mt-2">
                                    <div class="flex items-center rounded-md bg-white">
                                        <input
                                            class="block min-w-0 grow py-1.5 pl-1 pr-3 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                            id="age"
                                            name="age"
                                            type="number"
                                            value="{{ old('age') }}"
                                            min="0"
                                            placeholder="2"
                                            required
                                        />
                                    </div>
                                </div>
                                @error('age')
                                    <span class="text-xs/snug font-semibold text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="">
                                <label
                                    class="block text-sm/6 font-medium text-gray-900"
                                    for="gender"
                                >Gender</label>
                                <x-select-dropdown
                                    name="gender"
                                    selected="Unknown"
                                    :options="['Male', 'Female', 'Unknown']"
                                />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="description"
                            >About</label>
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
                            @error('description')
                                <span class="text-xs/snug font-semibold text-red-500">{{ $message }}</span>
                            @enderror
                            <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences about the pet.</p>
                        </div>

                        <div class="col-span-full">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="photos"
                            >Photos</label>
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
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
                            @error('photos')
                                <span class="text-xs/snug font-semibold text-red-500">{{ $message }}</span>
                            @enderror

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
                >ok</x-button>
        </form>
    </section>
    <div
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50"
        id="caption-modal"
    >
        <div class="m-auto rounded-lg bg-white p-4 shadow-lg md:w-1/2">
            <h4 class="font-body mb-2 text-lg font-medium">Edit Caption</h4>
            {{-- Preview --}}
            <img
                class="mx-auto mb-3 aspect-auto h-[70dvh] w-full rounded-md object-cover shadow"
                id="caption-modal-image"
                src="#"
                alt="Image preview"
            />
            <input
                class="mb-4 w-full rounded-md border px-3 py-2 text-sm"
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
    </div>


@endsection

@push('scripts')
    <script>
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
                removeButton.classList.add('absolute', 'top-0', 'right-0', 'hidden', 'group-hover:block',
                    'bg-red-500', 'rounded-full', 'p-0', 'group-hover:*:text-bg', 'cursor-pointer',
                    'group-hover:*:shadow');
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
                    'absolute', 'bottom-12', 'right-12', 'hidden', 'group-hover:block',
                    'bg-gray-300/50', 'rounded-full', 'text-xs', 'p-3', 'cursor-pointer',
                    'hover:bg-gray-300/75'
                );
                editButton.addEventListener('click', () => {
                    currentEditingIndex = index;
                    modalInput.value = captions[file.name] || '';

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
