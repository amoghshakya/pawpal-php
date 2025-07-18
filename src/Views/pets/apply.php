<?php

use App\Models\User;

$user = User::find($_SESSION['user_id']);
$extraStyles = [
    "forms.css",
    "apply.css"
];
?>

<?php include __DIR__ . "/../partials/header.php"; ?>

<div class="container">
    <div class="form-card">
        <div class="form-header">
            <h1 class="form-title">Pet Adoption Application</h1>
            <p class="text-muted">
                Please fill out this form completely to apply for pet adoption. All fields are required unless marked optional.
            </p>
        </div>

        <div class="form-content">
            <form id="adoptionForm" class="adoption-form" method="POST">
                <!-- Personal Information -->
                <div class="disabled-input">
                    <h3 class="section-title">Personal Information</h3>
                    <p class="text-muted small">
                        These details are pre-filled from your account. You can
                        update them directly in your account settings if needed.
                    </p>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input
                            type="text"
                            id="name"
                            value="<?= $user->name ?? '' ?>"
                            readonly />
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input
                                type="email"
                                id="email"
                                value="<?= $user->email ?? '' ?>"
                                readonly />
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input
                                type="tel"
                                id="phone"
                                value="<?= $user->phone ?? '' ?>"
                                readonly />
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <!-- Is letting users change their address a good idea? -->
                <!-- I could think of a few cases where it might be useful, such as  -->
                <!-- if they are moving to a new place or they're applying in behalf -->
                <!-- of someone else.  -->
                <!-- This isn't a big deal, since it's not a real application, but I think it's a  -->
                <!-- good idea to let users change their address if they want to. -->
                <div class=" ">
                    <h3 class="section-title">Address Information</h3>
                    <p class="text-muted small">
                        If you are applying for adoption, we need to
                        confirm your address. The information below is
                        pre-filled from your account. If you need to
                        update your address, please do so in your account
                        settings.
                    </p>
                    <div class="form-group">
                        <label for="address">Street Address</label>
                        <input
                            type="text"
                            id="address"
                            name="address"
                            value="<?= isset($_POST['address']) ? $_POST['address'] : $user->address ?? '' ?>"
                            required />
                        <?php if (isset($errors['address'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['address']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-row form-row-three">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input
                                type="text"
                                id="city"
                                name="city"
                                value="<?= isset($_POST['city']) ? $_POST['city'] : $user->city ?? '' ?>"
                                required>
                            <?php if (isset($errors['city'])): ?>
                                <span class="error-message">
                                    <?php echo htmlspecialchars($errors['city']); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input
                                type="text"
                                id="state"
                                name="state"
                                value="<?= isset($_POST['state']) ? $_POST['state'] : $user->state ?? '' ?>"
                                required />
                            <?php if (isset($errors['state'])): ?>
                                <span class="error-message">
                                    <?php echo htmlspecialchars($errors['state']); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="zipCode">
                                ZIP Code <span class="text-muted small">(optional)</span>
                            </label>
                            <input
                                type="text"
                                id="zipCode"
                                value="<?= isset($_POST['zipCode']) ? $_POST['zipCode'] : '' ?>"
                                name="zipCode" />
                            <?php if (isset($errors['zipCode'])): ?>
                                <span class="error-message">
                                    <?php echo htmlspecialchars($errors['zipCode']); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Housing Information -->
                <div class="form-section">
                    <h3 class="section-title">Housing Information</h3>
                    <div class="form-group">
                        <label for="housingType" class="">Type of Housing</label>
                        <select id="housingType" name="housingType" class="form-select" required>
                            <option value="">Select housing type</option>
                            <option
                                value="house"
                                <?= isset($_POST['housingType']) && $_POST['housingType'] === 'house' ? 'selected' : '' ?>>
                                House
                            </option>
                            <option value="apartment"
                                <?= isset($_POST['housingType']) && $_POST['housingType'] === 'apartment' ? 'selected' : '' ?>>
                                Apartment</option>
                            <option value="condo"
                                <?= isset($_POST['housingType']) && $_POST['housingType'] === 'condo' ? 'selected' : '' ?>>
                                Condominium</option>
                            <option value="shared"
                                <?= isset($_POST['housingType']) && $_POST['housingType'] === 'shared' ? 'selected' : '' ?>>
                                Shared Housing (with roommates)</option>
                            <option value="other"
                                <?= isset($_POST['housingType']) && $_POST['housingType'] === 'other' ? 'selected' : '' ?>>
                                Other</option>
                        </select>
                        <?php if (isset($errors['housingType'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['housingType']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label>Do you own or rent your home?</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="own" name="ownOrRent" value="own"
                                    <?= isset($_POST['ownOrRent']) && $_POST['ownOrRent'] === 'own' ? 'checked' : '' ?> required>
                                <label for="own" class="radio-label">Own</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="rent" name="ownOrRent" value="rent"
                                    <?= isset($_POST['ownOrRent']) && $_POST['ownOrRent'] === 'rent' ? 'checked' : '' ?> required>
                                <label for="rent" class="radio-label">Rent</label>
                            </div>
                        </div>
                        <?php if (isset($errors['ownOrRent'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['ownOrRent']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div id="landlordSection" class="form-group" style="<?= (isset($_POST['ownOrRent']) && $_POST['ownOrRent'] === 'rent') ? '' : 'display: none;' ?>">
                        <label>Do you have landlord permission for pets?</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="permissionYes" name="landlordPermission" value="yes"
                                    <?= isset($_POST['landlordPermission']) && $_POST['landlordPermission'] === 'yes' ? 'checked' : '' ?>>
                                <label for="permissionYes" class="radio-label">Yes</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="permissionNo" name="landlordPermission" value="no"
                                    <?= isset($_POST['landlordPermission']) && $_POST['landlordPermission'] === 'no' ? 'checked' : '' ?>>
                                <label for="permissionNo" class="radio-label">No</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="permissionPending" name="landlordPermission" value="pending"
                                    <?= isset($_POST['landlordPermission']) && $_POST['landlordPermission'] === 'pending' ? 'checked' : '' ?>>
                                <label for="permissionPending" class="radio-label">Pending approval</label>
                            </div>
                        </div>
                        <?php if (isset($errors['landlordPermission'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['landlordPermission']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Pet Experience -->
                <div class="form-section">
                    <h3 class="section-title">Pet Experience</h3>
                    <div class="checkbox-item">
                        <input type="checkbox" id="hasOtherPets" name="hasOtherPets"
                            <?= isset($_POST['hasOtherPets']) && $_POST['hasOtherPets'] ? 'checked' : '' ?> />
                        <label for="hasOtherPets" class="checkbox-label">I currently have other pets</label>
                    </div>
                    <div id="otherPetsSection" class="form-group" style="<?= (isset($_POST['hasOtherPets']) && $_POST['hasOtherPets']) ? 'display: flex;' : 'display: none;' ?>">
                        <label for="otherPetsDetails">Please describe your other pets (type, age, temperament)</label>
                        <textarea id="otherPetsDetails" name="otherPetsDetails"
                            placeholder="e.g., 2 cats (ages 3 and 5), both friendly and well-socialized..."><?= $_POST['otherPetsDetails'] ?? '' ?></textarea>
                        <?php if (isset($errors['otherPetsDetails'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['otherPetsDetails']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="experience">Describe your experience with pets</label>
                        <textarea id="experience" name="experience"
                            placeholder="Tell us about your history with pets, training experience, etc." required><?= $_POST['experience'] ?? '' ?></textarea>
                        <?php if (isset($errors['experience'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['experience']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Living Conditions -->
                <div class="form-section">
                    <h3 class="section-title">Living Conditions & Care</h3>
                    <div class="form-group">
                        <label for="livingConditions">Describe your living conditions and how they suit a pet</label>
                        <textarea id="livingConditions" name="livingConditions" class="form-textarea"
                            placeholder="e.g., fenced yard, quiet neighborhood, nearby parks, etc." required><?= $_POST['livingConditions'] ?? '' ?></textarea>
                        <?php if (isset($errors['livingConditions'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['livingConditions']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="hoursAlone">How many hours per day would the pet be left alone?</label>
                        <select id="hoursAlone" name="hoursAlone" class="form-select" required>
                            <option value="">Select hours</option>
                            <option value="0-2"
                                <?= isset($_POST['hoursAlone']) && $_POST['hoursAlone'] === '0-2' ? 'selected' : '' ?>>
                                0-2 hours
                            </option>
                            <option value="3-4"
                                <?= isset($_POST['hoursAlone']) && $_POST['hoursAlone'] === '3-4' ? 'selected' : '' ?>>
                                3-4 hours
                            </option>
                            <option value="5-6"
                                <?= isset($_POST['hoursAlone']) && $_POST['hoursAlone'] === '5-6' ? 'selected' : '' ?>>
                                5-6 hours
                            </option>
                            <option value="7-8"
                                <?= isset($_POST['hoursAlone']) && $_POST['hoursAlone'] === '7-8' ? 'selected' : '' ?>>
                                7-8 hours
                            </option>
                            <option value="9+"
                                <?= isset($_POST['hoursAlone']) && $_POST['hoursAlone'] === '9+' ? 'selected' : '' ?>>
                                9+ hours
                            </option>
                        </select>
                        <?php if (isset($errors['hoursAlone'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['hoursAlone']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Additional Message -->
                <div class="form-section">
                    <h3 class="section-title">Additional Information</h3>
                    <div class="form-group">
                        <label for="message">Additional message or questions (optional)</label>
                        <textarea id="message" name="message" class="form-textarea"
                            placeholder="Tell us anything else you'd like us to know about your application..."><?= $_POST['message'] ?? '' ?></textarea>
                        <?php if (isset($errors['message'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['message']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Terms Agreement -->
                <div class="form-section">
                    <div class="checkbox-item">
                        <input type="checkbox" id="agreeToTerms" name="agreeToTerms" class="checkbox-input" required>
                        <label for="agreeToTerms" class="checkbox-label">
                            I agree to the terms and conditions and understand that this application will be reviewed by the adoption team
                        </label>
                    </div>
                    <?php if (isset($errors['agreeToTerms'])): ?>
                        <span class="error-message">
                            <?php echo htmlspecialchars($errors['agreeToTerms']); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <button type="submit" class="primary">Submit</button>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get form elements
        const form = document.getElementById('adoptionForm');
        const hasOtherPetsCheckbox = document.getElementById('hasOtherPets');
        const otherPetsSection = document.getElementById('otherPetsSection');
        const ownOrRentRadios = document.querySelectorAll('input[name="ownOrRent"]');
        const landlordSection = document.getElementById('landlordSection');

        function showOtherPetsSection() {
            if (hasOtherPetsCheckbox.checked) {
                otherPetsSection.style.display = 'flex';
            } else {
                otherPetsSection.style.display = 'none';
                document.getElementById('otherPetsDetails').value = '';
            }
        }

        // Handle other pets checkbox
        hasOtherPetsCheckbox.addEventListener('change', showOtherPetsSection);

        // Handle own/rent radio buttons
        ownOrRentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'rent') {
                    landlordSection.style.display = 'block';
                } else {
                    landlordSection.style.display = 'none';
                    // Clear landlord permission selection
                    const landlordRadios = document.querySelectorAll('input[name="landlordPermission"]');
                    landlordRadios.forEach(r => r.checked = false);
                }
            });
        });
    });
</script>
