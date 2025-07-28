<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Favorite;
use App\Models\Pet;
use App\Models\PetImage;
use App\Models\PetStatus;
use App\Utils\Auth;
use Dom\Attr;

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
        $isEdit = $data['is_edit'] ?? false;
        $remaining = $data['remaining_images'] ?? 0;
        $hasNewUploads = $data['has_new_uploads'] ?? false;
        $errors = [];

        // Validate required fields
        $requiredFields = ['name', 'species', 'breed', 'age', 'gender', 'location'];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[$field] = "The field '$field' is required.";
            } else if (strlen($data[$field]) > 255) {
                $errors[$field] = "The field '$field' must not exceed 255 characters.";
            } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data[$field])) {
                $errors[$field] = "The field '$field' must not contain special characters.";
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
            $data['vaccination_details'] = null; // clear vaccination details if not vaccinated
        }

        // also check for files
        // 1. at least one image must be uploaded
        // 2. file mime type must be an image
        if (!$isEdit) {
            // The flag passed from edit() method indicates if we are editing an existing pet
            if (empty($files['images']['name'][0])) {
                $errors['images'] = "At least one image must be uploaded.";
            }
        } else {
            // Edit mode
            if ($remaining <= 0 && !$hasNewUploads) {
                // If no images are remaining and no new uploads, we need at least one image
                $errors['images'] = "Please upload at least one image if you remove all existing images. A pet listing requires at least one image.";
            }
        }

        // Validate image files
        if (!empty($files['images']['tmp_name'][0])) {
            foreach ($files['images']['tmp_name'] as $index => $tmpName) {
                if ($files['images']['error'][$index] !== UPLOAD_ERR_OK) continue;

                $fileType = mime_content_type($tmpName);
                if (strpos($fileType, 'image/') !== 0) {
                    $errors['images'] = "Uploaded files must be valid image files.";
                    break;
                }
            }
        }


        return $errors;
    }

    // for creating a new pet, the pets/create route
    public function create()
    {
        $auth = Auth::user();
        if ($auth->role !== 'lister') {
            http_response_code(403); // Forbidden
            include __DIR__ . '/../Views/error.php';
            return;
        }
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
                    $uploadBase = rtrim($projectRoot . '/' . $_ENV['UPLOAD_DIR'], '/');
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
                header('Location: ' . BASE_URL . "/pets/{$pet->id}");
                exit;
            }
        }

        include __DIR__ . '/../Views/pets/create.php';
    }

    // for showing a single pet, the pets/{id} route
    public function show(int $id)
    {
        $pet = Pet::find($id);
        if (!$pet) {
            http_response_code(404);
            include __DIR__ . '/../Views/error.php';
            return;
        }

        include __DIR__ . '/../Views/pets/show.php';
    }

    // also ajax for favorite/unfavorite
    public function favorite()
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
        ) {
            header('Content-Type: application/json');
            // really shouldn't happen unless someone is trying to mess with the API
            if (!Auth::isAuthenticated()) {
                http_response_code(403);
                exit;
            }
            // because application/json
            $input = json_decode(file_get_contents('php://input'), true);
            $petId = $input['pet_id'] ?? null;
            if (!$petId) {
                echo json_encode(['status' => 'error', 'message' => 'Pet ID is required.']);
                exit;
            }

            // Handle favorite/unfavorite action
            $userId = $_SESSION['user_id'];
            $favorite = Favorite::findByUnique($userId, $petId);
            if ($favorite) {
                if ($favorite->delete()) {
                    echo json_encode(['status' => 'success', 'message' => 'Pet removed from favorites.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to remove pet from favorites.']);
                }
            } else {
                $favorite = Favorite::create(['user_id' => $userId, 'pet_id' => $petId]);
                if ($favorite) {
                    echo json_encode(['status' => 'success', 'message' => 'Pet added to favorites.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add pet to favorites.']);
                }
            }
            exit;
        }
        // optional fallback
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit;
    }

    // for update/edit, the pets/{id}/edit route
    public function update(int $id)
    {
        $pet = Pet::find($id);
        if (!$pet) {
            http_response_code(404);
            include __DIR__ . '/../Views/error.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Toggling status
            if (isset($_POST['action']) && $_POST['action'] === 'toggle_status') {
                $pet->status = $pet->status === PetStatus::Available ? PetStatus::Adopted : PetStatus::Available;
                $pet->save();
                header('Location: ' . BASE_URL . "/pets/{$pet->id}/edit");
                exit;
            }
            // Deleting the pet
            if (isset($_POST['action']) && $_POST['action'] === 'delete_listing') {
                // Handle deletion of the pet
                $pet->delete();
                header('Location: ' . BASE_URL . '/pets');
                exit;
            }

            // Editing is very tricky here because we need to handle a lot of things:
            // 1. Updating the pet data (which is straightforward)
            // 2. Handling the images:
            //   - If new images are uploaded, we need to save them (we have already done this)
            //   - If images are deleted, we need to remove them from the database and filesystem
            //   - If image captions are updated, we need to update them in the database
            //   - If no new images are uploaded, we need to keep the existing images (no big deal just dont make any changes)
            // 3. Validating images:
            //   - At least one image must be uploaded and must be image mime type
            //   - We don't have to enforce the "at least one image" rule if the pet already has images
            //   - If no images are uploaded, we can keep the existing images
            //   - If the user removes all images, we have to enforce the "at least one image" rule
            //
            //   The images and captions are handled in a similar way to the create method.
            //   The delete images are handled by checking the POST data for delete_photos array
            //   which contains the image IDs to be deleted.
            //   The caption updates are handled by checking the POST data for update_captions json
            //   The update_captions json is in the format:
            //   { "existing-{image-id}": "new caption" }

            // First, we set a flag to indicate if we are editing/updating the pet 
            $isEdit = true;
            // Check existing image count
            $existingImageCount = count($pet->images());
            // How many images are being deleted?
            $toBeDeleted = isset($_POST['delete_photos']) ? json_decode($_POST['delete_photos'] ?? '[]', true) : [];
            $deleteCount = count($toBeDeleted);

            $remainingAfterDelete = $existingImageCount - $deleteCount;
            $hasNewUploads = isset($_FILES['images']) && !empty($_FILES['images']['name'][0]);

            // modify the post data to include extra information to pass into the validation function
            $_POST['is_edit'] = true;
            $_POST['remaining_images'] = $remainingAfterDelete;
            $_POST['has_new_uploads'] = $hasNewUploads;

            $errors = $this->validatePetData($_POST, $_FILES);
            if (empty($errors)) {
                // Update the pet data 
                $data = [
                    'id' => $pet->id,
                    'name' => $_POST['name'],
                    'species' => $_POST['species'],
                    'breed' => $_POST['breed'],
                    'age' => $_POST['age'],
                    'gender' => $_POST['gender'] ?? 'unknown',
                    'location' => $_POST['location'],
                    'special_needs' => $_POST['special_needs'] ?? null,
                    'description' => $_POST['description'],
                    'vaccinated' => $_POST['vaccinated'] === 'true' ? 1 : 0, // sql expects tinyint
                    'vaccination_details' => $_POST['vaccination_details'] ?? null,
                ];

                // Update the pet in the database
                $pet = new Pet($data);
                $pet->save();

                // Updating captions
                foreach ($_POST['update_captions'] ?? [] as $key => $caption) {
                    // The key is in the format "existing-{image-id}"
                    if (preg_match('/^existing-(\d+)$/', $key, $matches)) {
                        $imageId = (int)$matches[1];
                        // Update the caption for the image
                        PetImage::updateCaption($imageId, $caption);
                    }
                }

                // Delete images
                foreach ($toBeDeleted as $imageId) {
                    $image = PetImage::find($imageId);
                    if ($image) {
                        // Delete the image
                        $image->delete();
                    }
                }

                // New images uploads and captioning
                $imageCaptions = json_decode($_POST['captions_json'] ?? '{}', true);

                $projectRoot = dirname(__DIR__, 2);
                $uploadBase = rtrim($projectRoot . '/' . $_ENV['UPLOAD_DIR'], '/');
                $uploadDir = $uploadBase . '/pets/' . $pet->id . '/';

                // may not be necessary but ok
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                    if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
                        $fileName = $_FILES['images']['name'][$index];
                        $fileSize = $_FILES['images']['size'][$index];
                        $targetPath = $uploadDir . basename($fileName);
                        $moved = move_uploaded_file($tmpName, $targetPath);

                        if ($moved) {
                            $key = $fileName . '-' . $fileSize;
                            $caption = $imageCaptions[$key] ?? null;

                            PetImage::create([
                                'pet_id' => $pet->id,
                                'image_path' => '/uploads/pets/' . $pet->id . '/' . basename($fileName),
                                'caption' => $caption,
                            ]);
                        }
                    }
                }

                header('Location: ' . BASE_URL . "/pets/{$pet->id}");
                exit;
            }
        }

        include __DIR__ . '/../Views/pets/edit.php';
    }

    // API for searching pets and stuff
    // for AJAX requests
    public function search()
    {
        // Allow only AJAX GET requests
        if (
            $_SERVER['REQUEST_METHOD'] !== 'GET' ||
            ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest'
        ) {
            http_response_code(403); // Forbidden
            return;
        }

        $search = $_GET['search'] ?? '';   // search term - name, species, or breed
        $gender = $_GET['gender'] ?? '';
        $vaccinated = $_GET['vaccinated'] ?? '';
        $status = $_GET['status'] ?? PetStatus::Available->value;

        $sql = "SELECT * FROM pets WHERE status = :status";
        $params = ['status' => $status];

        if (!empty($search)) {
            $sql .= " AND (name LIKE :q1 OR species LIKE :q2 OR breed LIKE :q3)";
            // using a single `q` param doesn't work idk
            $params['q1'] = '%' . $search . '%';
            $params['q2'] = '%' . $search . '%';
            $params['q3'] = '%' . $search . '%';
        }

        if (!empty($gender)) {
            $sql .= " AND gender = :gender";
            $params['gender'] = $gender;
        }

        if ($vaccinated === 'yes') {
            $sql .= " AND vaccinated = 1";
        } elseif ($vaccinated === 'no') {
            $sql .= " AND vaccinated = 0";
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = Database::getConnection()->prepare($sql);
        $stmt->execute($params);

        $pets = [];
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $pet = new Pet($data);
            // we may add additional properties that are from our query:
            $pet->image_url = $pet->images()[0]->image_path ?? null;
            $pet_json = $pet->toArray();
            $pet_json['lister'] = $pet->lister()->toArray();
            $pets[] = $pet_json;
        }

        // return as array
        echo json_encode(array_values($pets));
    }
}
