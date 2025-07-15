<?php
// Error logging and display settings
// Remove these in production!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once __DIR__ . '/config/database.php';

define('BASE_URL', $_ENV['APP_URL']);

// Start session when user visits the site
session_start();


use App\Controllers\AuthController;
use App\Controllers\PetController;

// Page routing
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        (new AuthController())->login();
        break;
    case 'register':
        (new AuthController())->register();
        break;
    case 'logout':
        // NOTE: We may not need a route for this...
        // instead, we can just call the logout method directly
        (new AuthController())->logout();
        break;
    case 'pets':
        (new PetController())->index();
        break;
    case 'pets/create':
        if (isset($_SESSION["user_id"])) {
            (new PetController())->create();
            break;
        }
        // If user is not logged in, redirect to login page
        header('Location: ' . BASE_URL . '/login');
        exit;
    case 'home':
        // Home page logic can be added here if needed
        $pageTitle = "Welcome to the Home Page";
        include __DIR__ . '/src/Views/home.php';
        break;
    default:
        http_response_code(404);
        include __DIR__ . '/src/Views/404.php';
        exit;
}
