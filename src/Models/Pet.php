<?php

namespace App\Models;

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

class Pet
{

  private PDO $db;

  private ?int $id = null;
  public string $name;
  public string $species;
  private ?string $breed = null;
  private ?int $age = null;
  private GenderValues $gender;
  private ?string $description = null;
  private PetStatus $status = PetStatus::available;
  private string $location;

  public function __construct(PDO $db, array $data = [])
  {
    $this->db = $db;
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        if ($key === 'gender') {
          $this->gender = GenderValues::from($value); // or tryFrom()
        } elseif ($key === 'status') {
          $this->status = PetStatus::from($value); // or tryFrom()
        } else {
          $this->$key = $value;
        }
      }
    }
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function save()
  {
    if (isset($this->id)) {
      // Update existing pet
      $stmt = $this->db->prepare(
        "UPDATE pets SET name = ?, species = ?, breed = ?, age = ?, gender = ?, description = ?, status = ?, location = ? WHERE id = ?"
      );
      return $stmt->execute([
        $this->name,
        $this->species,
        $this->breed,
        $this->age,
        ($gender ?? $this->gender)->name, // Because enums
        $this->description,
        ($status ?? $this->status)->name,
        $this->location,
        $this->id
      ]);
    } else {
      // Create new pet 
      $stmt = $this->db->prepare(
        "INSERT INTO pets (user_id, name, species, breed, age, gender, description, status, location) "
          . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
      );
      $result = $stmt->execute([
        $_SESSION['user_id'],
        $this->name,
        $this->species,
        $this->breed,
        $this->age,
        $this->gender->name,
        $this->description,
        $this->status->name,
        $this->location
      ]);
      if ($result) {
        $this->id = $this->db->lastInsertId();
        return true;
      }
      return false;
    }
  }

  public static function findById(PDO $db, int $id): ?self
  {
    $stmt = $db->prepare("SELECT * FROM pets WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($data) {
      return new self($db, $data);
    }
    return null;
  }

  public static function getAll(PDO $db)
  {
    $stmt = $db->prepare("SELECT * FROM pets;");
    $stmt->execute();
    $pets = [];
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $pets[] = new self($db, $data);
    }
  }

  // TODO: Add other getters and setters as needed
}
