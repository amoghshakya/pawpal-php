<?php

namespace App\Controllers;

use App\Models\AdoptionRequest;
use App\Models\Pet;
use App\Utils\Auth;

class AdoptionRequestController
{
    private AdoptionRequest $applicationModel;

    public function __construct()
    {
        $this->applicationModel = new AdoptionRequest();
    }

    // for /pets/{id}/apply
    public function index(int $id)
    {
        if (!Auth::isAuthenticated()) {
            http_response_code(403);
            return;
        }

        $pet = Pet::find($id);
        if (!$pet) {
            http_response_code(404);
            include __DIR__ . '/../Views/404.php';
            return;
        }

        if ($pet->lister()->id === $_SESSION['user_id']) {
            http_response_code(403);
            return;
        }

        include __DIR__ . '/../Views/pets/apply.php';
    }

    private function validateApplicationData(array $data): array
    {
        $errors = [];

        $requiredFields = [
            "address",
            "city",
            "state",
            "housingType",
            "ownOrRent",
            "experience",
            "livingConditions",
            "hoursAlone",
        ];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "This field is required.";
            }
        }

        // max characters
        $textFields = [
            "experience" => 1000,
            "livingConditions" => 1500,
            "message" => 1000,
        ];

        foreach ($textFields as $field => $maxLength) {
            if (isset($data[$field]) && strlen($data[$field]) > $maxLength) {
                $errors[$field] = "This field must not exceed $maxLength characters.";
            }
        }

        // min characters
        $minTextFields = [
            "experience" => 50,
            "livingConditions" => 100,
        ];

        foreach ($minTextFields as $field => $minLength) {
            if (isset($data[$field]) && strlen($data[$field]) < $minLength) {
                $errors[$field] = "This field must be at least $minLength characters.";
            }
        }

        // if has other pets is true, other_pets_details is required
        if (isset($data['hasOtherPets']) && $data['hasOtherPets'] === 'on') {
            if (empty($data['otherPetsDetails'])) {
                $errors['otherPetsDetails'] = "Please provide details about your other pets.";
            } elseif (strlen($data['otherPetsDetails']) > 500) {
                $errors['otherPetsDetails'] = "This field must not exceed 500 characters.";
            }
        }

        // if housing ownership is rent, landlord permission is required
        if (isset($data['ownOrRent']) && $data['ownOrRent'] === 'rent') {
            if (empty($data['landlordPermission'])) {
                $errors['landlordPermission'] = "You must provide landlord permission.";
            } elseif (!in_array($data['landlordPermission'], ['yes', 'no', 'pending'])) {
                $errors['landlordPermission'] = "Invalid landlord permission value.";
            }
        }

        if (isset($data['agreeToTerms']) && $data['agreeToTerms'] !== 'on') {
            $errors['agreeToTerms'] = "You must agree to the terms and conditions.";
        }

        return $errors;
    }

    public function store(int $petId)
    {
        if (!Auth::isAuthenticated()) {
            http_response_code(403);
            echo "You must be logged in to submit an adoption application.";
            return;
        }
        $errors = $this->validateApplicationData($_POST);

        if (empty($errors)) {
            $data = [
                'pet_id' => $petId,
                'user_id' => $_SESSION['user_id'],
                'address' => $_POST['address'] ?? '',
                'city' => $_POST['city'] ?? '',
                'state' => $_POST['state'] ?? '',
                'zip_code' => $_POST['zipCode'] ?? '',
                'housing_type' => $_POST['housingType'] ?? '',
                'own_or_rent' => $_POST['ownOrRent'] ?? '',
                'landlord_permission' => $_POST['landlordPermission'] ?? null,
                'has_other_pets' => isset($_POST['hasOtherPets']) ? true : false,
                'other_pets_details' => $_POST['otherPetsDetails'] ?? '',
                'experience' => $_POST['experience'] ?? '',
                'living_conditions' => $_POST['livingConditions'] ?? '',
                'hours_alone' => $_POST['hoursAlone'] ?? '',
                'status' => 'pending',
                'message' => $_POST['message'] ?? '',
            ];

            $application = AdoptionRequest::create($data);

            if ($application) {
                // Redirect to a success page or show a success message
                header('Location: ' . BASE_URL . "/pets/$petId");
                exit;
            }
        }

        $pet = Pet::find($petId);
        include __DIR__ . '/../Views/pets/apply.php';
    }
}
