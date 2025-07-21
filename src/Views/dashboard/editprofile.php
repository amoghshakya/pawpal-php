<?php
// Don't include any external CSS that might conflict
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="profile-edit-page">
    <div class="profile-edit-header">
        <h1>Edit Your Profile</h1>
        <p>Update your information and make your profile shine!</p>
        <a href="<?= BASE_URL ?>/profile" class="profile-btn profile-btn-secondary">← Back to Profile</a>
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
            <h2>📸 Profile Picture</h2>
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
                        <span class="profile-error-message">
                            <?= htmlspecialchars($errors['profile_image']) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Personal Info Section -->
        <div class="profile-form-section">
            <h2>👤 Personal Information</h2>
            <div class="profile-form-grid">
                <div class="profile-form-group">
                    <label for="name">Name *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="<?= htmlspecialchars($user->name) ?>" 
                           required>
                    <?php if (isset($errors['name'])): ?>
                        <span class="profile-error-message">
                            <?= htmlspecialchars($errors['name']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="profile-form-group">
                    <label for="phone">Phone *</label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="<?= htmlspecialchars($user->phone) ?>" 
                           required>
                    <?php if (isset($errors['phone'])): ?>
                        <span class="profile-error-message">
                            <?= htmlspecialchars($errors['phone']) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Bio Section -->
        <div class="profile-form-section">
            <h2>About You</h2>
            <div class="profile-form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" 
                          name="bio" 
                          rows="4" 
                          placeholder="Tell us about yourself! What pets do you love? What's your experience with animals? Fun facts about you?"><?= htmlspecialchars($user->bio ?? '') ?></textarea>
                <div class="profile-character-count">
                    <span id="bioCount">0</span>/500 characters
                </div>
                <?php if (isset($errors['bio'])): ?>
                    <span class="profile-error-message">
                        <?= htmlspecialchars($errors['bio']) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Address Section -->
        <div class="profile-form-section">
            <h2></h2>Address Information</h2>
            <div class="profile-form-grid">
                <div class="profile-form-group profile-full-width">
                    <label for="address">Address *</label>
                    <input type="text" 
                           id="address" 
                           name="address" 
                           value="<?= htmlspecialchars($user->address) ?>" 
                           required>
                    <?php if (isset($errors['address'])): ?>
                        <span class="profile-error-message">
                            <?= htmlspecialchars($errors['address']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="profile-form-group">
                    <label for="city">City *</label>
                    <input type="text" 
                           id="city" 
                           name="city" 
                           value="<?= htmlspecialchars($user->city) ?>" 
                           required>
                    <?php if (isset($errors['city'])): ?>
                        <span class="profile-error-message">
                            <?= htmlspecialchars($errors['city']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="profile-form-group">
                    <label for="state">State *</label>
                    <input type="text" 
                           id="state" 
                           name="state" 
                           value="<?= htmlspecialchars($user->state) ?>" 
                           required>
                    <?php if (isset($errors['state'])): ?>
                        <span class="profile-error-message">
                            <?= htmlspecialchars($errors['state']) ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="profile-form-group">
                    <label for="zip_code">ZIP Code</label>
                    <input type="text" 
                           id="zip_code" 
                           name="zip_code" 
                           value="<?= htmlspecialchars($user->zip_code ?? '') ?>">
                </div>
            </div>
        </div>

        <div class="profile-form-actions">
            <button type="submit" class="profile-btn profile-btn-primary">
                💾 Save Changes
            </button>
            <a href="<?= BASE_URL ?>/profile" class="profile-btn profile-btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<style>
/* Specific Profile Edit Page Styles - No Conflicts */
.profile-edit-page {
    max-width: 1200px !important;
    margin: 0 auto !important;
    padding: 2rem !important;
    background: #f8fafc !important;
    min-height: 100vh !important;
}

.profile-edit-header {
    text-align: center !important;
    margin-bottom: 3rem !important;
    background: white !important;
    padding: 2rem !important;
    border-radius: 12px !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
}

.profile-edit-header h1 {
    margin: 0 0 0.5rem 0 !important;
    color: #2d3748 !important;
    font-size: 2rem !important;
    font-weight: 700 !important;
}

.profile-edit-header p {
    color: #718096 !important;
    margin: 0 0 1.5rem 0 !important;
    font-size: 1.1rem !important;
}

.profile-success-message {
    background: #c6f6d5 !important;
    color: #2f855a !important;
    padding: 1rem 1.5rem !important;
    border-radius: 8px !important;
    margin-bottom: 2rem !important;
    text-align: center !important;
    font-weight: 600 !important;
    border: 1px solid #9ae6b4 !important;
}

.profile-error-message {
    background: #fed7d7 !important;
    color: #c53030 !important;
    padding: 0.75rem !important;
    border-radius: 6px !important;
    font-size: 0.9rem !important;
    margin-top: 0.5rem !important;
    display: block !important;
    border: 1px solid #feb2b2 !important;
}

.profile-edit-form {
    background: white !important;
    border-radius: 12px !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
    overflow: hidden !important;
}

.profile-form-section {
    padding: 2rem !important;
    border-bottom: 1px solid #e2e8f0 !important;
}

.profile-form-section:last-of-type {
    border-bottom: none !important;
}

.profile-form-section h2 {
    margin: 0 0 1.5rem 0 !important;
    color: #2d3748 !important;
    font-size: 1.25rem !important;
    font-weight: 600 !important;
    border-bottom: 2px solid #e2e8f0 !important;
    padding-bottom: 0.5rem !important;
}

.profile-pic-upload {
    display: flex !important;
    gap: 2rem !important;
    align-items: center !important;
}

.profile-current-avatar {
    flex-shrink: 0 !important;
}

.profile-avatar-preview, .profile-avatar-placeholder {
    width: 120px !important;
    height: 120px !important;
    border-radius: 50% !important;
    object-fit: cover !important;
    border: 4px solid #e1e5e9 !important;
    display: block !important;
}

.profile-avatar-placeholder {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}

.profile-avatar-initials {
    color: white !important;
    font-size: 2.5rem !important;
    font-weight: bold !important;
}

.profile-upload-controls {
    flex: 1 !important;
}

.profile-file-upload-btn {
    display: inline-block !important;
    background: #667eea !important;
    color: white !important;
    padding: 0.75rem 1.5rem !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    font-weight: 600 !important;
    transition: all 0.2s !important;
    margin-bottom: 0.5rem !important;
    border: none !important;
    text-decoration: none !important;
}

.profile-file-upload-btn:hover {
    background: #5a67d8 !important;
    transform: translateY(-1px) !important;
}

.profile-upload-hint {
    color: #718096 !important;
    font-size: 0.9rem !important;
    margin: 0 !important;
}

.profile-form-grid {
    display: grid !important;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)) !important;
    gap: 1.5rem !important;
}

.profile-form-group {
    display: flex !important;
    flex-direction: column !important;
}

.profile-form-group.profile-full-width {
    grid-column: 1 / -1 !important;
}

.profile-form-group label {
    color: #4a5568 !important;
    font-weight: 600 !important;
    margin-bottom: 0.5rem !important;
    font-size: 0.9rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.profile-form-group input,
.profile-form-group textarea {
    padding: 0.75rem !important;
    border: 2px solid #e2e8f0 !important;
    border-radius: 8px !important;
    font-size: 1rem !important;
    transition: border-color 0.2s !important;
    font-family: inherit !important;
    width: 100% !important;
    box-sizing: border-box !important;
}

.profile-form-group input:focus,
.profile-form-group textarea:focus {
    outline: none !important;
    border-color: #667eea !important;
}

.profile-form-group textarea {
    resize: vertical !important;
    min-height: 100px !important;
}

.profile-character-count {
    text-align: right !important;
    color: #718096 !important;
    font-size: 0.8rem !important;
    margin-top: 0.25rem !important;
}

.profile-form-actions {
    padding: 2rem !important;
    display: flex !important;
    gap: 1rem !important;
    justify-content: center !important;
    background: #f7fafc !important;
    border-top: 1px solid #e2e8f0 !important;
}

.profile-btn {
    display: inline-block !important;
    padding: 0.75rem 2rem !important;
    border-radius: 8px !important;
    text-decoration: none !important;
    font-weight: 600 !important;
    border: none !important;
    cursor: pointer !important;
    transition: all 0.2s !important;
    text-align: center !important;
    font-size: 0.95rem !important;
    min-width: 140px !important;
}

.profile-btn-primary {
    background: #667eea !important;
    color: white !important;
}

.profile-btn-primary:hover {
    background: #5a67d8 !important;
    transform: translateY(-1px) !important;
}

.profile-btn-secondary {
    background: #e2e8f0 !important;
    color: #4a5568 !important;
}

.profile-btn-secondary:hover {
    background: #cbd5e0 !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-edit-page {
        padding: 1rem !important;
    }
    
    .profile-edit-header {
        padding: 1.5rem !important;
        margin-bottom: 2rem !important;
    }
    
    .profile-edit-header h1 {
        font-size: 1.75rem !important;
    }
    
    .profile-pic-upload {
        flex-direction: column !important;
        text-align: center !important;
    }
    
    .profile-form-section {
        padding: 1.5rem !important;
    }
    
    .profile-form-grid {
        grid-template-columns: 1fr !important;
    }
    
    .profile-form-actions {
        flex-direction: column !important;
        padding: 1.5rem !important;
    }
    
    .profile-btn {
        width: 100% !important;
    }
    
    .profile-avatar-preview, .profile-avatar-placeholder {
        width: 100px !important;
        height: 100px !important;
    }
    
    .profile-avatar-initials {
        font-size: 2rem !important;
    }
}
</style>

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
