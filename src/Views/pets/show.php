<?php

use App\Models\Favorite;
use App\Models\User;
use App\Utils\Utils;

$title = "PawPal - $pet->name";
$extraStyles = [
	'pet_show.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<?php include __DIR__ . '/../partials/navbar.php'; ?>

<div class="container main-content">
	<div class="grid grid-lg">
		<!-- Main Content -->
		<div class="space-y">
			<!-- Pet Images and Basic Info -->
			<div class="card">
				<div class="carousel-container">
					<div class="carousel" id="petCarousel">
						<div class="carousel-track" id="carouselTrack">
							<?php foreach ($pet->images() as $image): ?>
								<div class="carousel-slide">
									<img
										src="<?= BASE_URL . $image->image_path ?>"
										alt="<?= htmlspecialchars($pet->name) ?> - Photo" />
									<?php if ($image->caption): ?>
										<div class="carousel-caption">
											<?= htmlspecialchars($image->caption) ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>

						<button class="carousel-nav carousel-prev" onclick="previousSlide()">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
							</svg>
						</button>

						<button class="carousel-nav carousel-next" onclick="nextSlide()">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
							</svg>

						</button>

						<div class="carousel-indicators" id="carouselIndicators">
							<?php for ($i = 0; $i < count($pet->images()); $i++): ?>
								<button class="carousel-indicator <?= $i === 0 ? 'active' : '' ?>" onclick="goToSlide(<?= $i ?>)"></button>
							<?php endfor; ?>
						</div>
					</div>

					<div class="status-badge"><?= htmlspecialchars($pet->status->name) ?></div>
				</div>

				<div class="card-content">
					<div class="pet-header">
						<h1 class="pet-name"><?= htmlspecialchars($pet->name) ?></h1>
						<p class="pet-breed"><?= htmlspecialchars($pet->breed) . " • " . htmlspecialchars($pet->species) ?></p>
					</div>

					<div class="pet-info-grid">
						<div class="info-card">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
							</svg>

							<p class="info-card-title">Age</p>
							<p class="info-card-value"><?= htmlspecialchars($pet->age) ?></p>
						</div>
						<div class="info-card">
							<svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
							</svg>
							<p class="info-card-title">Gender</p>
							<p class="info-card-value">
								<?= htmlspecialchars($pet->gender->name) ?>
							</p>
						</div>
						<div class="info-card">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
							</svg>

							<p class="info-card-title">Vaccinated</p>
							<p class="info-card-value">
								<?= $pet->vaccinated ? 'Yes' : 'No' ?>
							</p>
						</div>
						<div class="info-card">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
								<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
							</svg>

							<p class="info-card-title">Location</p>
							<p class="info-card-value">
								<?= htmlspecialchars($pet->location) ?>
							</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Description -->
			<div class="card">
				<div class="card-header">
					<h2 class="card-title">About <?= htmlspecialchars($pet->name) ?></h2>
				</div>
				<div class="card-content">
					<p>
						<?= nl2br(htmlspecialchars($pet->description)) ?>
					</p>
				</div>
			</div>

			<!-- Special Needs -->
			<?php if ($pet->special_needs): ?>
				<div class="card">
					<div class="card-header">
						<h2 class="card-title">Special Needs</h2>
					</div>
					<div class="card-content">
						<p>
							<?= htmlspecialchars($pet->special_needs) ?>
						</p>
					</div>
				</div>
			<?php endif; ?>

			<!-- Medical Information -->
			<div class="card">
				<div class="card-header">
					<h2 class="card-title">Medical Information</h2>
				</div>
				<div class="card-content">
					<div class="medical-section">
						<div class="medical-header">
							<svg class="icon text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
							</svg>
							<span style="font-weight: 500;">Vaccination Status</span>
						</div>
						<?php if ($pet->vaccinated): ?>
							<p class="medical-status">Fully Vaccinated</p>
							<div class="vaccination-details">
								<p>
									<?= nl2br($pet->vaccination_details) ?>
								</p>
							</div>
						<?php else: ?>
							<p class="medical-status">Not Vaccinated</p>
							<div class="vaccination-details danger">
								<p>This pet has not yet been vaccinated. Please discuss vaccination options with the lister.</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Sidebar -->
		<div class="space-y">
			<!-- Lister Information -->
			<div class="card">
				<div class="card-header">
					<h2 class="card-title">Listed by</h2>
					<?php
					$user = isset($_SESSION['user_id']) ? User::find($_SESSION['user_id']) : null;
					$isUserFavorite = $user && Favorite::findByUnique($user->id, $pet->id);
					?>
					<?php if ($user && $pet->lister()->id !== $user->id): ?>
						<button
							class="unset <?= $isUserFavorite ? 'active' : '' ?>"
							id="favorite">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"></path>
							</svg>
						</button>
					<?php endif; ?>
				</div>
				<div class="card-content">
					<div class="lister-info">
						<div class="avatar">
							<?php if ($pet->lister()->profile_image): ?>
								<img
									src="<?= BASE_URL . $pet->lister()->profile_image ?>"
									alt="<?= htmlspecialchars($pet->lister()->name) ?>'s profile picture" />
							<?php else: ?>
								<?= Utils::initials($pet->lister()->name) ?>
							<?php endif; ?>
						</div>
						<div>
							<p class="lister-name">
								<?= htmlspecialchars($pet->lister()->name) ?>
							</p>
							<p class="lister-location">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
									<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
									<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
								</svg>

								<?= htmlspecialchars($pet->lister()->address) ?>, <?= htmlspecialchars($pet->lister()->city) ?>
							</p>
						</div>
					</div>
					<div style="display: flex; flex-direction: column; gap: 0.5rem;">
						<?php if (!isset($_SESSION['user_id'])): ?>
							<a href="<?= BASE_URL ?>/login" class="btn secondary">
								Log in to contact lister
							</a>
						<?php elseif ($_SESSION['user_id'] === $pet->user_id): ?>
							<a href="<?= BASE_URL . '/pets/' . $pet->id . '/edit' ?>" class="btn secondary">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
									<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
								</svg>
								Edit Listing
							</a>
						<?php elseif ($pet->status->name === 'adopted'): ?>
							<button class="disabled">This pet has already been adopted.</button>
						<?php else: ?>
							<a href="tel:<?= $pet->lister()->phone ?>" class="btn primary" onclick="">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
									<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
								</svg>
								Contact About <?= htmlspecialchars($pet->name) ?>
							</a>
							<a class="btn secondary" href="<?= BASE_URL . '/pets/' . $pet->id . '/apply' ?>">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
									<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
								</svg>

								Apply for Adoption
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<!-- Adoption Process -->
			<div class="card">
				<div class="card-header">
					<h2 class="card-title">Adoption Process</h2>
				</div>
				<div class="card-content">
					<div class="process-steps">
						<div class="process-step">
							<div class="step-number">1</div>
							<p class="step-text">Contact the lister to express interest</p>
						</div>
						<div class="process-step">
							<div class="step-number">2</div>
							<p class="step-text">Schedule a meet and greet</p>
						</div>
						<div class="process-step">
							<div class="step-number">3</div>
							<p class="step-text">Complete adoption paperwork</p>
						</div>
						<div class="process-step">
							<div class="step-number">4</div>
							<p class="step-text">Welcome your new family member!</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Safety Tips -->
			<div class="card">
				<div class="card-header">
					<h2 class="card-title" style="display: flex; align-items: center; gap: 0.5rem;">
						<svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
						</svg>
						Safety Tips
					</h2>
				</div>
				<div class="card-content">
					<ul class="safety-tips">
						<li>Always meet in a public place first</li>
						<li>Ask for veterinary records</li>
						<li>Verify the pet's health status</li>
						<li>Trust your instincts</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	const favoriteButton = document.getElementById('favorite');

	favoriteButton.addEventListener('click', async function() {
		const petId = <?= $pet->id ?>;

		try {
			const response = await fetch(`<?= BASE_URL ?>/pets/${petId}`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: JSON.stringify({
					pet_id: petId
				})
			});

			const result = await response.json();
			if (response.ok) {
				favoriteButton.classList.toggle('active');
			}
		} catch (error) {
			console.error('Error saving pet:', error);
			return;
		}
	})
