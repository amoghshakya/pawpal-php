<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\Auth;

class AuthController
{
    public function __construct()
    {
        // Constructor can be empty since we use static methods
    }

    private function validateRegistrationData(array $data): array
    {
        $errors = [];

        // Validate name (required, min length)
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required.';
        } else if (strlen($data['name']) < 3) {
            $errors['name'] = 'Name must be at least 3 characters long.';
        } else if (preg_match('/[^a-zA-Z\s]/', $data['name'])) {
            $errors['name'] = 'Name can only contain letters and spaces.';
        }

        // Validate email (required, valid format, unique)
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required.';
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        } else if (User::findByEmail($data['email'])) {
            $errors['email'] = 'Email is already registered.';
        }

        // Validate phone (required)
        if (empty($data['phone'])) {
            $errors['phone'] = 'Phone number is required.';
        } elseif (!preg_match('/^\+?[0-9\s\-()]+$/', $data['phone'])) {
            $errors['phone'] = 'Invalid phone number format.';
        }

        // Validate address, city, state (required)
        if (empty($data['address'])) {
            $errors['address'] = 'Address is required.';
        }
        if (empty($data['city'])) {
            $errors['city'] = 'City is required.';
        }
        if (empty($data['state'])) {
            $errors['state'] = 'State is required.';
        }

        $fields = ['address', 'city', 'state'];
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = ucfirst($field) . ' is required.';
            } elseif (strlen($data[$field]) < 2) {
                $errors[$field] = ucfirst($field) . ' must be at least 2 characters long.';
            } elseif (preg_match('/[^a-zA-Z0-9\s,.-]/', $data[$field])) {
                $errors[$field] = ucfirst($field) . ' can only contain letters, numbers, spaces, commas, and periods.';
            }
        }


        // Password validation
        // 1. Required
        // 2. Minimum length
        // 3. Must match confirmation
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required.';
        } else if (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters long.';
        } else if ($data['password'] !== $data['password_confirmation']) {
            $errors['password_confirmation'] = 'Passwords do not match.';
        }

        // Role validation
        // I don't think this is required, since we default to 'adopter'
        if (empty($data['role'])) {
            $errors['role'] = 'Role is required.';
        }

        return $errors;
    }

    public function register()
    {
        // Start session only if one isn't already active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // If user is already logged in, redirect to home page
        if (Auth::isAuthenticated()) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateRegistrationData($_POST);

            // If no errors, go ahead
            if (empty($errors)) {
                $user = User::create([
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'phone' => $_POST['phone'],
                    'address' => $_POST['address'],
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'role' => $_POST['role'] ?? 'adopter',
                ]);
                if ($user) {
                    // Log the user in 
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['role'] = $user->role;
                    header('Location: ' . BASE_URL . '/');
                } else {
                    $errors['general'] = "Registration failed. Please try again.";
                }
            }
        }

        include __DIR__ . '/../Views/auth/register.php';
    }


    private function validateLoginData(array $data): array
    {
        $errors = [];

        // Validate email (required, valid format)
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required.';
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        }

        // Validate password (required)
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required.';
        }

        return $errors;
    }

    public function login()
    {
        if (Auth::isAuthenticated()) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateLoginData($_POST);
            if (empty($errors)) {
                $user = User::findByEmail($_POST['email']);
                if ($user && password_verify($_POST['password'], $user->password)) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['role'] = $user->role;
                    header('Location: ' . BASE_URL . '/');
                    exit;
                }
                $errors['email'] = "Invalid credentials.";
            }
        }

        include __DIR__ . '/../Views/auth/login.php';
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Auth::isAuthenticated()) {
                header('Location: ' . BASE_URL . '/login');
                exit;
            }
            session_destroy();
            header('Location: ' . BASE_URL . '/');
            exit;
        }
    }
}
