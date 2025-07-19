<?php

namespace App\Models;

use App\Config\Database;
use PDO;

enum GenderValues: string
{
  case male = 'male';
  case female = 'female';
  case unknown = 'unknown';
}

enum PetStatus: string
{
  case available = 'available';
  case adopted = 'adopted';
}

class Pet extends Model
{
  public int $id;
  public int $user_id;
  public string $name;
  public string $species;
  public string $breed;
  public string $age;
  public GenderValues $gender;
  public string $description;
  public bool $vaccinated = false;
  public ?string $vaccination_details = null;
  public PetStatus $status = PetStatus::available;
  public string $location;
  public ?string $special_needs = null;
  public string $created_at;
  public string $updated_at;

  public ?string $image_url = null; // for convenience, not in DB
  public ?int $app_count = null; // for convenience, not in DB

  public function __construct(array $data = [])
  {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        if ($key === 'gender') {
          $this->gender = GenderValues::from($value); // or tryFrom()
        } elseif ($key === 'status') {
          $this->status = PetStatus::from($value); // or tryFrom()
        } elseif ($key === 'vaccinated') {
          $this->vaccinated = filter_var($value, FILTER_VALIDATE_BOOL);
        } else {
          $this->$key = $value;
        }
      }
    }
  }

  public static function create(array $data): ?self
  {
    $pet = new self($data);
    if ($pet->save()) {
      return $pet;
    }
    return null;
  }

  public function save()
  {
    $db = Database::getConnection();

    if (isset($this->id)) {
      // Update existing pet
      $stmt = $db->prepare(
        "UPDATE pets 
             SET name = ?, species = ?, breed = ?, age = ?, gender = ?, description = ?, vaccinated = ?, vaccination_details = ?, status = ?, location = ?
             WHERE id = ?"
      );
      return $stmt->execute([
        $this->name,
        $this->species,
        $this->breed,
        $this->age,
        $this->gender->name,
        $this->description,
        (int) $this->vaccinated, // mysql expects tinyint
        $this->vaccination_details,
        $this->status->name,
        $this->location,
        $this->id
      ]);
    } else {
      // Create new pet 
      $stmt = $db->prepare(
        "INSERT INTO pets (user_id, name, species, breed, age, gender, description, vaccinated, vaccination_details, status, location)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
      );
      $result = $stmt->execute([
        $this->user_id ?? $_SESSION['user_id'],
        $this->name,
        $this->species,
        $this->breed,
        $this->age,
        $this->gender->name,
        $this->description,
        (int) $this->vaccinated,
        $this->vaccination_details,
        $this->status->name,
        $this->location
      ]);

      if ($result) {
        $this->id = $db->lastInsertId();
        return true;
      }

      return false;
    }
  }


  public static function find(int $id): ?self
  {
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT * FROM pets WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($data) {
      return new self($data);
    }
    return null;
  }

  public static function all(bool $onlyAvailable = true): array
  {
    $db = Database::getConnection();
    $query = "SELECT * FROM pets";

    if ($onlyAvailable) {
      $query .= " WHERE status = 'available'";
    }
    $stmt = $db->prepare($query);
    $stmt->execute();
    $pets = [];
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $pets[] = new self($data);
    }
    return $pets;
  }

  public function getImages(): array
  {
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT * FROM pet_images WHERE pet_id = ?");
    $stmt->execute([$this->id]);
    $images = [];
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $images[] = new PetImage($data);
    }
    return $images;
  }

  public function status(): PetStatus
  {
    return $this->status;
  }

  public function images(): array
  {
    return $this->getImages();
  }

  public function lister(): User
  {
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$this->user_id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return new User($data);
  }

  public function applications(): array
  {
    $db = Database::getConnection();
    $stmt = $db->prepare("SELECT * FROM adoption_applications WHERE pet_id = ?");
    $stmt->execute([$this->id]);
    $applications = [];
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $applications[] = new AdoptionRequest($data);
    }
    return $applications;
  }

  public static function paginate(int $page = 1, int $limit = 10, bool $onlyAvailable = true): array
  {
    $db = Database::getConnection();

    $offset = ($page - 1) * $limit;
    $query = "SELECT * FROM pets";
    $params = [];

    if ($onlyAvailable) {
      $query .= " WHERE status = ?";
      $params[] = PetStatus::available->name;
    }

    $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;

    $stmt = $db->prepare($query);
    $stmt->execute($params);

    $pets = [];
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $pets[] = new self($data);
    }

    return $pets;
  }

  public function delete(): bool
  {
    $db = Database::getConnection();

    $stmt = $db->prepare("DELETE FROM pets WHERE id = ?");
    // fetch before deleting because executing delete first will 
    // delete the pet image records as well
    $images = $this->getImages();
    $result = $stmt->execute([$this->id]);
    if ($result) {
      // Delete associated images
      // Database automatically deletes on cascade
      // so we delete files from filesystem here 
      foreach ($images as $image) {
        $image->delete();
      }
      return true;
    }
    return false;
  }

  public static function searchByUser(int $userId, string $search = '', ?string $status = null): array
  {
    $db = Database::getConnection();
    $sql = "SELECT p.*,
      (SELECT image_path FROM pet_images WHERE pet_id = p.id LIMIT 1) AS image_url,
      (SELECT COUNT(*) FROM adoption_applications WHERE pet_id = p.id) AS app_count
      FROM pets p WHERE user_id = :user_id";
    $params = [
      'user_id' => $userId,
    ];

    if (!empty($search)) {
      // using a single `q` param doesn't work idk
      $sql .= " AND (name LIKE :q1 OR species LIKE :q2 OR breed LIKE :q3)";
      $params['q1'] = '%' . $search . '%';
      $params['q2'] = '%' . $search . '%';
      $params['q3'] = '%' . $search . '%';
    }

    if ($status) {
      $sql .= " AND status = :status";
      $params['status'] = $status;
    }

    $sql .= " ORDER BY created_at DESC LIMIT 15";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);

    $pets = [];
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $pet = new self($data);
      // we may add additional properties that are from our query:
      $pet->image_url = $data['image_url'] ?? null;
      $pet->app_count = (int) ($data['app_count'] ?? 0);
      $pets[] = $pet->toArray();
    }
    return $pets;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'name' => $this->name,
      'species' => $this->species,
      'breed' => $this->breed,
      'age' => $this->age,
      'gender' => $this->gender->value,
      'description' => $this->description,
      'vaccinated' => $this->vaccinated,
      'vaccination_details' => $this->vaccination_details,
      'status' => $this->status->value,
      'location' => $this->location,
      'special_needs' => $this->special_needs,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      'image_url' => $this->image_url ?? null,
      'app_count' => $this->app_count ?? 0,
    ];
  }
}
