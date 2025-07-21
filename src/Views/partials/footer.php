<style>
    footer {
        background-color: #101624;
        color: var(--background);
        margin: 0;
        padding: 1.5rem 2rem;

        @media (max-width: 768px) {
            padding: 1rem;
        }
    }

    .footer-contents {
        grid-template-columns: repeat(3, 1fr);
        margin-bottom: 1.5rem;

        @media (max-width: 768px) {
            grid-template-columns: 1fr;
        }
    }

    footer p {
        color: var(--background);
        font-size: 0.875rem;
    }

    .footer-logo {
        display: flex;
        flex-direction: column;
        align-items: start;
        height: fit-content;
    }

    .footer-logo svg {
        height: 100px;
        width: auto;
    }

    .footer-logo p {
        margin-top: -1rem;
        width: 70%;
    }
</style>

<footer class="grid">
    <div class="grid footer-contents">
        <div class="footer-logo">
            <?php include 'public/logo.svg'; ?>
            <p class="text-muted small">
                Connecting loving families with pets of all species who need homes.
            </p>
        </div>
    </div>
    <p class="text-muted text-center">
        &copy; <?= date('Y') ?> PawPal. All rights reserved.
    </p>
</footer>