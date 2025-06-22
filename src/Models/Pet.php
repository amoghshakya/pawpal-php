<?php

namespace App\Models;

use PDO;

class Pet
{
  private PDO $db;

  private ?int $id = null;
  private string $name;
  private string $species;
  private ?string $breed = null;
  private ?int $age = null;
  private string $gender;
  private ?string $description = null;
  private string $status = 'available';
  private string $location;

  public function __construct(PDO $db, array $data = [])
  {
    $this->db = $db;
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        $this->$key = $value;
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
        $this->gender,
        $this->description,
        $this->status,
        $this->location,
        $this->id
      ]);
    } else {
      // Create new pet 
      $stmt = $this->db->prepare(
        "INSERT INTO pets (name, species, breed, age, gender, description, status, location) "
          . "VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
      );
      $result = $stmt->execute([
        $this->name,
        $this->species,
        $this->breed,
        $this->age,
        $this->gender,
        $this->description,
        $this->status,
        $this->location
      ]);
      if ($result) {
        $this->id = $this->db->lastInsertId();
        return true;
      }
      return false;
    }
  }

  public static function find(PDO $db, int $id): ?self
  {
    $stmt = $db->prepare("SELECT * FROM pets WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($data) {
      return new self($data);
    }
    return null;
  }

  // TODO: Add other getters and setters as needed
}
