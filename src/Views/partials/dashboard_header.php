<?php

use App\Utils\Auth;
use App\Utils\Utils;

$headerTitle = $headerTitle ?? "Dashboard";
$headerDescription = $headerDescription ?? "Welcome to your dashboard. Here you can manage your pets, view adoption applications, and more.";
?>

<style>
    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
        border-bottom: 1px solid #e5e7eb;
        padding: 1rem 2rem;
    }

    .header-title {
        flex: 1;
    }

    .header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.25rem;
    }

    .header p {
        color: #6b7280;
    }
</style>

<div class="header">
    <div class="flex items-center" style="gap: 1rem;">
        <!-- Throw in the logo here -->
        <a href="<?= BASE_URL ?>/dashboard">
            <img
                src="https://media.istockphoto.com/id/1005374612/vector/dog-paw-icon-logo.jpg?s=612x612&w=0&k=20&c=Rtyzn4JwMla0IMrbO-6s2GohBpYO9g-N8_B2CDI118E="
                alt="PawPal Logo"
                class="logo" />
        </a>
        <div class="header-title">
            <h1><?= $headerTitle ?></h1>
            <p><?= $headerDescription ?></p>
        </div>
    </div>
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
</div>