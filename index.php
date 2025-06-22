<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once __DIR__ . '/config/database.php'; // $pdo

define('BASE_URL', $_ENV['APP_URL']);

// Start session when user visits the site
session_start();


use App\Controllers\AuthController;


$pageTitle = "Hello, world!";
// Page routing
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        (new AuthController($pdo))->login();
        break;
    case 'register':
        (new AuthController($pdo))->register();
        break;
    case 'logout':
        (new AuthController($pdo))->logout();
        break;
    case 'dashboard':
        require __DIR__ . '/src/Views/dashboard.php';
        break;
    default:
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
                <h1><?php echo $pageTitle; ?></h1>
            </header>
            <main>
                <img src="<?php echo $_ENV['UPLOAD_DIR'] . 'dog.jpeg'; ?>" width='150px' />
            </main>
        </body>

        </html>
<?php
        break;
}
