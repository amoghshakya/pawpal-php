<?php
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/config/database.php';

use App\Config\Database;

try {
    $db = Database::getConnection();
    echo "✅ Database connection successful!\n";
    
    // Check if bio column already exists
    $stmt = $db->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (in_array('bio', $columns)) {
        echo "✅ Bio column already exists!\n";
    } else {
        // Add bio column
        $sql = "ALTER TABLE users ADD COLUMN bio TEXT NULL AFTER zip_code";
        $db->exec($sql);
        echo "✅ Bio column added successfully!\n";
    }
    
    // Show updated table structure
    echo "\n📋 Users table structure:\n";
    $stmt = $db->query("DESCRIBE users");
    $structure = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($structure as $column) {
        echo "  {$column['Field']} - {$column['Type']} - {$column['Null']} - {$column['Default']}\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
