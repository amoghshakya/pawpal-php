// Vaccination Radio Logic
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

// File Upload and Editing Logic
const form = document.getElementById('create-pet-form');

const files = []; // We store the uploaded files here temporarily
const updateCaptions = new Map(); // we map file => caption for easier access
const newCaptions = new Map(); // for new files

const fileInput = document.getElementById('file-upload');
const dropZone = document.getElementById('drop-zone');
const previewZone = document.getElementById('preview-container');

// Fill in existing images if any
existingImages.forEach((photo, index) => {
    const wrapper = document.createElement('div');
    wrapper.classList.add('relative', 'group', 'inline-block');

    existingImageWrappers.set(photo.id, wrapper);

    const img = document.createElement('img');
    img.src = photo.image_path;
    img.classList.add('w-32', 'h-32', 'rounded-md', 'object-cover', 'm-2');
    img.draggable = false;

    // Delete existing images
    const removeButton = document.createElement('button');
    removeButton.innerHTML =
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"> <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>';
    removeButton.classList.add(
        'absolute', 'top-0', '-right-3', 'md:right-0',
        'bg-red-500', 'rounded-full', 'p-0', 'md:p-1', '*:text-white',
        'cursor-pointer', 'shadow',
        'md:hidden', 'group-hover:md:block', 'block' // show on md and below
    );
    removeButton.type = 'button';
    removeButton.addEventListener('click', () => {
        wrapper.remove();
        existingImageWrappers.delete(photo.id); // <- also delete from map

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'delete_photos[]';
        hiddenInput.value = photo.id;
        form.appendChild(hiddenInput);
    });

    const editButton = document.createElement('button');
    editButton.innerHTML =
        `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>`;
    editButton.classList.add(
        'absolute', 'bottom-12', 'right-5', 'md:right-12', 'md:hidden', 'block', 'group-hover:md:block',
        'bg-gray-300/50', 'rounded-full', 'text-xs', 'p-3', 'cursor-pointer',
        'hover:bg-gray-300/75'
    );
    editButton.type = 'button';
    editButton.addEventListener('click', () => {
        currentEditingIndex = `existing-${photo.id}`;
        modalInput.value = photo.caption || '';
        document.getElementById('caption-modal-image').src = photo.image_path;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    wrapper.appendChild(img);
    wrapper.appendChild(removeButton);
    wrapper.appendChild(editButton);
    previewZone.appendChild(wrapper);
});

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
            newCaptions.delete(`${file.name}-${file.size}`);
            syncInputFiles();
            updatePreviews();
            syncInputFiles();
            updatePreviews();
        });
        const editButton = document.createElement('button');
        editButton.innerHTML =
            `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>`;
        editButton.type = 'button';
        editButton.classList.add(
            'absolute', 'bottom-12', 'right-12', 'md:hidden', 'block',
            'group-hover:md:block',
            'bg-gray-300/50', 'rounded-full', 'text-xs', 'p-3', 'cursor-pointer',
            'hover:bg-gray-300/75'
        );
        editButton.addEventListener('click', () => {
            currentEditingIndex = `${file.name}-${file.size}`;
            modalInput.value = newCaptions.get(currentEditingIndex) || '';
            document.getElementById('caption-modal-image').src = event.target.result;
            modal.classList.add('flex');
            modal.classList.remove('hidden');
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
    // // Clear only new image previews
    // const existingKeys = Array.from(existingImageWrappers.values());
    // previewZone.innerHTML = '';
    // existingKeys.forEach(wrapper => previewZone.appendChild(wrapper));

    // files.forEach((file, i) => showPreview(file, i));
    previewZone.innerHTML = '';
    existingImageWrappers.forEach(wrapper => previewZone.appendChild(wrapper));
    files.forEach((file, i) => showPreview(file, i));
};

// helper to sync input element
const syncInputFiles = () => {
    const dataTransfer = new DataTransfer();
    files.forEach(file => dataTransfer.items.add(file));
    fileInput.files = dataTransfer.files;
};

const handleFileAddition = (file) => {
    const exists = files.some(f => f.name === file.name && f.size === file.size);
    if (!exists) files.push(file);
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
                handleFileAddition(item.getAsFile());
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
        handleFileAddition(file);
    });

    syncInputFiles();
    updatePreviews();
});

// Modal button logic
saveBtn.addEventListener('click', () => {
    if (!currentEditingIndex) return;
    const val = modalInput.value;

    if (currentEditingIndex.startsWith('existing-')) {
        updateCaptions.set(currentEditingIndex, val);
    } else {
        newCaptions.set(currentEditingIndex, val);
    }

    updatePreviews();
    currentEditingIndex = null;
    modal.classList.remove('flex');
    modal.classList.add('hidden');
});

cancelBtn.addEventListener('click', () => {
    modal.classList.remove('flex');
    modal.classList.add('hidden');
    currentEditingIndex = null;
});

form.addEventListener('submit', () => {
    const genderValue = document.getElementById('gender-dropdown-value');
    genderValue.value = genderValue.value.toLowerCase();
    const captionsInput = document.getElementById('captions_json');
    const captionsObj = {};
    newCaptions.forEach((v, k) => captionsObj[k] = v);
    captionsInput.value = JSON.stringify(captionsObj);

    updateCaptions.forEach((v, k) => {
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = `update_captions[${k}]`;
        hidden.value = v;
        form.appendChild(hidden);
    });
});