<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class User extends Model
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $phone;
    public string $address;
    public string $city;
    public string $state;
    public ?string $zip_code;
    public ?string $bio;
    public string $role;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $profile_image = null;


    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function findByEmail(string $email): ?self
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new self($data);
        }
        return null;
    }

    public static function create(array $data): ?self
    {
        $user = new self($data);
        $db = Database::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO users (name, email, password, phone, address, city, state, role)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $hashedPassword = password_hash($user->password, PASSWORD_BCRYPT);
        $success = $stmt->execute([
            $user->name,
            $user->email,
            $hashedPassword,
            $user->phone,
            $user->address,
            $user->city,
            $user->state,
            $user->role ?? 'adopter'
        ]);

        if ($success) {
            $user->id = $db->lastInsertId();
            $user->created_at = date('Y-m-d H:i:s');
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

        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new self($row);
        }
        return $users;
    }

    /**
     * Get all pets listed by this user.
     * 
     * @param bool $availableOnly If true, only return pets that are available for adoption.
     * @return Pet[] Array of Pet objects.
     * 
     * The method name is kind of misleading because it says pets but we return the pet listings.
     * This method is specific to the user of lister type.
     */
    public function pets(bool $availableOnly = false): array
    {
        $db = Database::getConnection();
        $query = "SELECT * FROM pets WHERE user_id = ?";
        $params = [$this->id];

        if ($availableOnly) {
            $query .= " AND status = ?";
            $params[] = 'available';
        }

        $query .= " ORDER BY created_at DESC";
        $stmt = $db->prepare($query);
        $stmt->execute($params);

        $pets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pets[] = new Pet($row);
        }

        return $pets;
    }

    /**
     * Get all adoption applications made by this user.
     * 
     * @return AdoptionRequest[] Array of AdoptionRequest objects.
     * 
     * this method is specific to the user of adopter type. but 
     * any user can call it so okay whatever
     */
    public function applications(): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM adoption_applications WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$this->id]);
        $applications = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $applications[] = new AdoptionRequest($row);
        }
        return $applications;
    }

    public function favorites(): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM favorites WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$this->id]);
        $favorites = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pet = Pet::find($row['pet_id']);
            if ($pet) {
                $favorites[] = $pet;
            }
        }
        return $favorites;
    }

    public function update(array $data): bool
    {
        $db = Database::getConnection();

        // Build the SET clause dynamically based on provided data
        $setClause = [];
        $params = [];

        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $key !== 'id') {
                $setClause[] = "$key = ?";
                $params[] = $value;
                // Update the object property too
                $this->$key = $value;
            }
        }

        // Add the ID for the WHERE clause
        $params[] = $this->id;

        $sql = "UPDATE users SET " . implode(', ', $setClause) . ", updated_at = NOW() WHERE id = ?";
        $stmt = $db->prepare($sql);

        return $stmt->execute($params);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'bio' => $this->bio,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'profile_image' => $this->profile_image
        ];
    }

    public function hasApplied(int $petId): bool
    {
        $db = Database::getConnection();
        // to be fair, there shouldn't be more than one application per user per pet
        // so we can just check if any exists
        $stmt = $db->prepare("SELECT COUNT(*) FROM adoption_applications WHERE user_id = ? AND pet_id = ?");
        $stmt->execute([$this->id, $petId]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
}
