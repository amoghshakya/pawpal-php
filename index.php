<?php

require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Models/Pet.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pageTitle = 'Home - PawPal';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <header>
        <h1><?php echo $pageTitle; ?></h1>
    </header>
    <main>
        <img src=<?php echo $_ENV['UPLOAD_DIR'] . 'dog.jpeg' ?> width='150px' />
    </main>
</body>

</html>
