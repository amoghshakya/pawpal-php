<?php
$extraStyles = [
    'dashboard_index.css',
    'forms.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="dashboard-container">
    <div class="profile-header">
        <div class="profile-avatar">
            <?php if ($user->profile_image && file_exists($user->profile_image)): ?>
                <img src="<?= BASE_URL ?>/<?= htmlspecialchars($user->profile_image) ?>" 
                     alt="Profile Picture" class="avatar-image">
            <?php else: ?>
                <div class="avatar-placeholder">
                    <span class="avatar-initials">
                        <?= strtoupper(substr($user->name, 0, 2)) ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="profile-info">
            <h1><?= htmlspecialchars($user->name) ?></h1>
            <p class="profile-role"><?= ucfirst($user->role) ?></p>
            <?php if ($user->bio): ?>
                <p class="profile-bio"><?= nl2br(htmlspecialchars($user->bio)) ?></p>
            <?php else: ?>
                <p class="profile-bio-empty">No bio yet - tell us about yourself!</p>
            <?php endif; ?>
            <div class="profile-actions">
                <a href="<?= BASE_URL ?>/profile/edit" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    </div>

    <div class="profile-content">
        <!-- Contact Info Section -->
        <div class="profile-section">
            <h2>Contact Information</h2>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Email:</strong>
                    <span><?= htmlspecialchars($user->email) ?></span>
                </div>
                <div class="info-item">
                    <strong>Phone:</strong>
                    <span><?= htmlspecialchars($user->phone) ?></span>
                </div>
                <div class="info-item">
                    <strong>Address:</strong>
                    <span>
                        <?= htmlspecialchars($user->address) ?><br>
                        <?= htmlspecialchars($user->city) ?>, <?= htmlspecialchars($user->state) ?>
                        <?php if ($user->zip_code): ?>
                            <?= htmlspecialchars($user->zip_code) ?>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Adoption History Section -->
        <div class="profile-section">
            <h2>🐾 Adoption History</h2>
            <?php if (empty($adoptionHistory)): ?>
                <div class="empty-state">
                    <p>No adoption applications yet!</p>
                    <p>Ready to find your furry friend? <a href="<?= BASE_URL ?>/pets">Browse pets</a></p>
                </div>
            <?php else: ?>
                <div class="adoption-history">
                    <?php foreach ($adoptionHistory as $application): ?>
                        <div class="adoption-card">
                            <div class="adoption-pet-image">
                                <?php if ($application['pet_image']): ?>
                                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($application['pet_image']) ?>" 
                                         alt="<?= htmlspecialchars($application['pet_name']) ?>">
                                <?php else: ?>
                                    <div class="pet-placeholder">🐾</div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="adoption-details">
                                <h3><?= htmlspecialchars($application['pet_name']) ?></h3>
                                <p class="pet-info">
                                    <?= htmlspecialchars($application['breed']) ?> • 
                                    <?= htmlspecialchars($application['age']) ?> years old
                                </p>
                                <p class="application-date">
                                    Applied on: <?= date('M j, Y', strtotime($application['created_at'])) ?>
                                </p>
                                
                                <div class="application-status status-<?= strtolower($application['status']) ?>">
                                    <?php
                                    $statusText = [
                                        'pending' => '⏳ Pending Review',
                                        'approved' => '✅ Approved',
                                        'rejected' => '❌ Rejected'
                                    ];
                                    echo $statusText[$application['status']] ?? ucfirst($application['status']);
                                    ?>
                                </div>
                                
                                <?php if ($application['message']): ?>
                                    <div class="application-message">
                                        <strong>Your message:</strong>
                                        <p><?= nl2br(htmlspecialchars($application['message'])) ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Account Info Section -->
        <div class="profile-section">
            <h2></h2> Account Details</h2>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Member since:</strong>
                    <span><?= date('F j, Y', strtotime($user->created_at)) ?></span>
                </div>
                <div class="info-item">
                    <strong>Last updated:</strong>
                    <span><?= date('F j, Y g:i A', strtotime($user->updated_at)) ?></span>
                </div>
                <div class="info-item">
                    <strong>Account type:</strong>
                    <span class="role-badge role-<?= $user->role ?>">
                        <?= ucfirst($user->role) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile-specific styles */
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-header {
    display: flex;
    gap: 2rem;
    margin-bottom: 3rem;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.profile-avatar {
    flex-shrink: 0;
}

.avatar-image, .avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e1e5e9;
}

.avatar-placeholder {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-initials {
    color: white;
    font-size: 2.5rem;
    font-weight: bold;
}

.profile-info h1 {
    margin: 0 0 0.5rem 0;
    color: #2d3748;
}

.profile-role {
    color: #667eea;
    font-weight: 600;
    margin: 0 0 1rem 0;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 1px;
}

.profile-bio {
    color: #4a5568;
    margin: 0 0 1.5rem 0;
    line-height: 1.6;
}

.profile-bio-empty {
    color: #a0aec0;
    font-style: italic;
    margin: 0 0 1.5rem 0;
}

.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5a67d8;
    transform: translateY(-1px);
}

.profile-section {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.profile-section h2 {
    margin: 0 0 1.5rem 0;
    color: #2d3748;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 0.5rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item strong {
    color: #4a5568;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-item span {
    color: #2d3748;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #a0aec0;
}

.empty-state p {
    margin: 0.5rem 0;
}

.adoption-history {
    display: grid;
    gap: 1.5rem;
}

.adoption-card {
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: #f7fafc;
}

.adoption-pet-image {
    flex-shrink: 0;
}

.adoption-pet-image img, .pet-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
}

.pet-placeholder {
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.adoption-details h3 {
    margin: 0 0 0.5rem 0;
    color: #2d3748;
}

.pet-info {
    color: #667eea;
    margin: 0 0 0.5rem 0;
    font-weight: 600;
}

.application-date {
    color: #718096;
    margin: 0 0 1rem 0;
    font-size: 0.9rem;
}

.application-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-block;
    margin-bottom: 1rem;
}

.status-pending {
    background: #fed7d7;
    color: #c53030;
}

.status-approved {
    background: #c6f6d5;
    color: #2f855a;
}

.status-rejected {
    background: #fbb6ce;
    color: #c53030;
}

.application-message {
    margin-top: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 6px;
    border-left: 4px solid #667eea;
}

.application-message strong {
    display: block;
    margin-bottom: 0.5rem;
    color: #4a5568;
}

.application-message p {
    margin: 0;
    color: #2d3748;
    line-height: 1.5;
}

.role-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.role-adopter {
    background: #bee3f8;
    color: #2c5282;
}

.role-lister {
    background: #c6f6d5;
    color: #2f855a;
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 1rem;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .adoption-card {
        flex-direction: column;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>
