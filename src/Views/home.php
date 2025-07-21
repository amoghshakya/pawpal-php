<?php

use App\Utils\Auth;

$title = "PawPal - Home";
$extraStyles = [
    'home.css',
];
?>

<?php include 'src/Views/partials/header.php'; ?>

<header>
    <?php include 'src/Views/partials/navbar.php'; ?>
</header>
<main class="">
    <section class="gradient-container">
        <div class="hero container">
            <div class="hero-text">
                <h1>Find Your Perfect Furry, Feathered, or Scaled Companion</h1>
                <p>
                    Connect with loving pets of all species waiting for their forever homes. From dogs and cats to birds and reptiles, discover your ideal companion today.
                </p>

                <div class="cta">
                    <a href="<?= BASE_URL ?>/pets" class="btn">
                        Start Your Search
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
            <img
                class="hero-image"
                src="<?= BASE_URL ?>/assets/images/gang.png"
                alt="A group of happy dogs" />
        </div>
    </section>

    <section class="container">
        <div class="discover">
            <div class="text-center">
                <h2>Discover Your New Best Friend</h2>
                <p>
                    Connecting loving families with adorable pets in need of forever homes
                </p>
            </div>
            <div class="grid two-column discover-grid">
                <div class="discover-image">
                    <img
                        src="<?= BASE_URL ?>/assets/images/pexels-together-dog.jpg"
                        alt="Two golden retrievers together" />
                </div>
                <div class="flex flex-col" style="gap: 1rem;">
                    <div class="flex flex-col discover-text">
                        <h3>Meet Our Adorable Pets</h3>
                        <p>
                            We have a wonderful variety of loving companions waiting for their forever homes. From playful dogs and cuddly cats to charming birds, gentle rabbits, friendly hamsters, and peaceful turtles - there's a perfect match for every family.
                        </p>
                    </div>
                    <div class="discover-actions">
                        <a href="<?= BASE_URL ?>/pets" class="btn primary">
                            <svg height="64px" width="64px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48.84 48.84" xml:space="preserve"
                                fill="var(--background)"
                                stroke-width="0.00048839" class="size-4">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <path d="M39.041,36.843c2.054,3.234,3.022,4.951,3.022,6.742c0,3.537-2.627,5.252-6.166,5.252 c-1.56,0-2.567-0.002-5.112-1.326c0,0-1.649-1.509-5.508-1.354c-3.895-0.154-5.545,1.373-5.545,1.373 c-2.545,1.323-3.516,1.309-5.074,1.309c-3.539,0-6.168-1.713-6.168-5.252c0-1.791,0.971-3.506,3.024-6.742 c0,0,3.881-6.445,7.244-9.477c2.43-2.188,5.973-2.18,5.973-2.18h1.093v-0.001c0,0,3.698-0.009,5.976,2.181 C35.059,30.51,39.041,36.844,39.041,36.843z M16.631,20.878c3.7,0,6.699-4.674,6.699-10.439S20.331,0,16.631,0 S9.932,4.674,9.932,10.439S12.931,20.878,16.631,20.878z M10.211,30.988c2.727-1.259,3.349-5.723,1.388-9.971 s-5.761-6.672-8.488-5.414s-3.348,5.723-1.388,9.971C3.684,29.822,7.484,32.245,10.211,30.988z M32.206,20.878 c3.7,0,6.7-4.674,6.7-10.439S35.906,0,32.206,0s-6.699,4.674-6.699,10.439C25.507,16.204,28.506,20.878,32.206,20.878z M45.727,15.602c-2.728-1.259-6.527,1.165-8.488,5.414s-1.339,8.713,1.389,9.972c2.728,1.258,6.527-1.166,8.488-5.414 S48.455,16.861,45.727,15.602z"></path>
                                    </g>
                                </g>
                            </svg>
                            Browse Pets
                        </a>
                        <a href="<?= BASE_URL ?>/about" class="btn secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"></path>
                            </svg>
                            About us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gradient-container">
        <div class="container flex flex-col items-center join text-center">
            <h2>Join Our Community</h2>
            <p>
                Become part of a loving community dedicated to finding forever homes for pets in need. Whether you're looking to adopt, volunteer, or support our mission, your involvement makes a difference.
            </p>
            <div class="cta">
                <?php if (!Auth::isAuthenticated()): ?>
                    <a href="<?= BASE_URL ?>/register" class="btn">
                        Register as Adopter
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/pets" class="btn">
                        View Pets
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'src/Views/partials/footer.php'; ?>