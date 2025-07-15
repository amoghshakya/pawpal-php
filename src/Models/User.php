<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class User extends Model
{
    public int $id;
    public string $name;
    public string $email;
    public string $phone;
    public string $address;
    public string $city;
    public string $state;
    public string $role;
    public ?string $created_at;
    public ?string $updated_at;


    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function findByEmail(string $email)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): ?self
    {
        $user = new self($data);
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)"
        );
        if ($stmt->execute([$user->name, $user->email, $user->password, $user->role])) {
            $user->id = $db->lastInsertId();
            return $user;
        }
        return null;
    }

    public static function find(int $id): ?self
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new self($data);
        }

        return null;
    }

    public static function all(): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($user) => new self($user), $users);
    }
}
