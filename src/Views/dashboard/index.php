<?php

use App\Models\PetStatus;

$title = "Dashboard";
$extraStyles = [
    'dashboard_index.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>


<div class="header">
    <div class="container">
        <h1>Dashboard</h1>
        <p>Manage your listings and adoption applications</p>
    </div>
</div>

<div class="container main-content">
    <div class="tabs">
        <div class="tab-list">
            <a href="<?= BASE_URL ?>/dashboard" class="unset btn secondary tab-button active">My Listings</a>
            <a href="<?= BASE_URL ?>/dashboard/applications" class="unset btn secondary tab-button">Applications</a>
        </div>
    </div>

    <!-- Listings Tab -->
    <div id="listings" class="tab-content active">
        <div class="section-header">
            <div class="search-bar">
                <input
                    type="search"
                    class="search-input"
                    placeholder="Search by name, species, or breed"
                    id="searchInput" />
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
            </div>
            <div>
                <a href="<?= BASE_URL ?>/pets/create" class="btn primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add New Listing
                </a>
            </div>
        </div>

        <div class="filter-section">
            <select id="filterSelect" class="select">
                <option value="all">All Listings</option>
                <option value="adopted">Adopted</option>
                <option value="available">Available</option>
            </select>
        </div>


        <div class="grid grid-cols-3" id="listingsGrid">
            <?php foreach ($listings as $pet): ?>
                <div class="card">
                    <div class="card-image-container">
                        <img
                            src="<?= BASE_URL . $pet->images()[0]->image_path ?>"
                            alt="<?= htmlspecialchars($pet->name) ?>" class="card-image" />
                        <span class="status-badge listing-status-badge badge-<?= $pet->status->value ?>">
                            <?= htmlspecialchars($pet->status->name) ?>
                        </span>
                    </div>
                    <div class="card-header">
                        <div class="card-title">
                            <?= htmlspecialchars($pet->name) ?>
                            <div class="card-actions">
                                <a href="<?= BASE_URL ?>/pets/<?= $pet->id ?>" class="btn secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <a href="<?= BASE_URL ?>/pets/<?= $pet->id ?>/edit" class="btn secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-description">
                            <?= htmlspecialchars($pet->species) ?> &middot;
                            <?= htmlspecialchars($pet->breed) ?> &middot;
                            <?= htmlspecialchars($pet->age) ?>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="info-grid">
                            <div class="info-row">
                                <span>Applications:</span>
                                <span class="status-badge badge-pending">
                                    <?= count($pet->applications()) ?>
                                </span>
                            </div>
                            <div class="info-row">
                                <span>Posted:</span>
                                <span>
                                    <?= date_format(new DateTime($pet->created_at), 'M d, Y') ?>
                                </span>
                            </div>
                            <?php if ($pet->status === PetStatus::Adopted): ?>
                                <div class="info-row">
                                    <span>Adopted:</span>
                                    <span><?= htmlspecialchars(
                                                date_format(new DateTime($pet->updated_at), 'M d, Y')
                                            ) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script defer>
    function debounce(fn, delay) {
        let timeoutId;
        return function(...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                fn.apply(this, args);
            }, delay);
        };
    }

    function formatDate(dateString) {
        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        };
        const date = new Date(dateString);
        if (isNaN(date)) return ''; // invalid date safeguard
        return date.toLocaleDateString(undefined, options); // e.g. "Jul 19, 2023"
    }

    // would be the same as defer but ensures the script runs after the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterSelect = document.getElementById('filterSelect');
        const listingsGrid = document.getElementById('listingsGrid');

        // store it so we can reset it later
        const initialListings = listingsGrid.innerHTML;

        const sanitize = (str) => {
            return str.replace(/[&<"'>]/g, (c) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            } [c]))
        }

        function renderListings(pets) {
            listingsGrid.innerHTML = '';

            if (pets.length === 0) {
                listingsGrid.innerHTML = `<p class="text-muted small">No listings found.</p>`;
                return;
            }

            console.log(pets);

            for (const pet of pets) {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <div class="card-image-container">
                        <img src="<?= BASE_URL ?>${pet.image_url}" alt="${pet.name}" class="card-image" />
                        <span class="status-badge listing-status-badge badge-${pet.status[0].toLowerCase() + pet.status.slice(1)}">
                            ${pet.status.charAt(0).toUpperCase() + pet.status.slice(1)}
                        </span>
                    </div>
                    <div class="card-header">
                        <div class="card-title">
                            ${pet.name}
                            <div class="card-actions">
                                <a href="<?= BASE_URL ?>/pets/${pet.id}" class="btn secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <a href="<?= BASE_URL ?>/pets/${pet.id}/edit" class="btn secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-description">
                            ${pet.species} &middot; ${pet.breed} &middot; ${pet.age}
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="info-grid">
                            <div class="info-row">
                                <span>Applications:</span>
                                <span class="status-badge badge-pending">${pet.app_count}</span>
                            </div>
                            <div class="info-row">
                                <span>Posted:</span>
                                <span>${formatDate(pet.created_at)}</span>
                            </div>
                        </div>
                    </div>
                `;
                listingsGrid.appendChild(card);
            }
        }

        function fetchPets() {
            const searchTerm = searchInput.value.trim();
            const selectedFilter = filterSelect.value;

            // if both are default, show original listings
            if (!searchTerm && selectedFilter === 'all') {
                listingsGrid.innerHTML = initialListings;
                return;
            }

            const params = new URLSearchParams();
            if (searchTerm) {
                params.append('search', searchTerm);
            }

            if (selectedFilter != 'all') {
                params.append('status', selectedFilter);
            }

            fetch(`<?= BASE_URL ?>/dashboard/search?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then((res) => res.json())
                .then((data) => {
                    renderListings(data);
                })
                .catch((err) => {
                    console.error('Search failed:', err);
                });
        }

        searchInput.addEventListener('input', debounce(fetchPets, 300));
        filterSelect.addEventListener('change', fetchPets);
    })
</script>