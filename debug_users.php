<?php
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once __DIR__ . '/config/database.php';

use App\Config\Database;
use App\Models\User;

try {
    $db = Database::getConnection();
    echo "✅ Database connection successful!\n";
    
    // Count users
    $stmt = $db->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "👥 Number of users: " . $result['count'] . "\n";
    
    if ($result['count'] > 0) {
        // Show all users
        echo "\n📋 Users in database:\n";
        $stmt = $db->query("SELECT id, name, email, role, created_at FROM users");
        $users = $stmt->fetchAll();
        
        foreach ($users as $user) {
            echo "  ID: {$user['id']} | Name: {$user['name']} | Email: {$user['email']} | Role: {$user['role']} | Created: {$user['created_at']}\n";
        }
        
        // Test findByEmail method
        echo "\n🔍 Testing User::findByEmail() method:\n";
        $firstUser = $users[0];
        $foundUser = User::findByEmail($firstUser['email']);
        
        if ($foundUser) {
            echo "✅ User found: {$foundUser->name} ({$foundUser->email})\n";
        } else {
            echo "❌ User NOT found using findByEmail method\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
