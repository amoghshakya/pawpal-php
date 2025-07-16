<?php
$extraStyles = [
    '/assets/css/forms.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<section class="form-section">
    <div class="form-header">
        <h1>Login</h1>
        <p>Welcome back! Please enter your credentials to continue.</p>
    </div>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input name="email" type="email" required />
            <?php if (isset($errors['email'])): ?>
                <span class="error-message">
                    <?php echo htmlspecialchars($errors['email']); ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input name="password" type="password" required />
            <?php if (isset($errors['password'])): ?>
                <span class="error-message">
                    <?php echo htmlspecialchars($errors['password']); ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <button type="submit" class="primary">Login</button>
        </div>
    </form>
    <div class="form-footer">
        <p>Don't have an account? <a href="<?= BASE_URL ?>/register">Register here</a></p>
    </div>
</section>
