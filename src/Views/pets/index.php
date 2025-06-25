<h1>All Pets</h1>

<?php if (empty($pets)): ?>
    <p>No pets available.</p>
<?php else: ?>
    <?php foreach ($pets as $pet): ?>
        <div>
            <?php foreach ($pet->getImages() as $image): ?>
                <img
                    src=<?php echo $_ENV['UPLOAD_DIR'] . htmlspecialchars($image) ?>
                    width="100"
                    draggable="false" />
            <?php endforeach; ?>
            <strong><?php echo htmlspecialchars($pet->getName()); ?></strong>
            (<?php echo htmlspecialchars($pet->getSpecies()); ?>,
            <?php echo htmlspecialchars($pet->getLocation()); ?>)
            <p>
                <?php echo htmlspecialchars($pet->getDescription() ?: 'No description available.'); ?>
            </p>
            <p>
                <strong>Breed:</strong> <?php echo htmlspecialchars($pet->getBreed() ?: 'Unknown'); ?><br>
            </p>
            <p>
                <strong>Age:</strong> <?php echo htmlspecialchars($pet->getAge() ?: 'Unknown'); ?><br>
            </p>
            <p>
                <strong>Availability: </strong>
                <?php echo htmlspecialchars($pet->getStatus()->name); ?>
            </p>
            <p>
                <strong>
                    Location: </strong>
                <?php echo htmlspecialchars($pet->getLocation()); ?>
            </p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
