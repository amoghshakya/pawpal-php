<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Pet;

class PetController
{
    private Pet $petModel;

    public function __construct()
    {
        $this->petModel = new Pet();
    }

    // NOTE: Index Page logic
    public function index()
    {
        $pets = Pet::all();
        include __DIR__ . '/../Views/pets/index.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['gender'] = $data['gender'] ?? 'unknown';
            $data['status'] = $data['status'] ?? 'available'; // This shouldn't make sense, but let's keep it for consistency


            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    echo $key . ': [Array] <br>';
                } else {
                    echo $key . ': ' . htmlspecialchars($value) . '<br>';
                }
            }

            $pet = new Pet($data);
            if ($pet->save()) {
                // Handle file uploads
                $pet_id = $pet->getId();
                $uploadBaseDir = __DIR__ . '/../../uploads/pets/';
                $petDir = $uploadBaseDir . $pet_id . '/';

                if (!is_dir($petDir)) {
                    mkdir($petDir, 0755, true);
                }

                $uploadedImagesNames = [];

                if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
                    $existingFiles = glob($petDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                    $startIndex = count($existingFiles) + 1;

                    $count = count($_FILES['images']['name']);
                    for ($i = 0; $i < $count; $i++) {
                        if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                            $tmpName = $_FILES['images']['tmp_name'][$i];
                            $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));

                            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) continue;

                            $filename = $startIndex++ . '.' . $ext;
                            $destination = $petDir . $filename;

                            if (move_uploaded_file($tmpName, $destination)) {
                                $relativePath = "pets/{$pet_id}/" . $filename;
                                $uploadedImagesNames[] = $relativePath;
                            }
                        }
                    }
                }

                $db = Database::getConnection();
                // Save image paths to the database
                $stmt = $db->prepare("INSERT INTO pet_images (pet_id, image_path) VALUES (?, ?)");
                foreach ($uploadedImagesNames as $imagePath) {
                    $stmt->execute([$pet_id, $imagePath]);
                }

                // TODO: Redirect to the pet's detail page instead of index
                // header('Location: ' . BASE_URL . '/pets');
                exit;
            } else {
                // http_response_code(500);
                echo "Error saving pet.";
            }
        }

        include __DIR__ . '/../Views/pets/create.php';
    }
}
