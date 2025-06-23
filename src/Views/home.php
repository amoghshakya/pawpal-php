<?php
// Home Page stuff
use App\Models\User;

$pageTitle = "PawPal - Home";
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
        <nav>
            <ul>
                <li>
                    <a href=<?php echo BASE_URL . '/' ?>>
                        Home
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>
                        <a href=<?php echo BASE_URL . '/logout' ?>>
                            Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href=<?php echo BASE_URL . '/login' ?>>Login</a>

                    </li>
                    <li>
                        <a href=<?php echo BASE_URL . '/register' ?>>Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <h1>Hello,
            <?php
            if (isset($_SESSION['user_id'])) {
                $user = User::findById($pdo, $_SESSION['user_id']);
                echo htmlspecialchars($user->name);
            } else {
                echo 'Guest';
            }
            ?>
        </h1>
    </header>
    <main>
        <img src="<?php echo $_ENV['UPLOAD_DIR'] . 'dog.jpeg'; ?>" width='150px' />
    </main>
</body>

</html>
