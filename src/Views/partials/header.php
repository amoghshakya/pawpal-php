<?php
$title = $title ?? 'PawPal';
$extraStyles = $extraStyles ?? [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css" />

    <?php foreach ($extraStyles as $style): ?>
        <link rel="stylesheet" href="<?= BASE_URL . '/assets/css/' . ltrim($style, '/') ?>" />
    <?php endforeach; ?>


    <title><?php echo $title ?></title>
</head>

<body class="">