<?php

namespace App\Models;

use PDO;

class User
{
    private PDO $db;
    private int $id;
    public string $name;
    private string $email;
    private string $password;
    private string $role;
    private string $created_at;


    public function __construct(PDO $db, array $data = [])
    {
        $this->db = $db;
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $name, string $email, string $password, $role = 'adopter')
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$name, $email, $hash, $role]);
    }

    public static function findById(PDO $db, int $id): ?self
    {
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new self($db, $data);
        }

        return null;
    }
}
