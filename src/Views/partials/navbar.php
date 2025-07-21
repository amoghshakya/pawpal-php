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
        position: absolute;
        left: 50%;
        transform: translateX(-50%);

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

    .logo svg {
        height: 50px;
        cursor: pointer;
    }
</style>

<nav class="navbar">
    <div class="logo">
        <a href="<?= BASE_URL ?>/" class="unset">
            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 309.33 224.68" draggable="false">
                <defs>
                    <style>
                        .cls-1 {
                            fill: #652c8f;
                        }

                        .cls-2 {
                            fill: #281649;
                        }
                    </style>
                </defs>
                <ellipse class="cls-1" cx="53.79" cy="82.49" rx="4.04" ry="4.44" transform="translate(-5.6 3.94) rotate(-3.98)" />
                <ellipse class="cls-1" cx="36.52" cy="85.79" rx="5.72" ry="7.8" transform="translate(-50.98 53.59) rotate(-46.74)" />
                <ellipse class="cls-1" cx="26.31" cy="114.05" rx="5.24" ry="3.42" transform="translate(-9.43 2.6) rotate(-4.79)" />
                <ellipse class="cls-1" cx="25.45" cy="99.78" rx="5.55" ry="8.45" transform="translate(-77.3 106.62) rotate(-79.5)" />
                <path class="cls-1" d="M62.52,105.22A4.06,4.06,0,0,0,63.87,103a9.51,9.51,0,0,0,.51-4.32,4,4,0,0,0-2-3.25c-1.42-.75-3.28-.64-4.89-.63-6.11,0-13.93.35-16.91,5.76a11.85,11.85,0,0,0-1.07,5.55c-.07,2.09,0,4.17-.07,6.26,0,.12,0,.25,0,.37a6.56,6.56,0,0,0,.12,2.46c.6,1.81,3.43,2.31,5.32,2.56a14.83,14.83,0,0,0,7.62-1c1.63-.68,1.89-1.71,1.91-3.16q0-1.8.18-3.6a3.39,3.39,0,0,1,.89-2.47,8.83,8.83,0,0,1,5.79-2A2.37,2.37,0,0,0,62.52,105.22Z" />
                <path class="cls-2" d="M68.66,95.2c-1.37,0-1.85,2.82-2,3.69a37.62,37.62,0,0,0-.13,5.91c0,1.21,1.15,1.19,2.16,1.48,2.2.64,2.76,1.88,3.21,3.87.7,3.1.4,7-3.09,8.52a17.3,17.3,0,0,1-6.67,1c-4.31.09-8.59-.3-12.91-.14a11.87,11.87,0,0,0-5.47,1.14,4.52,4.52,0,0,0-2,4.43c.31,5.3,0,10.61-.06,15.91a9.72,9.72,0,0,0,.21,2.69,3.49,3.49,0,0,0,1.59,2.17,5.31,5.31,0,0,0,2,.5c1.22.14,2.44.2,3.67.23,1.56,0,3.56,0,4.57-1.31a5.21,5.21,0,0,0,.89-2.24c.68-3.47.36-7.22.21-10.72,0-.38,0-.76-.05-1.14,0-.6-.08-.56.52-.61.88-.08,1.83,0,2.71.05,1.71,0,3.42,0,5.14-.07a51.29,51.29,0,0,0,9.5-1.07c3-.68,6.22-1.72,8.36-3.85,2.33-2.31,2.9-5,3.32-8a53.15,53.15,0,0,0,.55-9.17,13.52,13.52,0,0,0-3.55-8.56,15.44,15.44,0,0,0-9.7-4.54c-.73-.08-1.46-.14-2.19-.16Z" />
                <path class="cls-2" d="M109.19,124.4v9.82h-4v8.87H91.42V119.41q0-6.89,4.67-10.68c3.12-2.54,7.49-3.81,13.14-3.81q8.14,0,12.06,3.45T125.2,119v24.06H111.4V119.76a5.15,5.15,0,0,0-.65-3,2.75,2.75,0,0,0-2.31-.84q-3.22,0-3.22,3.87v4.64Z" />
                <path class="cls-2" d="M181.71,105.85v26.82a10.2,10.2,0,0,1-3.77,8.18,14.68,14.68,0,0,1-9.75,3.17q-7.22,0-11-5.27a14.33,14.33,0,0,1-5,4.05,16.06,16.06,0,0,1-6.63,1.22q-6.26,0-9.58-3.17t-3.33-9.11V105.85H146.4v24.23a5.08,5.08,0,0,0,.36,2.37,1.58,1.58,0,0,0,1.44.57c1.36,0,2-.92,2-2.75V105.85H164v24.23a4.93,4.93,0,0,0,.37,2.34,1.6,1.6,0,0,0,1.47.6c1.35,0,2-1,2-2.94V105.85Z" />
                <path class="cls-1" d="M205.16,130.21v-9.77c2.78,0,4.18-.85,4.18-2.56,0-1.56-1.07-2.35-3.2-2.35s-3.22,1.08-3.22,3.22v24.34h-13.8V119.9A16.47,16.47,0,0,1,190,114a11.76,11.76,0,0,1,3.07-4.3,18,18,0,0,1,6.12-3.49,22.94,22.94,0,0,1,7.58-1.28,18.5,18.5,0,0,1,11.88,3.82,11.67,11.67,0,0,1,4.81,9.47,10.8,10.8,0,0,1-4.32,8.89q-3.94,3.14-11.89,3.14Z" />
                <path class="cls-1" d="M246,124.4v9.82h-4v8.87h-13.8V119.41q0-6.89,4.68-10.68T246,104.92q8.16,0,12.06,3.45T262,119v24.06h-13.8V119.76a5.24,5.24,0,0,0-.64-3,2.75,2.75,0,0,0-2.31-.84q-3.22,0-3.23,3.87v4.64Z" />
                <path class="cls-1" d="M269.42,105.85h13.8V128c0,1.73.34,2.88,1,3.46s2.06.86,4.1.86h.71v10.8h-3.67q-7.54,0-11.76-3.53t-4.21-9.81Z" />
            </svg>
        </a>
    </div>
    <div class="nav-links">
        <ul>
            <li><a href="<?= BASE_URL ?>/">Home</a></li>
            <li><a href="<?= BASE_URL ?>/pets">Pets</a></li>
            <li><a href="<?= BASE_URL ?>/about">About</a></li>
        </ul>
    </div>
    <div class="auth-links">
        <?php if (Auth::isAuthenticated()): ?>
            <?php include 'src/Views/partials/avatar.php'; ?>
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