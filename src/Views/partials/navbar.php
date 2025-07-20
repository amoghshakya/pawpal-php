<?php

use App\Utils\Auth;
use App\Utils\Utils;

?>

<style>
    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 2rem;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .nav-links {
        @media (max-width: 768px) {
            display: none;
        }
    }

    .nav-links ul {
        display: flex;
        gap: 1.5rem;
        list-style: none;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    /* specificity wins */
    .nav-links ul li a {
        text-decoration: none;
        color: #343a40;
        font-weight: 500;
        font-size: 0.75rem;
        text-underline-offset: 0.2rem;
        transition: all 0.1s ease-out 0.1s;
    }

    .nav-links ul li a:hover {
        color: #007bff;
        text-decoration: underline;
    }

    .auth-links {
        display: flex;
        gap: 0.5rem;
        align-items: center;

        @media (max-width: 768px) {
            display: none;
        }
    }

    .mobile-menu {
        display: none;

        @media (max-width: 768px) {
            display: block;
        }
    }
</style>

<nav class="navbar">
    <div>
        <!-- Throw in the logo here -->
    </div>
    <div class="nav-links">
        <ul>
            <li><a href="<?= BASE_URL ?>/">Home</a></li>
            <li><a href="<?= BASE_URL ?>/pets">Pets</a></li>
        </ul>
    </div>
    <div class="auth-links">
        <?php if (Auth::isAuthenticated()): ?>
            <div class="avatar">
                <?php if (Auth::isAuthenticated()): ?>
                    <?php $user = Auth::user(); ?>
                    <?php if ($user->profile_image): ?>
                        <img src="<?= BASE_URL . $user->profile_image ?>" alt="<?= $user->name ?>'s Avatar" class="avatar-image" />
                    <?php else: ?>
                        <?= Utils::initials(Auth::user()->name) ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/login" class="btn secondary">Login</a>
            <a href="<?= BASE_URL ?>/register" class="btn primary">Register</a>
        <?php endif; ?>
    </div>
    <div class="mobile-menu">
        <button class="unset" aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
            </svg>
        </button>
    </div>
</nav>