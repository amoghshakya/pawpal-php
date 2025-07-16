<?php
$extraStyles = [
    '/assets/css/forms.css',
    '/assets/css/create.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<section class="form-section">
    <?php if (isset($errors['general'])): ?>
        <span class="error-message">
            <?php echo htmlspecialchars($errors['general']); ?>
        </span>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data" id="create-pet-form" action="<?= BASE_URL ?>/pets/create">
        <div class="text-fields">
            <div class="form-group">
                <label for="name">Pet Name:</label>
                <input
                    name="name"
                    placeholder="e.g., Snoopy"
                    id="name"
                    value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
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
                    value="<?= isset($_POST['species']) ? htmlspecialchars($_POST['species']) : '' ?>"
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
                    value="<?= isset($_POST['breed']) ? htmlspecialchars($_POST['breed']) : '' ?>"
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
                        value="<?= isset($_POST['age']) ? htmlspecialchars($_POST['age']) : '' ?>"
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
                        <option value="unknown" selected>Unknown</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
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
                    value="<?= isset($_POST['location']) ? htmlspecialchars($_POST['location']) : '' ?>"
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
                        value="<?= isset($_POST['special_needs']) ? htmlspecialchars($_POST['special_needs']) : '' ?>" />
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
                                required
                                <?= isset($_POST['vaccinated']) && $_POST['vaccinated'] == 'true' ? 'checked' : '' ?> />
                            <label for="vaccinated_yes">Yes</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio"
                                name="vaccinated"
                                id="vaccinated_no"
                                value="false"
                                checked
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
                    rows="3"
                    placeholder="Provide details about vaccinations, including dates and types of vaccines."><?= isset($_POST['vaccination_details']) ? htmlspecialchars($_POST['vaccination_details']) : '' ?></textarea>
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
                    rows="3"
                    placeholder="Describe the pet's personality, habits, and any special needs."
                    required><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
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
                                    multiple
                                    required />
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
        <div class="form-group">
            <input
                id="captions_json"
                name="captions_json"
                type="hidden"
                value="" />
            <button class="primary" type="submit">Create</button>
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


<script src="<?= BASE_URL ?>/assets/js/createPet.js" defer></script>
