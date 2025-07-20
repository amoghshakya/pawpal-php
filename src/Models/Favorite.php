<?php

namespace App\Models;

use App\Config\Database;

class Favorite extends Model
{
    public int $id;
    public int $user_id;
    public int $pet_id;
    public string $created_at;
    public string $updated_at;

    public ?User $user = null;
    public ?Pet $pet = null;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function find(int $id): ?Favorite
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM favorites WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new self($data);
        }
        return null;
    }

    public static function create(array $data): ?Favorite
    {
        $favorite = new self($data);
        if ($favorite->save()) {
            return $favorite;
        }
        return null;
    }

    public function save(): bool
    {
        $db = Database::getConnection();
        if (isset($this->id)) {
            // Update existing record
            $stmt = $db->prepare(
                "UPDATE favorites SET user_id = ?, pet_id = ?, updated_at = NOW() WHERE id = ?"
            );
            return $stmt->execute([
                $this->user_id,
                $this->pet_id,
                $this->id
            ]);
        } else {
            // Insert new record
            $stmt = $db->prepare(
                "INSERT INTO favorites (user_id, pet_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())"
            );
            $result = $stmt->execute([
                $this->user_id,
                $this->pet_id,
            ]);
            if ($result) {
                $this->id = $db->lastInsertId();
                return true;
            }
            return false;
        }
    }

    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM favorites");
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $favorites = [];
        foreach ($data as $row) {
            $favorites[] = new self($row);
        }
        return $favorites;
    }

    public static function findByUnique(int $userId, int $petId): ?self
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM favorites WHERE user_id = ? AND pet_id = ?");
        $stmt->execute([$userId, $petId]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new self($data);
        }
        return null;
    }

    public function delete(): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM favorites WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
