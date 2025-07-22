<?php
$title = "PawPal - Pets";
$extraStyles = [
    'pet_index.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<?php include __DIR__ . '/../partials/navbar.php'; ?>

<main class="main-content">
    <!-- <div class="container">
        <h2 class="main-title">Browse Pets</h2>
        <p class="text-muted">Find your new furry friend!</p>
    </div> -->
    <div class="container">
        <!-- Search and Filter Section -->
        <section class="search-section">
            <div class="search-bar">
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <input
                    type="search"
                    class="search-input"
                    placeholder="Search by name, species, or breed"
                    id="searchInput" />
                <div class="inline">
                    <button class="primary" id="searchButton">Search</button>
                </div>
            </div>

            <div class="filter-container">
                <!-- TODO: Implement filter functionality -->
                <div class="filter-item">
                    <label for="gender">Gender:</label>
                    <select id="gender" class="filter-dropdown">
                        <option value="">All Genders</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="unknown">Unknown</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label for="vaccinated">Vaccinated:</label>
                    <select id="vaccinated" class="filter-dropdown">
                        <option value="">All</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <!-- Adopted Toggle -->
                <div class="filter-item">
                </div>

                <button class="secondary" onclick="clearFilters()">Clear Filters</button>
            </div>
        </section>

        <!-- Results Count -->
        <div class="results-info" id="resultsInfo">
            <span class="results-text">
                Showing <?= count($pets) ?> available pets
            </span>
        </div>

        <!-- Pets Grid -->
        <section class="pets-container" id="petsContainer">
            <?php foreach ($pets as $pet): ?>
                <a href="<?= BASE_URL . '/pets/' . $pet->id ?>" style="all: unset;">
                    <div class="pet-card">
                        <div class="pet-image">
                            <img
                                src="<?= BASE_URL . $pet->getImages()[0]->image_path ?>"
                                alt="<?= htmlspecialchars($pet->name) ?>"
                                draggable="false" />
                        </div>
                        <div class="pet-content">
                            <div class="pet-header">
                                <div class="pet-title-section">
                                    <h3 class="pet-name"><?= htmlspecialchars($pet->name) ?></h3>
                                    <div class="pet-breed">
                                        <?= htmlspecialchars($pet->breed) ?>
                                        •
                                        <?= htmlspecialchars($pet->species) ?>
                                    </div>
                                </div>
                                <span class="status-badge status-available">Available</span>
                            </div>

                            <div class="pet-info-grid">
                                <!-- Age -->
                                <div class="info-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    <span class="info-value">
                                        <?= htmlspecialchars($pet->age) ?>
                                    </span>
                                </div>
                                <div class="info-item">
                                    <!-- Gender -->
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="info-value">
                                        <?= htmlspecialchars($pet->gender->name) ?>
                                    </span>
                                </div>
                            </div>

                            <p class="pet-description">
                                <?= nl2br(htmlspecialchars($pet->description ?: 'No description available.')) ?>
                            </p>

                            <div class="badge-container">
                                <div class="vaccination-badge vaccinated">
                                    <?= $pet->vaccinated ? 'Vaccinated' : 'Not Vaccinated' ?>
                                </div>
                            </div>

                            <div class="pet-footer">
                                <div class="lister-info">
                                    Listed by: <?= htmlspecialchars($pet->lister()->name) ?>
                                </div>
                                <div class="location-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <span class="location-name">
                                        <?= htmlspecialchars($pet->location) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </section>
    </div>
</main>

<script defer>
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const petsContainer = document.getElementById('petsContainer');
    const genderFilter = document.getElementById("gender");
    const vaccinatedFilter = document.getElementById("vaccinated");
    const resultsInfo = document.getElementById('resultsInfo');

    const clearFilters = () => {
        genderFilter.value = '';
        vaccinatedFilter.value = '';
    };

    function renderPets(pets) {
        const petContainer = document.getElementById('petsContainer');
        petContainer.innerHTML = ''; // Clear existing pets

        resultsInfo.innerHTML = `<span class="results-text">Showing ${pets.length} available pets</span>`;
        for (const pet of pets) {
            petContainer.innerHTML += `
                <a href="<?= BASE_URL . '/pets' ?>/${pet.id}" style="all: unset;">
                    <div class="pet-card">
                        <div class="pet-image">
                            <img
                                src="<?= BASE_URL ?>${pet.image_url}"
                                alt="${pet.name}"
                                draggable="false" />
                        </div>
                        <div class="pet-content">
                            <div class="pet-header">
                                <div class="pet-title-section">
                                    <h3 class="pet-name">${pet.name}</h3>
                                    <div class="pet-breed">
                                        ${pet.breed}
                                        •
                                        ${pet.species}
                                    </div>
                                </div>
                                <span class="status-badge status-available">Available</span>
                            </div>

                            <div class="pet-info-grid">
                                <!-- Age -->
                                <div class="info-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    <span class="info-value">
                                    ${pet.age}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <!-- Gender -->
                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="info-value">
                                        ${pet.gender}
                                    </span>
                                </div>
                            </div>

                            <p class="pet-description">
                                ${pet.description}
                            </p>

                            <div class="badge-container">
                                <div class="vaccination-badge vaccinated">
                                    ${pet.vaccinated ? 'Vaccinated' : 'Not Vaccinated'}
                                </div>
                            </div>

                            <div class="pet-footer">
                                <div class="lister-info">
                                    Listed by: ${pet.lister.name}
                                </div>
                                <div class="location-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <span class="location-name">
                                        ${pet.location}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                `;
        }
    }

    function fetchPets() {
        const search = searchInput.value.trim();
        const gender = genderFilter.value;
        const vaccinated = vaccinatedFilter.value;

        const params = new URLSearchParams();

        if (search) {
            params.append('search', search);
        }
        if (gender) {
            params.append('gender', gender);
        }
        if (vaccinated) {
            params.append('vaccinated', vaccinated);
        }

        fetch(`<?= BASE_URL ?>/pets?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then((req) => req.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                }
                renderPets(data);
            });
    }

    searchButton.addEventListener('click', fetchPets);
</script>