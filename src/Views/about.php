<?php

use App\Utils\Auth;

$title = "PawPal - About";
$extraStyles = [
    'about.css',
];
?>

<?php include 'src/Views/partials/header.php'; ?>


<header>
    <?php include 'src/Views/partials/navbar.php'; ?>
</header>

<main class="container">
    <section class="about-section">
        <h1 class="text-center">About PawPal</h1>
        <div class="grid two-column about-content">
            <div class="about-text">
                <h2>Our Mission</h2>
                <p>
                    At PawPal, we believe every pet deserves a loving home and
                    every family deserves the joy of a furry companion. Our
                    mission is to create meaningful connections between pets in
                    need and caring adopters, making the adoption process simple,
                    transparent, and heartwarming.
                </p>
                <p>
                    PawPal is dedicated to promoting responsible pet ownership
                    and ensuring that every pet finds a forever home. We work with
                    local shelters and rescue organizations to provide a platform
                    where pets can be showcased and adopted by loving families.
                    We strive to educate the community about the importance of
                    adoption and the responsibilities that come with it.
                    The platform is designed to be user-friendly, making it easy for
                    potential adopters to find their perfect match. We also
                    provide resources and support to help new pet owners transition
                    smoothly into pet parenthood.
                </p>
                <p>
                    Join us in our mission to create a world where every pet is
                    cherished and every family has the opportunity to experience
                    the unconditional love that only a pet can provide. Together,
                    we can make a difference, one paw at a time.
                </p>

                <div class="grid about-stats">
                    <div class="stat-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6">
                            <path d="M11.25 16.25h1.5L12 17z" />
                            <path d="M16 14v.5" />
                            <path d="M4.42 11.247A13.152 13.152 0 0 0 4 14.556C4 18.728 7.582 21 12 21s8-2.272 8-6.444a11.702 11.702 0 0 0-.493-3.309" />
                            <path d="M8 14v.5" />
                            <path d="M8.5 8.5c-.384 1.05-1.083 2.028-2.344 2.5-1.931.722-3.576-.297-3.656-1-.113-.994 1.177-6.53 4-7 1.923-.321 3.651.845 3.651 2.235A7.497 7.497 0 0 1 14 5.277c0-1.39 1.844-2.598 3.767-2.277 2.823.47 4.113 6.006 4 7-.08.703-1.725 1.722-3.656 1-1.261-.472-1.855-1.45-2.239-2.5" />
                        </svg>
                        <h3>1000+</h3>
                        <p>Pets Adopted</p>
                    </div>
                    <div class="stat-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-laugh-icon lucide-laugh">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M18 13a6 6 0 0 1-6 5 6 6 0 0 1-6-5h12Z" />
                            <line x1="9" x2="9.01" y1="9" y2="9" />
                            <line x1="15" x2="15.01" y1="9" y2="9" />
                        </svg>
                        <h3>500+</h3>
                        <p>Happy Families</p>
                    </div>
                </div>
            </div>
            <div class="about-image">
                <img
                    src=" <?= BASE_URL ?>/assets/images/pexels-team.jpg"
                    alt="Two people holding a dog"
                    draggable="false" />
            </div>
        </div>
    </section>
</main>

<?php include 'src/Views/partials/footer.php'; ?>