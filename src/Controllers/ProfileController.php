<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\AdoptionRequest;
use App\Config\Database;
use PDO;

class ProfileController
{
    private PDO $db;

    public function __construct() {
        // Get the database connection using the Database singleton
        $this->db = Database::getConnection();
    }

    public function handleRequest() {
        // Start session only if one isn't already active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Redirect if user is not logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Fetch user data
        $user = User::find($_SESSION['user_id']);
        
        if (!$user) {
            // User not found, clear session and redirect to login
            session_destroy();
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Get user's adoption history (applications they made)
        $adoptionHistory = $this->getAdoptionHistory($user->id);

        $pageTitle = "PawPal - My Profile";
        require_once __DIR__ . '/../Views/dashboard/profile.php';
    }

    public function edit() {
        // Start session only if one isn't already active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $user = User::find($_SESSION['user_id']);
        if (!$user) {
            session_destroy();
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $errors = [];
        $success = false;

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateProfileData($_POST);
            
            if (empty($errors)) {
                // Handle profile image upload
                $profileImagePath = $user->profile_image; // Keep existing if no new upload
                
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = $this->handleImageUpload($_FILES['profile_image']);
                    if ($uploadResult['success']) {
                        $profileImagePath = $uploadResult['path'];
                        // Delete old image if it exists
                        if ($user->profile_image && file_exists($user->profile_image)) {
                            unlink($user->profile_image);
                        }
                    } else {
                        $errors['profile_image'] = $uploadResult['error'];
                    }
                }

                // Update user if no errors
                if (empty($errors)) {
                    $updateData = [
                        'name' => $_POST['name'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'],
                        'city' => $_POST['city'],
                        'state' => $_POST['state'],
                        'zip_code' => $_POST['zip_code'] ?: null,
                        'bio' => $_POST['bio'] ?: null,
                        'profile_image' => $profileImagePath
                    ];

                    if ($user->update($updateData)) {
                        $success = true;
                        // Update session name if it changed
                        $_SESSION['name'] = $user->name;
                    } else {
                        $errors['general'] = 'Failed to update profile. Please try again.';
                    }
                }
            }
        }

        $pageTitle = "PawPal - Edit Profile";
        require_once __DIR__ . '/../Views/dashboard/editprofile.php';
    }

    private function validateProfileData(array $data): array
    {
        $errors = [];

        // Name validation - required, min 2 chars
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required bro!';
        } elseif (strlen(trim($data['name'])) < 2) {
            $errors['name'] = 'Name gotta be at least 2 characters, come on!';
        }

        // Phone validation - required
        if (empty($data['phone'])) {
            $errors['phone'] = 'Phone number is required mate!';
        }

        // Address validation - required
        if (empty($data['address'])) {
            $errors['address'] = 'Address is required!';
        }

        // City validation - required
        if (empty($data['city'])) {
            $errors['city'] = 'City is required!';
        }

        // State validation - required  
        if (empty($data['state'])) {
            $errors['state'] = 'State is required!';
        }

        // Bio validation - optional but if provided, max 500 chars
        if (!empty($data['bio']) && strlen($data['bio']) > 500) {
            $errors['bio'] = 'Bio is too long! Keep it under 500 characters.';
        }

        return $errors;
    }

    private function handleImageUpload(array $file): array
    {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB max file size
        
        // Check file type
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'error' => 'Only JPEG, PNG, and GIF images are allowed!'];
        }
        
        // Check file size
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'Image too big! Max size is 5MB.'];
        }
        
        // Create upload directory if it doesn't exist
        $uploadDir = 'uploads/profiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('profile_') . '.' . $extension;
        $filepath = $uploadDir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return ['success' => true, 'path' => $filepath];
        } else {
            return ['success' => false, 'error' => 'Failed to upload image. Try again!'];
        }
    }

    private function getAdoptionHistory(int $userId): array
    {
        // Get all adoption applications made by this user with pet details
        $sql = "
            SELECT 
                aa.*,
                p.name as pet_name,
                p.breed,
                p.age,
                p.status as pet_status,
                (SELECT pi.image_path FROM pet_images pi WHERE pi.pet_id = p.id LIMIT 1) as pet_image
            FROM adoption_applications aa
            JOIN pets p ON aa.pet_id = p.id
            WHERE aa.user_id = ?
            ORDER BY aa.created_at DESC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
