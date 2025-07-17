<?php
$extraStyles = [
    'forms.css',
    'register.css',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<section class="form-section">
    <div class="form-header">
        <h1>Register</h1>
        <p>Create a new account to start using our services.</p>
    </div>
    <form method="POST">
        <?php if (isset($errors['general'])): ?>
            <span class="error-message">
                <?php echo htmlspecialchars($errors['general']); ?>
            </span>
        <?php endif; ?>
        <fieldset>
            <legend>Personal Information</legend>
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    name="name"
                    value="<?= $_POST['name'] ?? '' ?>"
                    required />
                <?php if (isset($errors['name'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['name']); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input
                    name="email"
                    type="email"
                    value="<?= $_POST['email'] ?? '' ?>"
                    required />
                <?php if (isset($errors['email'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['email']); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input
                    name="phone"
                    type="tel"
                    value="<?= $_POST['phone'] ?? '' ?>"
                    required />
                <?php if (isset($errors['phone'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['phone']); ?>
                    </span>
                <?php endif; ?>
            </div>
        </fieldset>

        <fieldset>
            <legend>Address</legend>
            <div class="form-group">
                <div class="two-column">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input
                            name="address"
                            value="<?= $_POST['address'] ?? '' ?>"
                            required />
                        <?php if (isset($errors['address'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['address']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input
                            name="city"
                            value="<?= $_POST['city'] ?? '' ?>"
                            required />
                        <?php if (isset($errors['city'])): ?>
                            <span class="error-message">
                                <?php echo htmlspecialchars($errors['city']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <input
                    name="state"
                    value="<?= $_POST['state'] ?? '' ?>"
                    required />
                <?php if (isset($errors['state'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['state']); ?>
                    </span>
                <?php endif; ?>
            </div>
        </fieldset>

        <fieldset>
            <legend>Account Information</legend>
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
                <label for="password_confirmation">Confirm Password</label>
                <input name="password_confirmation" type="password" required />
                <?php if (isset($errors['password_confirmation'])): ?>
                    <span class="error-message">
                        <?php echo htmlspecialchars($errors['password_confirmation']); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role">
                    <option value="adopter" selected>Adopter</option>
                    <option value="lister">Lister</option>
                </select>
            </div>
        </fieldset>

        <button type="submit" class="primary">Register</button>
    </form>
    <div class="form-footer">
        <p>Already have an account? <a href="<?= BASE_URL ?>/login">Log in</a></p>
    </div>
</section>