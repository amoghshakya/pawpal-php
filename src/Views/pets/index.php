<h1>All Pets</h1>

<?php if (empty($pets)): ?>
    <p>No pets available.</p>
<?php else: ?>
    <?php foreach ($pets as $pet): ?>
        <div>
            <?php foreach ($pet->getImages() as $image): ?>
                <img
                    src="<?= BASE_URL . $image->image_path ?>"
                    width="100"
                    draggable="false" />
            <?php endforeach; ?>
            <strong><?php echo htmlspecialchars($pet->name); ?></strong>
            (<?php echo htmlspecialchars($pet->species); ?>,
            <?php echo htmlspecialchars($pet->location); ?>)
            <p>
                <?php echo htmlspecialchars($pet->description ?: 'No description available.'); ?>
            </p>
            <p>
                <strong>Breed:</strong> <?php echo htmlspecialchars($pet->breed ?: 'Unknown'); ?><br>
            </p>
            <p>
                <strong>Age:</strong> <?php echo htmlspecialchars($pet->age ?: 'Unknown'); ?><br>
            </p>
            <p>
                <strong>Availability: </strong>
                <?php echo htmlspecialchars($pet->status()->name); ?>
            </p>
            <p>
                <strong>
                    Location: </strong>
                <?php echo htmlspecialchars($pet->location); ?>
            </p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>