<?php

namespace App\Controllers;

use App\Models\AdoptionRequest;
use App\Models\ApplicationStatus;
use App\Models\Pet;
use App\Models\PetStatus;
use App\Models\User;
use App\Utils\Auth;

class DashboardController
{
    public function index()
    {
        if (!Auth::isAuthenticated()) {
            header('Location: /login');
            exit;
        }
        $user = Auth::user();
        $listings = $user->pets();

        // dashboard view
        include __DIR__ . '/../Views/dashboard/index.php';
    }

    // we search pets here
    public function search()
    {
        if (!Auth::isAuthenticated()) {
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
        $status = $_GET['status'] ?? null;

        $pets = Pet::searchByUser(
            $_SESSION['user_id'],
            $search,
            $status
        );

        echo json_encode($pets);
    }

    public function applications()
    {
        if (!Auth::isAuthenticated()) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                http_response_code(400); // bad request
                echo json_encode(['error' => 'ID is required']);
                return;
            }

            $application = AdoptionRequest::find($id);
            if (is_null($application)) {
                http_response_code(404); // not found
                echo json_encode(['error' => 'Application not found']);
                return;
            }

            $application->status = ApplicationStatus::from($_POST['status'] ?? 'pending');
            if (!$application->save()) {
                http_response_code(500); // internal server error
            }
        }

        $user = Auth::user();
        $pets = $user->pets();

        // filter pets with applications and not adopted
        $pets = array_filter($pets, function ($pet) {
            return count($pet->applications(true)) > 0 && $pet->status !== PetStatus::Adopted;
        });

        // applications view
        include __DIR__ . '/../Views/dashboard/applications.php';
    }

    public function searchApplication()
    {
        if (!Auth::isAuthenticated()) {
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

        $id = trim($_GET['id'] ?? '');
        if (empty($id)) {
            http_response_code(400); // bad request
            echo json_encode(['error' => 'ID is required']);
            return;
        }

        $application = AdoptionRequest::find($id);
        if (!$application) {
            http_response_code(404); // not found
            echo json_encode(['error' => 'Application not found']);
            return;
        }

        $application_json = $application->toArray();
        $application_json['pet'] = $application->pet()->toArray();
        $application_json['user'] = $application->applicant()->toArray();

        // return the application as JSON
        echo json_encode($application_json);
    }

    public function filterApplications()
    {
        if (!Auth::isAuthenticated()) {
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

        $status = $_GET['status'] ?? null;

        $user = User::find($_SESSION['user_id']);
        $pets = $user->pets();

        // filter pets with applications
        $pets = array_filter($pets, function ($pet) {
            return count($pet->applications()) > 0 && $pet->status !== PetStatus::Adopted;
        });

        // return in format
        // {
        //  "pet": Pet + Pet->images()[0],
        //  "applications": array of AdoptionRequest + AdoptionRequest->applicant() and email and stuff
        // }[]
        $applications = array_map(function ($pet) use ($status) {
            $applications = $pet->applications();
            if ($status) {
                $applications = array_filter($applications, function ($app) use ($status) {
                    return $app->status === ApplicationStatus::from($status);
                });
            }
            $pet_json = $pet->toArray();
            $pet_json['image_url'] = $pet->images()[0]->image_path;

            return [
                'pet' => $pet_json,
                'applications' => array_map(function ($app) {
                    $app_data = $app->toArray();
                    $app_data['user'] = $app->applicant()->toArray();
                    return $app_data;
                }, $applications)
            ];
        }, $pets);

        // return an array of applications
        // with pet and user details
        echo json_encode(array_values($applications));
    }
}
