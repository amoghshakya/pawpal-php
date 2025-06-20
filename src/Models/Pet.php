<?php

namespace App\Models;

class Pet
{
  private $id;
  private $name;
  private $species;
  private $breed;
  private $age;
  private $gender;
  private $description;
  private $status;
  private $location;

  public function __construct(array $data = [])
  {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        $this->$key = $value;
      }
    }
  }

  public function setName(string $name): void
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  public function save()
  {
    // TODO: Save to database logic
  }

  public function find()
  {
    // TODO: Find from database logic
  }

  // TODO: Add other getters and setters as needed
}
