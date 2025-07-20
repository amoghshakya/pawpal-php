<?php
$title = "PawPal - Home";
$extraStyles = [
    'home.css',
];
?>

<?php include 'src/Views/partials/header.php'; ?>

<header>
    <?php include 'src/Views/partials/navbar.php'; ?>
</header>
<main>
    <section class="container">
        <div class="hero">
            <h1>
                Find your perfect pet companion with PawPal!
            </h1>
            <img
                src="<?= BASE_URL ?>/public/gang.png"
                alt="A group of happy dogs"
                draggable="false"
                class="hero-image" />
            <div class="cta">
                <!-- ok -->
            </div>
        </div>
    </section>
</main>