</script>

<script defer>
	let currentSlide = 0;
	const totalSlides = <?= count($pet->images()) ?>;

	function updateCarousel() {
		const track = document.getElementById('carouselTrack');
		const indicators = document.querySelectorAll('.carousel-indicator');
		const captions = document.querySelectorAll('.carousel-caption');

		track.style.transform = `translateX(-${currentSlide * 100}%)`;

		indicators.forEach((indicator, index) => {
			indicator.classList.toggle('active', index === currentSlide);
		});

		// Fade in caption after slide transition
		setTimeout(() => {
			captions.forEach((caption, index) => {
				if (index === currentSlide) {
					caption.style.opacity = '1';
				} else {
					caption.style.opacity = '0.8';
				}
			});
		}, 150);
	}

	function nextSlide() {
		currentSlide = (currentSlide + 1) % totalSlides;
		updateCarousel();
	}

	function previousSlide() {
		currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
		updateCarousel();
	}

	function goToSlide(slideIndex) {
		currentSlide = slideIndex;
		updateCarousel();
	}

	function toggleSave() {
		const saveText = document.getElementById('save-text');
		if (saveText.textContent === 'Save Pet') {
			saveText.textContent = 'Saved!';
			alert('Pet saved to your favorites!');
		} else {
			saveText.textContent = 'Save Pet';
			alert('Pet removed from favorites.');
		}
	}

	function contactLister() {
		alert('Contacting Sarah Johnson about Luna...\n\nIn a real application, this would open a contact form or initiate a phone call.');
	}

	function sendMessage() {
		alert('Opening message composer...\n\nIn a real application, this would open a messaging interface.');
	}

	// Auto-advance carousel every 5 seconds
	setInterval(nextSlide, 5000);

	// Touch/swipe support for mobile
	let startX = 0;
	let endX = 0;

	document.getElementById('petCarousel').addEventListener('touchstart', function(e) {
		startX = e.touches[0].clientX;
	});

	document.getElementById('petCarousel').addEventListener('touchend', function(e) {
		endX = e.changedTouches[0].clientX;
		handleSwipe();
	});

	function handleSwipe() {
		const threshold = 50;
		const diff = startX - endX;

		if (Math.abs(diff) > threshold) {
			if (diff > 0) {
				nextSlide();
			} else {
				previousSlide();
			}
		}
	}
</script>