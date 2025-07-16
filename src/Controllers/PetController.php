<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Pet;
use App\Models\PetImage;

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

    private function validatePetData(array $data, array $files): array
    {
        $errors = [];

        // Validate required fields
        $requiredFields = ['name', 'species', 'breed', 'age', 'gender', 'location'];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "The field '$field' is required.";
            } else if (strlen($data[$field]) > 255) {
                $errors[$field] = "The field '$field' must not exceed 255 characters.";
            }
        }

        // Check for description
        if (empty($data['description'])) {
            $errors['description'] = "The description field is required.";
        } else if (strlen($data['description']) > 2000) {
            $errors['description'] = "The description must not exceed 2000 characters.";
        }

        // Validate length for name, species, breed
        foreach (['name', 'species', 'breed'] as $field) {
            if (isset($data[$field]) && strlen($data[$field]) < 2) {
                $errors[$field] = "The field '$field' must be at least 2 characters long.";
            }
        }

        // validate for description
        // allow for details
        if (strlen($data['description']) < 100) {
            $errors['description'] = "The description must be at least 100 characters long.";
        }

        // vaccinated and vaccination details
        // if vaccinated is true, vaccination_details must be provided
        if ($data['vaccinated'] === 'true' && empty($data['vaccination_details'])) {
            $errors['vaccination_details'] = "Vaccination details are required if the pet is vaccinated.";
        } else if ($data['vaccinated'] === 'false') {
            $data['vaccination_details'] = null; // Clear vaccination details if not vaccinated
        }

        // also check for files
        // 1. at least one image must be uploaded
        // 2. file mime type must be an image
        if (empty($files['images']['name'][0])) {
            $errors['images'] = "At least one image must be uploaded.";
        } else {
            foreach ($files['images']['tmp_name'] as $index => $tmpName) {
                if ($files['images']['error'][$index] !== UPLOAD_ERR_OK) {
                    continue; // Skip files with upload errors
                }
                $fileType = mime_content_type($tmpName);
                if (strpos($fileType, 'image/') !== 0) {
                    $errors['images'] = "Uploaded files must be images.";
                    break;
                }
            }
        }


        return $errors;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validatePetData($_POST, $_FILES);

            if (empty($errors)) {
                $data = [
                    'name' => $_POST['name'],
                    'species' => $_POST['species'],
                    'breed' => $_POST['breed'],
                    'age' => $_POST['age'],
                    'gender' => $_POST['gender'] ?? 'unknown',
                    'location' => $_POST['location'],
                    'special_needs' => $_POST['special_needs'] ?? null,
                    'description' => $_POST['description'],
                    'vaccinated' => $_POST['vaccinated'] === 'true',
                    'vaccination_details' => $_POST['vaccination_details'] ?? null,
                ];
                $pet = Pet::create($data);
                if ($pet) {
                    // Upload images and captions
                    // The captions are mapped in a JSON as file => caption
                    $imageCaptions = [];
                    if (isset($_POST['captions_json'])) {
                        $imageCaptions = json_decode($_POST['captions_json'], true);
                    }
                    // $_ENV['UPLOAD_DIR'] has the base upload directory
                    $projectRoot = dirname(__DIR__, 2); // go back two directories
                    $uploadBase = rtrim($projectRoot . '/' . getenv('UPLOAD_DIR'), '/');
                    $uploadDir = $uploadBase . '/pets/' . $pet->id . '/';
                    // create the upload directory if it doesn't exist
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $uploadedImages = [];

                    // The caption keys are in the format filename-filesize
                    // e.g., image.jpeg-10763
                    foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                        if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
                            $fileName = $_FILES['images']['name'][$index];
                            $fileSize = $_FILES['images']['size'][$index];
                            $filePath = $uploadDir . basename($fileName);

                            // Move the uploaded file to the upload dir 
                            $fileMoved = move_uploaded_file($tmpName, $filePath);
                            if ($fileMoved) {
                                // Save the image path and caption to pet_images table
                                $captionKey = $fileName . '-' . $fileSize;
                                $caption = isset($imageCaptions[$captionKey]) ? $imageCaptions[$captionKey] : null;

                                $uploadedImages[] = [
                                    'pet_id' => $pet->id,
                                    'image_path' => '/uploads/pets/' . $pet->id . '/' . basename($fileName),
                                    'caption' => $caption
                                ];

                                // Save image and caption data to the database
                                $petImage = PetImage::create([
                                    'pet_id' => $pet->id,
                                    'image_path' => '/uploads/pets/' . $pet->id . '/' . basename($fileName),
                                    'caption' => $caption
                                ]);

                                if (!$petImage) {
                                    $errors['images'] = "Failed to save image data for: " . $fileName;
                                    break; // stop processing if there's an error
                                }

                                header('Location: /pets/' . $pet->id);
                            } else {
                                $errors['images'] = "Failed to upload file: " . $_FILES['images']['name'][$index];
                                break; // stop processing if there's an error
                            }
                        } else {
                            $errors['images'] = "Error uploading image: " . $_FILES['images']['error'][$index];
                            break;
                        }
                    }
                } else {
                    $errors['general'] = "Failed to create pet. Please try again.";
                }
            }
        }

        include __DIR__ . '/../Views/pets/create.php';
    }
}
