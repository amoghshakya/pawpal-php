<?php
echo "=== ROUTING TEST ===\n";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$page = str_replace($scriptDir, '', $requestUri);

echo "Parsed page: '$page'\n";

if ($page === '/register') {
    echo "✅ Registration route matches!\n";
} else {
    echo "❌ Registration route does NOT match. Expected '/register', got '$page'\n";
}
?>
