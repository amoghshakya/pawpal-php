<?php
$extraStyles = [
    'forms.css',
    'create.css',
];

$images = $pet->images() ?? [];
?>
<?php include __DIR__ . "/../partials/header.php"; ?>

<section class="form-section">
    <?php if (isset($errors['general'])): ?>
        <span class="error-message">
            <?php echo htmlspecialchars($errors['general']); ?>
        </span>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data" id="create-pet-form" action="<?= BASE_URL ?>/pets/<?= $pet->id ?>/edit">
        <div class="text-fields">
            <div class="form-group">
                <label for="name">Pet Name:</label>
                <input
                    name="name"
                    placeholder="e.g., Snoopy"
                    id="name"
                    value="<?= $pet->name ?>"
                    required />
                <?php if (isset($errors['name'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['name']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="species">Species:</label>
                <input
                    name="species"
                    placeholder="e.g., Dog"
                    value="<?= $pet->species ?>"
                    id="species" required />
                <?php if (isset($errors['species'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['species']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="breed">Breed</label>
                <input
                    name="breed"
                    id="breed"
                    placeholder="e.g., Beagle"
                    value="<?= $pet->breed ?>"
                    required />
                <?php if (isset($errors['breed'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['breed']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="two-column">
                <div class="form-group">
                    <label for="age">Age</label>
                    <input name="age"
                        value="<?= $pet->age ?>"
                        id="age"
                        type="text"
                        placeholder="e.g., 2 years, 5 months"
                        required />
                    <?php if (isset($errors['age'])): ?>
                        <span class="error-message">
                            <?php echo htmlspecialchars($errors['age']); ?>
                        </span>
                    <?php endif; ?>
                </div>


                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <option
                            value="unknown"
                            <?= $pet->gender->name === 'unknown' ? 'selected' : '' ?>>
                            Unknown
                        </option>
                        <option
                            value="male"
                            <?= $pet->gender->name === 'male' ? 'selected' : '' ?>>
                            Male</option>
                        <option
                            value="female"
                            <?= $pet->gender->name === 'female' ? 'selected' : '' ?>>
                            Female
                        </option>
                    </select>
                    <?php if (isset($errors['gender'])): ?>
                        <span class="error-message">
                            <?php echo htmlspecialchars($errors['gender']); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input
                    name="location"
                    value="<?= $pet->location ?>"
                    id="location"
                    placeholder="e.g., Sanepa, Lalitpur"
                    required />
                <?php if (isset($errors['location'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['location']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="two-column">
                <div class="form-group">
                    <label for="special_needs">Special Needs</label>
                    <input
                        name="special_needs"
                        id="special_needs"
                        placeholder="e.g., Requires daily medication"
                        value="<?= $pet->special_needs ?>" />
                    <?php if (isset($errors['special_needs'])): ?>
                        <span class="error-message">
                            <?php echo htmlspecialchars($errors['special_needs']); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="vaccinated">Vaccinated</label>

                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio"
                                name="vaccinated"
                                id="vaccinated_yes"
                                value="true"
                                <?= $pet->vaccinated ? 'checked' : '' ?>
                                required />
                            <label for="vaccinated_yes">Yes</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio"
                                name="vaccinated"
                                id="vaccinated_no"
                                value="false"
                                <?= !$pet->vaccinated ? 'checked' : '' ?>
                                required
                                <?= isset($_POST['vaccinated']) && $_POST['vaccinated'] == 'false' ? 'checked' : '' ?> />
                            <label for="vaccinated_no">No</label>
                        </div>
                    </div>
                    <?php if (isset($errors['vaccinated'])): ?>
                        <span class="error-message">
                            <?php echo htmlspecialchars($errors['vaccinated']); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="large-fields">
            <div class="form-group hidden" id="vaccination-details-container">
                <label for="vaccination_details">Vaccination Details</label>
                <textarea
                    name="vaccination_details"
                    id="vaccination_details"
                    rows="5"
                    placeholder="Provide details about vaccinations, including dates and types of vaccines."><?= $pet->vaccination_details ?></textarea>
                <?php if (isset($errors['vaccination_details'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['vaccination_details']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea
                    name="description"
                    id="description"
                    rows="5"
                    placeholder="Describe the pet's personality, habits, and any special needs."
                    required><?= $pet->description ?></textarea>
                <?php if (isset($errors['description'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['description']); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Upload photos</label>
                <div id="drop-zone">
                    <div id="drop-zone-text">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        <p>
                            <label for="image">
                                <span>
                                    Upload a file
                                </span>
                                <input
                                    type="file"
                                    name="images[]"
                                    id="image"
                                    accept="image/*"
                                    multiple />
                            </label>
                            or drag and drop
                        </p>
                    </div>
                </div>
                <?php if (isset($errors['images'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['images']); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div id="preview-container">
            </div>
        </div>
        <input type="hidden" name="delete_photos" id="delete_photos" value="[]" />
        <div class="form-group">
            <input
                id="captions_json"
                name="captions_json"
                type="hidden"
                value="" />
            <button class="primary" type="submit">Save</button>
        </div>
    </form>
    <div id="caption-modal" class="modal hidden">
        <div class="modal-content">
            <div class="close-btn" onclick="document.getElementById('caption-modal').classList.add('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>

            <div class="modal-body">
                <h4 class="modal-title">
                    Add caption to your pet's photos
                </h4>
                <div class="modal-body-content">
                    <img
                        class="modal-image"
                        id="caption-modal-image"
                        src="#"
                        alt="Image preview" />

                    <input
                        class="caption-input"
                        id="caption-modal-input"
                        type="text"
                        placeholder="Enter caption..." />

                    <!-- Buttons -->
                    <div class="button-container">
                        <button
                            id="caption-cancel-btn"
                            class="secondary"
                            type="button">Cancel</button>
                        <button
                            id="caption-save-btn"
                            class="primary"
                            type="button">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const existingImages = <?= json_encode($images) ?>;
    const deletedPhotoIds = new Set();


    // Vaccination Radio Logic
    const vaccinatedRadios = document.querySelectorAll('input[name="vaccinated"]');
    const container = document.getElementById("vaccination-details-container");
    const detailsInput = document.getElementById("vaccination_details");

    if (document.getElementById("vaccinated_yes").checked) {
        container.classList.remove("hidden");
        detailsInput.required = true;
    } else {
        container.classList.add("hidden");
        detailsInput.required = false;
    }

    vaccinatedRadios.forEach((radio) => {
        radio.addEventListener("change", () => {
            if (document.getElementById("vaccinated_yes").checked) {
                container.classList.remove("hidden");
                detailsInput.required = true;
            } else {
                container.classList.add("hidden");
                detailsInput.required = false;
            }
        });
    });

    // File Upload and Editing Logic
    const form = document.getElementById("create-pet-form");
    const files = [];
    const updateCaptions = new Map();
    const newCaptions = new Map();

    const fileInput = document.getElementById("image");
    const dropZone = document.getElementById("drop-zone");
    const previewZone = document.getElementById("preview-container");

    const existingImageWrappers = new Map(); // photo.id => wrapper

    // Populate existing images
    existingImages.forEach((photo) => {
        const wrapper = document.createElement("div");
        wrapper.classList.add("thumbnail-wrapper");

        existingImageWrappers.set(photo.id, wrapper);

        const img = document.createElement("img");
        img.src = `<?= BASE_URL ?>/${photo.image_path}`;
        img.classList.add("thumbnail");
        img.draggable = false;

        const removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.classList.add("remove-btn");
        removeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"> <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>`;
        removeBtn.addEventListener("click", () => {
            wrapper.remove();
            existingImageWrappers.delete(photo.id);

            deletedPhotoIds.add(photo.id);
        });

        const editBtn = document.createElement("button");
        editBtn.type = "button";
        editBtn.classList.add("edit-btn");
        editBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>`;
        editBtn.addEventListener("click", () => {
            currentEditingIndex = `existing-${photo.id}`;
            modalInput.value = photo.caption || "";
            document.getElementById("caption-modal-image").src = `<?= BASE_URL ?>/${photo.image_path}`;
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });

        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        wrapper.appendChild(editBtn);
        previewZone.appendChild(wrapper);
    });

    // Modal
    let currentEditingIndex = null;
    const modal = document.getElementById("caption-modal");
    const modalInput = document.getElementById("caption-modal-input");
    const saveBtn = document.getElementById("caption-save-btn");
    const cancelBtn = document.getElementById("caption-cancel-btn");

    const removeStyles = () => {
        dropZone.style.backgroundColor = "";
        dropZone.style.borderColor = "rgba(17, 24, 39, 0.25)";
    };

    const addStyles = () => {
        dropZone.style.backgroundColor = "#e5e7eb";
        dropZone.style.borderColor = "#111827";
    };

    const showPreview = (file, index) => {
        const reader = new FileReader();

        reader.onload = (e) => {
            const wrapper = document.createElement("div");
            wrapper.classList.add("thumbnail-wrapper");

            const img = document.createElement("img");
            img.src = e.target.result;
            img.draggable = false;
            img.classList.add("thumbnail");
            img.alt = file.name;

            const removeBtn = document.createElement("button");
            removeBtn.type = "button";
            removeBtn.classList.add("remove-btn");
            removeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"> <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>`;
            removeBtn.addEventListener("click", () => {
                files.splice(index, 1);
                newCaptions.delete(`${file.name}-${file.size}`);
                syncInputFiles();
                updatePreviews();
            });

            const editBtn = document.createElement("button");
            editBtn.type = "button";
            editBtn.classList.add("edit-btn");
            editBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>`;
            editBtn.addEventListener("click", () => {
                currentEditingIndex = `${file.name}-${file.size}`;
                modalInput.value = newCaptions.get(currentEditingIndex) || "";
                document.getElementById("caption-modal-image").src = e.target.result;
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            });

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            wrapper.appendChild(editBtn);
            previewZone.appendChild(wrapper);
        };

        if (file.type.startsWith("image/")) {
            reader.readAsDataURL(file);
        }
    };

    const updatePreviews = () => {
        previewZone.innerHTML = "";
        existingImageWrappers.forEach((wrapper) => previewZone.appendChild(wrapper));
        files.forEach((file, i) => showPreview(file, i));
    };

    const syncInputFiles = () => {
        const dataTransfer = new DataTransfer();
        files.forEach((f) => dataTransfer.items.add(f));
        fileInput.files = dataTransfer.files;
    };

    const handleFileAddition = (file) => {
        const exists = files.some(
            (f) => f.name === file.name && f.size === file.size,
        );
        if (!exists) files.push(file);
    };

    // Drag-drop handlers
    dropZone.addEventListener("dragover", (e) => {
        const items = e.dataTransfer.items;
        const isValid = [...items].every(
            (item) => item.kind === "file" && item.type.startsWith("image/"),
        );
        if (isValid) {
            e.preventDefault();
            addStyles();
        } else {
            removeStyles();
        }
    });

    dropZone.addEventListener("dragleave", removeStyles);

    dropZone.addEventListener("drop", (e) => {
        e.preventDefault();
        const items = e.dataTransfer.items;
        [...items].forEach((item) => {
            if (item.kind === "file" && item.type.startsWith("image/")) {
                handleFileAddition(item.getAsFile());
            }
        });

        syncInputFiles();
        updatePreviews();
        removeStyles();
    });

    // Standard file input change
    fileInput.addEventListener("change", (e) => {
        const selected = [...e.target.files];
        selected.forEach(handleFileAddition);
        syncInputFiles();
        updatePreviews();
    });

    // Modal logic
    saveBtn.addEventListener("click", () => {
        if (!currentEditingIndex) return;

        const caption = modalInput.value;

        if (currentEditingIndex.startsWith("existing-")) {
            updateCaptions.set(currentEditingIndex, caption);
        } else {
            newCaptions.set(currentEditingIndex, caption);
        }

        updatePreviews();
        currentEditingIndex = null;
        modal.classList.remove("flex");
        modal.classList.add("hidden");
    });

    cancelBtn.addEventListener("click", () => {
        modal.classList.remove("flex");
        modal.classList.add("hidden");
        currentEditingIndex = null;
    });

    form.addEventListener("submit", () => {
        const captionsInput = document.getElementById("captions_json");
        const captionsObj = {};
        newCaptions.forEach((v, k) => (captionsObj[k] = v));
        captionsInput.value = JSON.stringify(captionsObj);

        updateCaptions.forEach((v, k) => {
            const hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = `update_captions[${k}]`;
            hidden.value = v;
            form.appendChild(hidden);
        });

        document.getElementById("delete_photos").value = JSON.stringify([...deletedPhotoIds]);
    });
</script>

<!-- <script src="<?= BASE_URL ?>/assets/js/editPet.js" defer></script> -->

</body>
