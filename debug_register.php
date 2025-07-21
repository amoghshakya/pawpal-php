<?php
// Error logging and display settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "=== DEBUG REGISTRATION PAGE ===\n";

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "1. Environment loaded\n";
echo "APP_URL: " . ($_ENV['APP_URL'] ?? 'NOT SET') . "\n";

define('BASE_URL', rtrim($_ENV['APP_URL'], '/'));
echo "2. BASE_URL defined: " . BASE_URL . "\n";

session_start();
echo "3. Session started\n";

use App\Controllers\AuthController;

echo "4. Calling AuthController register method...\n";

try {
    $controller = new AuthController();
    $controller->register();
    echo "5. Register method completed\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>
