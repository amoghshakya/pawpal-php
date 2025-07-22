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

define('BASE_URL', rtrim($_ENV['APP_URL'], '/'));

// Start session when user visits the site
session_start();

use App\Controllers\AdoptionRequestController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\PetController;
use App\Utils\Auth;

use App\Controllers\ProfileController;

/**
 * Routing logic
 *
 * Basic idea is to parse the request URI and because we're using xampp,
 * we remove the script directory from the request URI.
 * Now we can match the request URI to a specific route.
 *
 * NOTE: Trailing slashes aren't removed from the request URI,
 * so they will raise a 404. `/pets` != `/pets/`. It's better to 
 * leave it as is, so that we can handle the routes more cleanly.
 */
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$page = str_replace($scriptDir, '', $requestUri);

switch ($page) {
    case '/':
        // Home page logic can be added here if needed
        include __DIR__ . '/src/Views/home.php';
        break;
    case '/about':
        include __DIR__ . '/src/Views/about.php';
        break;
    case '/login':
        (new AuthController())->login();
        break;
    case '/register':
        (new AuthController())->register();
        break;
    case '/logout':
        // NOTE: We may not need a route for this...
        // instead, we can just call the logout method directly
        (new AuthController())->logout();
        break;
    case '/pets':
        if (
            $_SERVER['REQUEST_METHOD'] === 'GET' &&
            ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
        ) {
            (new PetController())->search();
            exit; // Exit after handling AJAX request
        }
        (new PetController())->index();
        break;
    case '/pets/create':
        if (Auth::isAuthenticated()) {
            (new PetController())->create();
            break;
        }
        // If user is not logged in, redirect to login page
        header('Location: ' . BASE_URL . '/login');
        exit;
    case '/dashboard':
        if (Auth::isAuthenticated()) {
            // If user is logged in, show the dashboard
            (new DashboardController())->index();
            break;
        } else {
            // If user is not logged in, redirect to login page
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        break;
    case '/dashboard/applications':
        // If user is logged in, show the adoption applications
        if (Auth::isAuthenticated()) {
            (new DashboardController())->applications();
            break;
        } else {
            // If user is not logged in, redirect to login page
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        break;
    case '/dashboard/search':
        (new DashboardController())->search();
        break;
    case '/dashboard/applications/search':
        (new DashboardController())->searchApplication();
        break;
    case '/dashboard/applications/filter':
        (new DashboardController())->filterApplications();
        break;
    case '/profile':
        if (isset($_SESSION['user_id'])) {
            //If user is logged in, show the profile page
            (new ProfileController())->handleRequest();
        } else {
            // If user is not logged in, redirect to login page
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        break;
    case '/profile/edit':
        if (Auth::isAuthenticated()) {
            //If user is logged in, show the edit profile page
            (new ProfileController())->edit();
        } else {
            // If user is not logged in, redirect to login page
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        break;
    default:
        if (preg_match('/^\/pets\/(\d+)$/', $page, $matches)) {
            // If the page matches the pattern /pets/{id}, show the pet page
            $id = (int)$matches[1];
            $controller = new PetController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $input = json_decode(file_get_contents('php://input'), true);
                if (!$input || !isset($input['pet_id'])) {
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Pet ID is required.']);
                    exit;
                }
                $controller->favorite();
                exit;
            } else {
                // If it's a GET request, show the pet details
                $controller->show($id);
            }
            break;
        }

        if (preg_match('/^\/pets\/(\d+)\/edit$/', $page, $matches)) {
            // If the page matches the pattern /pets/{id}/edit, show the edit pet page
            $id = (int)$matches[1];
            (new PetController())->update($id);
            break;
        }

        if (preg_match('/^\/pets\/(\d+)\/apply$/', $page, $matches)) {
            // If the page matches the pattern /pets/{id}/apply, show the adopt pet page
            $id = (int)$matches[1];
            $controller = new AdoptionRequestController();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->store($id);
            } else {
                $controller->index($id);
            }
            break;
        }

        if (preg_match('/^\/profile\/(\d+)$/', $page, $matches)) {
            // If the page matches the pattern /profile/{id}, show the user's profile
            $userId = (int)$matches[1];
            (new ProfileController())->show($userId);
            break;
        }


        http_response_code(404);
        include __DIR__ . '/src/Views/error.php';
        exit;
}
