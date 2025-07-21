<?php
$extraStyles = [
    'forms.css',
    'profile_edit.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<header>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
</header>

<div class="profile-edit-page">
    <div class="backlink">
        <a href="<?= BASE_URL ?>/profile">
            ← Back to Profile
        </a>
    </div>
    <div class="profile-edit-header">
        <h1>Edit Your Profile</h1>
        <p>Update your information and make your profile shine!</p>
    </div>

    <?php if (isset($success) && $success): ?>
        <div class="profile-success-message">
            🎉 Profile updated successfully! You're looking good!
        </div>
    <?php endif; ?>

    <?php if (isset($errors['general'])): ?>
        <div class="profile-error-message">
            ❌ <?= htmlspecialchars($errors['general']) ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="profile-edit-form">
        <!-- Profile Picture Section -->
        <div class="profile-form-section">
            <h2>Profile Picture</h2>
            <div class="profile-pic-upload">
                <div class="profile-current-avatar">
                    <?php if ($user->profile_image && file_exists($user->profile_image)): ?>
                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($user->profile_image) ?>"
                            alt="Current Profile Picture" class="profile-avatar-preview" id="avatarPreview">
                    <?php else: ?>
                        <div class="profile-avatar-placeholder" id="avatarPreview">
                            <span class="profile-avatar-initials">
                                <?= strtoupper(substr($user->name, 0, 2)) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="profile-upload-controls">
                    <label for="profile_image" class="profile-file-upload-btn">
                        Choose New Picture
                    </label>
                    <input type="file"
                        id="profile_image"
                        name="profile_image"
                        accept="image/*"
                        style="display: none;">
                    <p class="profile-upload-hint">Max 5MB • JPG, PNG, GIF only</p>

                    <?php if (isset($errors['profile_image'])): ?>
                        <span class="error-message">
                            <?= htmlspecialchars($errors['profile_image']) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Personal Info Section -->
        <div class="profile-form-section">
            <h2>Personal Information</h2>
            <div class="profile-form-grid">
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text"
                        id="name"
                        name="name"
                        value="<?= htmlspecialchars($user->name) ?>"
                        required>
                    <?php if (isset($errors['name'])): ?>
                        <span class="error-message">
                            <?= htmlspecialchars($errors['name']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="phone">Phone *</label>
                    <input type="tel"
                        id="phone"
                        name="phone"
                        value="<?= htmlspecialchars($user->phone) ?>"
                        required>
                    <?php if (isset($errors['phone'])): ?>
                        <span class="error-message">
                            <?= htmlspecialchars($errors['phone']) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bio Section -->
        <div class="profile-form-section">
            <h2>About You</h2>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio"
                    name="bio"
                    rows="4"
                    placeholder="Tell us about yourself! What pets do you love? What's your experience with animals? Fun facts about you?"><?= htmlspecialchars($user->bio ?? '') ?></textarea>
                <div class="profile-character-count">
                    <span id="bioCount">0</span>/500 characters
                </div>
                <?php if (isset($errors['bio'])): ?>
                    <span class="error-message">
                        <?= htmlspecialchars($errors['bio']) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Address Section -->
        <div class="profile-form-section">
            <h2>Address Information</h2>
            <div class="profile-form-grid">
                <div class="form-group profile-full-width">
                    <label for="address">Address *</label>
                    <input type="text"
                        id="address"
                        name="address"
                        value="<?= htmlspecialchars($user->address) ?>"
                        required>
                    <?php if (isset($errors['address'])): ?>
                        <span class="error-message">
                            <?= htmlspecialchars($errors['address']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="city">City *</label>
                    <input type="text"
                        id="city"
                        name="city"
                        value="<?= htmlspecialchars($user->city) ?>"
                        required>
                    <?php if (isset($errors['city'])): ?>
                        <span class="error-message">
                            <?= htmlspecialchars($errors['city']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="state">State *</label>
                    <input type="text"
                        id="state"
                        name="state"
                        value="<?= htmlspecialchars($user->state) ?>"
                        required>
                    <?php if (isset($errors['state'])): ?>
                        <span class="error-message">
                            <?= htmlspecialchars($errors['state']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="zip_code">ZIP Code</label>
                    <input type="text"
                        id="zip_code"
                        name="zip_code"
                        value="<?= htmlspecialchars($user->zip_code ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="profile-form-actions">
            <button type="submit" class="primary">
                Save Changes
            </button>
            <a href="<?= BASE_URL ?>/profile" class="btn secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    // Image preview functionality
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" class="avatar-preview">';
            };
            reader.readAsDataURL(file);
        }
    });

    // Bio character counter
    const bioTextarea = document.getElementById('bio');
    const bioCount = document.getElementById('bioCount');

    function updateBioCount() {
        const count = bioTextarea.value.length;
        bioCount.textContent = count;
        bioCount.style.color = count > 450 ? '#c53030' : count > 400 ? '#d69e2e' : '#718096';
    }

    bioTextarea.addEventListener('input', updateBioCount);
    // Initialize count
    updateBioCount();
</script>