<?php

namespace App\Models;

use App\Config\Database;

class AdoptionRequest extends Model
{
    public int $id;
    public int $pet_id;
    public int $user_id;
    public string $message;
    public bool $has_other_pets = false;
    public ?string $other_pets_details = null;
    public string $living_conditions;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function save(): bool
    {
        // TODO: Implement update/insertion logic
        return true;
    }

    public static function create(array $data): ?self
    {
        $db = Database::getConnection();
        // TODO: Implement insertion logic
        $user = new self($data);

        return $user;
    }

    public static function find(int $id): ?self
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM adoption_requests WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return new self($data);
        }
        return null;
    }

    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM adoption_requests");
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(fn($item) => new self($item), $data);
    }
}
