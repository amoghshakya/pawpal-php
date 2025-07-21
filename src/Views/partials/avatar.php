<?php

use App\Utils\Auth;
use App\Utils\Utils;

$navUser = Auth::user();
?>

<style>
	/* Put your avatar dropdown CSS here */
	.avatar-dropdown {
		position: relative;
		display: inline-block;
	}

	.avatar-btn {
		background: none;
		border: none;
		cursor: pointer;
		padding: 0;
		margin-right: 1rem;
		border-radius: 50%;
		overflow: hidden;
	}

	#avatar-image {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		object-fit: cover;
	}

	.dropdown-menu {
		position: absolute;
		right: 0;
		top: 110%;
		background: #fff;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		border-radius: 6px;
		padding: 0.5rem;
		min-width: 200px;
		display: none;
		z-index: 999;
		font-size: 0.9rem;
	}

	.dropdown-menu form {
		width: 100%;
	}

	.dropdown-menu a,
	.dropdown-menu button {
		all: unset;
		border-radius: 6px;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		gap: 0.5rem;
		width: 100%;
		padding: 0.5rem 1rem;
		text-align: left;
		background: none;
		color: #333;
		cursor: pointer;
		transition: all 0.1s ease-in 0.05s;
	}

	.dropdown-menu a:hover,
	.dropdown-menu button:hover {
		background-color: #f0f0f0;
	}

	.dropdown-menu button:hover {
		color: var(--background);
		background-color: var(--danger);
	}

	.dropdown-icon {
		position: absolute;
		right: -50%;
		top: 25%;
		width: 20px;
	}

	.dropdown-icon svg {
		width: 50%;
		height: auto;
	}

	.separator {
		height: 1px;
		background-color: #e5e7eb;
		margin: 0.2rem 0;
	}
</style>

<div class="avatar-dropdown">
	<div class="avatar">
		<button class="unset" style="cursor: pointer;" id="avatarBtn">
			<?php if ($navUser->profile_image): ?>
				<img src="<?= BASE_URL . '/' . $navUser->profile_image ?>" alt="<?= $navUser->name ?>'s Avatar" id="avatar-image" />
			<?php else: ?>
				<?= Utils::initials($navUser->name) ?>
			<?php endif; ?>
		</button>
	</div>

	<div class="dropdown-icon">
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-4">
			<path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
		</svg>
	</div>

	<div class="dropdown-menu" id="avatarDropdown">
		<a href="<?= BASE_URL ?>/pets">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-5">
				<path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
			</svg>
			Browse Pets
		</a>
		<a href="<?= BASE_URL ?>/profile">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-5">
				<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"></path>
			</svg>
			Profile
		</a>
		<?php if (Auth::role() === 'lister'): ?>
			<a href="<?= BASE_URL ?>/dashboard">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" fill="none" class="size-5">
					<path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m-4.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125Z"></path>
				</svg>
				Dashboard
			</a>
		<?php endif; ?>
		<div class="separator"></div>
		<form
			action="<?= BASE_URL ?>/logout"
			method="POST"
			class="unset">
			<button type="submit">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-5">
					<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15"></path>
				</svg>
				Logout
			</button>
		</form>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', () => {
		const avatarBtn = document.getElementById('avatarBtn');
		const dropdown = document.getElementById('avatarDropdown');

		avatarBtn.addEventListener('click', (e) => {
			e.stopPropagation();
			dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
		});

		document.body.addEventListener('click', () => {
			dropdown.style.display = 'none';
		});
	});
</script>