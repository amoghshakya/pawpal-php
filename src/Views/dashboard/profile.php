<?php

use App\Utils\Utils;

$extraStyles = [
    'dashboard_index.css',
    'forms.css',
    'profile.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<header>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
</header>

<div class="dashboard-container">
    <div class="profile-header">
        <div class="profile-avatar">
            <?php if ($user->profile_image && file_exists($user->profile_image)): ?>
                <img src="<?= BASE_URL ?>/<?= htmlspecialchars($user->profile_image) ?>"
                    alt="Profile Picture" class="avatar-image">
            <?php else: ?>
                <div class="avatar-placeholder">
                    <span class="avatar-initials">
                        <?= Utils::initials($user->name) ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="profile-info">
            <h1><?= htmlspecialchars($user->name) ?></h1>
            <p class="profile-role"><?= ucfirst($user->role) ?></p>
            <?php if ($user->bio): ?>
                <p class="profile-bio" style="line-break: anywhere"><?= nl2br(htmlspecialchars($user->bio)) ?></p>
            <?php else: ?>
                <p class="profile-bio-empty">No bio yet - tell us about yourself!</p>
            <?php endif; ?>
            <div class="flex items-center justify-between" style="gap:1rem;">
                <?php if ($authUser->id === $user->id): ?>
                    <a href="<?= BASE_URL ?>/profile/edit" class="btn primary">Edit Profile</a>
                    <?php if ($authUser->id === $user->id && $authUser->role === 'lister'): ?>
                        <a href="<?= BASE_URL ?>/dashboard" class="btn secondary">Go to Dashboard</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="profile-content">
        <!-- Contact Info Section -->
        <?php if ($authUser->id === $user->id): ?>
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
                            <?= htmlspecialchars($user->address) ?>,
                            <?= htmlspecialchars($user->city) ?>, <?= htmlspecialchars($user->state) ?>
                            <?php if ($user->zip_code): ?>
                                <?= htmlspecialchars($user->zip_code) ?>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($user->role === 'lister'): ?>
            <div class="profile-section">
                <h2>Active Listings</h2>
                <?php if (empty($listings)): ?>
                    <div class="empty-state">
                        <p class="text-muted">You have no active listings right now.</p>
                        <?php if ($authUser->id === $user->id): ?>
                            <a href="<?= BASE_URL ?>/pets/create" class="btn primary">Create New Listing</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="listing-history">
                        <?php foreach ($listings as $pet): ?>
                            <div class="adoption-card">
                                <div class="flex items-center" style="gap: 1rem;">
                                    <div class="adoption-pet-image">
                                        <?php if ($pet->images()[0]): ?>
                                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($pet->images()[0]->image_path) ?>"
                                                alt="<?= htmlspecialchars($pet->name) ?>">
                                        <?php else: ?>
                                            <div class="pet-placeholder">🐾</div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="adoption-details">
                                        <h3><?= htmlspecialchars($pet->name) ?></h3>
                                        <p class="pet-info">
                                            <?= htmlspecialchars($pet->breed) ?> •
                                            <?= htmlspecialchars($pet->age) ?>
                                        </p>
                                        <p class="application-date">
                                            Listed on: <?= date('M j, Y', strtotime($pet->created_at)) ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="">
                                    <a href="<?= BASE_URL ?>/pets/<?= $pet->id ?>" class="btn secondary">View Listing</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Adoption History Section -->
            <div class="profile-section">
                <h2>Adoption History</h2>
                <?php if (empty($adoptionHistory)): ?>
                    <div class="empty-state">
                        <p class="text-muted">No adoption applications yet!</p>
                        <?php if ($authUser->id === $user->id): ?>
                            <p class="text-muted">Ready to find your furry friend? <a href="<?= BASE_URL ?>/pets">Browse pets</a></p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="adoption-history">
                        <?php foreach ($adoptionHistory as $application): ?>
                            <div class="adoption-card justify-between">
                                <div class="flex items-center" style="gap: 1rem;">
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
                                            <?= htmlspecialchars($application['age']) ?>
                                        </p>
                                        <p class="application-date">
                                            Applied on: <?= date('M j, Y', strtotime($application['created_at'])) ?>
                                        </p>

                                    </div>
                                </div>
                                <div
                                    class="application-status status-<?= strtolower($application['status']) ?>"
                                    style="height: fit-content;">
                                    <?php
                                    $statusText = [
                                        'pending' => 'Pending Review',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected'
                                    ];
                                    echo $statusText[$application['status']] ?? ucfirst($application['status']);
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php endif; ?>
    </div>
    <!-- Favorited Pets Section -->
    <div class="profile-section">
        <h2>Favorited Pets</h2>
        <?php if (empty($favoritedPets)): ?>
            <p class="text-muted">No favorites... yet</p>
            <?php if ($authUser->id === $user->id): ?>
                <a href="<?= BASE_URL ?>/pets" class="btn primary">Browse Pets</a>
            <?php endif; ?>
        <?php else: ?>
            <div class="listing-history">
                <?php foreach ($favoritedPets as $pet): ?>
                    <div class="adoption-card">
                        <div class="flex items-center" style="gap: 1rem;">
                            <div class="adoption-pet-image">
                                <?php if ($pet->images()[0] ?? null): ?>
                                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars($pet->images()[0]->image_path) ?>"
                                        alt="<?= htmlspecialchars($pet->name) ?>">
                                <?php else: ?>
                                    <div class="pet-placeholder">🐾</div>
                                <?php endif; ?>
                            </div>

                            <div class="adoption-details">
                                <h3><?= htmlspecialchars($pet->name) ?></h3>
                                <p class="pet-info"><?= htmlspecialchars($pet->breed) ?> • <?= htmlspecialchars($pet->age) ?></p>
                                <p class="application-date">Listed on: <?= date('M j, Y', strtotime($pet->created_at)) ?></p>
                            </div>
                        </div>
                        <div>
                            <a href="<?= BASE_URL ?>/pets/<?= $pet->id ?>" class="btn secondary">View Listing</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>