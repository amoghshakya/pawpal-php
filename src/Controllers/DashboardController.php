<?php

namespace App\Controllers;

use App\Models\Pet;
use App\Models\User;

class DashboardController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $user = User::find($_SESSION['user_id']);
        $listings = $user->pets();

        // dashboard view
        include __DIR__ . '/../Views/dashboard/index.php';
    }

    // we search pets here
    public function search()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // prevent browser getting this page
        if (
            $_SERVER['REQUEST_METHOD'] !== 'GET' ||
            ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest'
        ) {
            http_response_code(403); // forbidden
            return;
        }

        $search = trim($_GET['search'] ?? '');
        $status = $_GET['status'];

        $pets = Pet::searchByUser(
            $_SESSION['user_id'],
            $search,
            $status
        );

        echo json_encode($pets);
    }
}
