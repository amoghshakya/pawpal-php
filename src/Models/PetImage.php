<?php

namespace App\Models;

use App\Config\Database;

class PetImage extends Model
{
    public int $id;
    public int $pet_id;
    public string $image_path;
    public ?string $caption;
    public string $created_at;
    public string $updated_at;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function create(array $data): ?self
    {
        $image = new self($data);
        if ($image->save()) {
            return $image;
        }
        return null;
    }

    public static function find(int $id): ?self
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM pet_images WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            return new self($data);
        }
        return null;
    }

    public function save(): bool
    {
        $db = Database::getConnection();
        if (isset($this->id)) {
            // Update existing record
            $stmt = $db->prepare(
                "UPDATE pet_images SET pet_id = ?, image_path = ?, caption = ?, updated_at = NOW() WHERE id = ?"
            );
            return $stmt->execute([
                $this->pet_id,
                $this->image_path,
                $this->caption,
                $this->id
            ]);
        } else {
            // Insert new record
            $stmt = $db->prepare(
                "INSERT INTO pet_images (pet_id, image_path, caption, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())"
            );
            $result = $stmt->execute([
                $this->pet_id,
                $this->image_path,
                $this->caption ?? null
            ]);
            if ($result) {
                $this->id = (int)$db->lastInsertId();
                return true;
            }
            return false;
        }
    }

    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM pet_images");
        $images = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $images[] = new self($row);
        }
        return $images;
    }

    public static function updateCaption(int $id, string $caption): bool
    {
        $db = Database::getConnection();
        $self = self::find($id);
        if (!$self) {
            return false; // Image not found
        }
        $self->caption = $caption;
        return $self->save();
    }

    public function delete(): bool
    {
        $db = Database::getConnection();
        if (!isset($this->id)) {
            return false; // Cannot delete an unsaved image
        }
        $stmt = $db->prepare("DELETE FROM pet_images WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
