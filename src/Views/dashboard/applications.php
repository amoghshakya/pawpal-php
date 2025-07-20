<?php

use App\Models\PetStatus;
use App\Utils\Utils;


$title = "Dashboard - Applications";
$extraStyles = [
    'dashboard_index.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<?php include __DIR__ . '/../partials/dashboard_header.php'; ?>

<div class="container main-content">
    <div class="tabs">
        <div class="tab-list">
            <a href="<?= BASE_URL ?>/dashboard" class="btn secondary tab-button">My Listings</a>
            <a href="<?= BASE_URL ?>/dashboard/applications" class="btn secondary tab-button active">Applications</a>
        </div>
    </div>

    <!-- Listings Tab -->
    <div id="listings" class="tab-content active">
        <div class="section-header">
            <h2>Adoption Applications</h2>
            <div class="filter-section" style="width: fit-content;">
                <span class="status-badge badge-pending" id="totalApplications">
                    <?= array_reduce($pets, function ($carry, $pet) {
                        return $carry + count($pet->applications());
                    }, 0) ?> Total Applications
                </span>
                <select id="filterSelect" class="select">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>



        <div class="" id="applicationsContainer">
            <?php if (empty($pets)): ?>
                <p class="text-muted">No applications found.</p>
            <?php endif; ?>
            <?php foreach ($pets as $pet): ?>
                <div class="applications-by-pet">
                    <div class="pet-section-header">
                        <img src="<?= BASE_URL . $pet->images()[0]->image_path ?>" alt="<?= $pet->name ?>" class="pet-thumbnail" />
                        <div class="pet-info">
                            <h3><?= htmlspecialchars($pet->name) ?></h3>
                            <p>
                                <?= htmlspecialchars($pet->species) ?> &middot;
                                <?= htmlspecialchars($pet->breed) ?> &middot;
                                <?= htmlspecialchars($pet->age) ?>
                            </p>
                        </div>
                        <div class="pet-stats">
                            <div class="applications-count"><?= count($pet->applications()) ?></div>
                            <div class="status-text">Applications</div>
                        </div>
                    </div>
                    <div class="applications-list">
                        <?php foreach ($pet->applications() as $application): ?>
                            <div class="application-card">
                                <div class="application-header">
                                    <div class="applicant-info">
                                        <div class="avatar">
                                            <?= Utils::initials($application->applicant()->name) ?>
                                        </div>
                                        <div class="applicant-details">
                                            <h4>
                                                <?= htmlspecialchars($application->applicant()->name) ?>
                                            </h4>
                                            <p>Applied <?= date_format(new DateTime($application->created_at), 'M d, Y') ?></p>
                                        </div>
                                    </div>
                                    <div class="application-actions">
                                        <span class="status-badge badge-pending">
                                            <?= $application->status->name ?>
                                        </span>
                                        <button class="secondary" onclick="fetchAndShowApplication(<?= $application->id ?>)">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                                <div class="application-content">
                                    <div class="contact-info">
                                        <div class="contact-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>
                                            <?= htmlspecialchars($application->applicant()->email) ?>
                                        </div>
                                        <div class="contact-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                            </svg>
                                            <?= htmlspecialchars($application->applicant()->phone) ?>
                                        </div>
                                        <div class="contact-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            <?= htmlspecialchars($application->applicant()->address) ?>,
                                            <?= htmlspecialchars($application->applicant()->city) ?><?= isset($application->applicant()->zip_code) ? ' ' . $application->applicant()->zip_code : '' ?>,
                                            <?= htmlspecialchars($application->applicant()->state) ?>
                                        </div>
                                        <div class="contact-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                            </svg>
                                            <?= htmlspecialchars($application->housing_type->name) ?>
                                            (<?= htmlspecialchars($application->own_or_rent->name) ?>)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div id="applicationModal" class="modal">
    <div class="modal-content">
        <button class="unset close-btn" onclick="closeModal()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="modal-header">
            <h2 id="modalTitle">Application Details</h2>
            <p id="modalDescription"></p>
        </div>
        <div class="modal-body" id="modalBody"></div>
    </div>
</div>

<script defer>
    const totalApplicationCount = document.getElementById('totalApplications');

    function initials(name) {
        const words = name.trim().split(/\s+/);

        if (words.length === 0) return '';
        if (words.length === 1) return words[0][0].toUpperCase();

        return (words[0][0] + words[words.length - 1][0]).toUpperCase();
    }


    function approveApplication() {
        document.getElementById('applicationStatus').value = 'approved';
        document.getElementById('statusUpdateForm').submit();
    }

    function rejectApplication() {
        document.getElementById('applicationStatus').value = 'rejected';
        document.getElementById('statusUpdateForm').submit();
    }

    function closeModal() {
        const modal = document.getElementById('applicationModal');
        modal.classList.remove('active');
        document.getElementById('modalBody').innerHTML = '';
        document.getElementById('modalDescription').textContent = '';
    }

    function renderApplications(data) {
        const container = document.getElementById('applicationsContainer');
        container.innerHTML = '';

        // Clear the container before rendering new data
        container.innerHTML = '';

        for (const item of data) {
            totalApplicationCount.textContent = item.applications.length + ' Total Applications';
            if (!item.applications.length) {
                container.innerHTML = '<p class="text-muted">No applications found.</p>';
                continue;
            }
            container.innerHTML += `
                <div class="applications-by-pet">
                    <div class="pet-section-header">
                        <img src="<?= BASE_URL ?>${item.pet.image_url}" alt="${item.pet.name}" class="pet-thumbnail" />
                        <div class="pet-info">
                            <h3>${item.pet.name}</h3>
                            <p>
                                ${item.pet.species} &middot;
                                ${item.pet.breed} &middot;
                                ${item.pet.age}
                            </p>
                        </div>
                        <div class="pet-stats">
                            <div class="applications-count">${item.applications.length}</div>
                            <div class="status-text">Applications</div>
                        </div>
                    </div>
                    <div class="applications-list">
                        ${item.applications.map(app => `
                            <div class="application-card">
                                <div class="application-header">
                                    <div class="applicant-info">
                                        <div class="avatar">
                                        ${app.user.profile_image ? `<img src="${app.user.profile_image}" alt="${app.user.name}">` : initials(app.user.name)}
                                        </div>
                                        <div class="applicant-details">
                                            <h4>
                                            ${app.user.name}
                                            </h4>
                                            <p>
                                                Applied ${new Date(app.created_at).toLocaleDateString('en-US', {
                                                    month: 'short',
                                                    day: 'numeric',
                                                    year: 'numeric'
                                                })}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="application-actions">
                                        <span class="status-badge badge-pending">
                                        ${app.status}
                                        </span>
                                        <button class="secondary" onclick="fetchAndShowApplication(${app.id})">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                                <div class="application-content">
                                    <div class="contact-info">
                                        <div class="contact-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>
                                            ${app.user.email}
                                        </div>
                                        <div class="contact-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                            </svg>
                                            ${app.user.phone}
                                        </div>
                                        <div class="contact-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                            </svg>
                                            ${app.address},
                                            ${app.city}${app.zip_code ? ' ' + app.zip_code : ''},
                                            ${app.state}
                                        </div>
                                        <div class="contact-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                            </svg>
                                            ${app.housing_type}
                                            (${app.own_or_rent})
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `)}
                    </div>
                </div>
                `;
        }
    }

    function renderApplicationData(data) {
        const modal = document.getElementById('applicationModal');
        const modalDescription = document.getElementById('modalDescription');
        const modalBody = document.getElementById('modalBody');

        modalDescription.textContent = `Application from ${data.user.name} for ${data.pet.name}`;
        modalBody.innerHTML = `
            <div class="detail-section">
                <h4> 
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                    Contact Information
                </h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span>Email:</span>
                        <p>${data.user.email}</p>
                    </div>
                    <div class="detail-item">
                        <span>Phone:</span>
                        <p>${data.user.phone}</p>
                    </div>
                    <div class="detail-item" style="grid-column: 1 / -1;">
                        <span>Address:</span>
                    <p>
                    ${data.address}, ${data.city}, ${data.state} ${data.zip_code ? data.zip_code : ''}
                    </p>
                    </div>
                </div>
            </div>

            <div class="separator"></div>

            <div class="detail-section">
                <h4>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
</svg>
                 Housing Information</h4>
                 </div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span>Housing Type:</span>
                        <p>${data.housing_type}</p>
                    </div>
                    <div class="detail-item">
                        <span>Ownership:</span>
                        <p>${data.own_or_rent}</p>
                    </div>

                    ${data.own_or_rent === 'Rent' ? `
                        <div class="detail-item" style="grid-column: 1 / -1;">
                            <span>Landlord's Permission:</span>
                            <p>${data.landlord_permission}</p>
                        </div>
                    `: ``}
                </div>
            </div>

            <div class="separator"></div>

            <div class="detail-section">
                <h4>

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
</svg>
                   Current Pets</h4>

                ${data.has_other_pets ? `<p>${data.other_pets_details}</p>` : `<p>None</p>`}
            </div>

            <div class="separator"></div>

            <div class="detail-section">
                <h4>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" fill="none" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12.252 6v6h4.5"></path>
  <path stroke-linecap="round" stroke-linejoin="round" d="M5.887 5.636A9 8.996 45 0 1 16.75 4.208a9 8.996 45 0 1 4.194 10.123 9 8.996 45 0 1-8.69 6.667 9 8.996 45 0 1-8.693-6.67m2.327-8.692L3.38 8.143M3.363 3.15v5.013m0 0h5.013"></path>
</svg>
                    Pet Experience</h4>
                <p class="text-muted">${data.experience}</p>
            </div>

            <div class="detail-section">
                <h4>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
</svg>
                    Living Conditions</h4>
                <p class="text-muted">${data.living_conditions}</p>
            </div>

            <div class="detail-section">
                <h4>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Hours Pet Unattended
                </h4>
                <p class="text-muted">${data.hours_alone} per day</p>
            </div>

            <div class="separator"></div>

            <div class="detail-section">
                <h4>
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
</svg>
                    Message from Applicant</h4>
                <div class="message-box">
                    <p>${data.message ? data.message : `<span class="text-muted">No message</span>`}</p>
                </div>
            </div>
           ${data.status === 'Pending' ? ` 
            <form id="statusUpdateForm" method="POST" action="<?= BASE_URL ?>/dashboard/applications">
                <input type="hidden" name="id" value="${data.id}" />
                <input type="hidden" name="status" id="applicationStatus" value="${data.status.toLowerCase()}" />
                <div class="action-buttons">
                    <button class="primary" onclick="approveApplication()">
                        Approve Application
                    </button>
                    <button class="secondary" onclick="rejectApplication()">
                        Reject Application
                    </button>
                </div>
            </form>` : `<button class="disabled">Application ${data.status}</button>`}
`;

        modal.classList.add('active');
    }

    function fetchAndShowApplication(id) {
        fetch(`<?= BASE_URL ?>/dashboard/applications/search?id=${id}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then((data) => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                renderApplicationData(data);
            })
    }

    document.getElementById('filterSelect').addEventListener('change', function() {
        const selectedStatus = this.value;

        fetch(`<?= BASE_URL ?>/dashboard/applications/filter?status=${selectedStatus}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                renderApplications(data);
            })
            .catch(err => console.error('Error fetching filtered applications:', err));
    });
</script>