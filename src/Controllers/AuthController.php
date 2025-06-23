<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    private User $userModel;

    public function __construct(\PDO $pdo)
    {
        $this->userModel = new User($pdo);
    }

    public function register()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->userModel->create(
                $_POST['name'],
                $_POST['email'],
                $_POST['password'],
                $_POST['role'] ?? 'adopter'
            );
            if ($success) {
                // NOTE: Or you could log the user in and redirect to home page 
                header('Location: ' . BASE_URL . '/login');
                exit;
            } else {
                $error = "Registration failed.";
                // TODO: Show the form below with error message
            }
        }

        include __DIR__ . '/../Views/auth/register.php';
    }

    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->findByEmail($_POST['email']);
            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                header('Location: ' . BASE_URL . '/');
                exit;
            }
            $error = "Invalid credentials.";
        }

        include __DIR__ . '/../Views/auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
