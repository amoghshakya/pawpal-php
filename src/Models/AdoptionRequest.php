<?php

namespace App\Models;

use App\Config\Database;

enum HousingType: string
{
    case House = 'house';
    case Apartment = 'apartment';
    case Condo = 'condo';
    case Shared = 'shared';
    case Other = 'other';
}

enum HousingOwnership: string
{
    case Own = 'own';
    case Rent = 'rent';
}

enum LandlordPermission: string
{
    case Yes = 'yes';
    case No = 'no';
    case Pending = 'pending';
}

enum HoursUnattended: string
{
    case LessThan2 = '0-2';
    case ThreeToFour = '3-4';
    case FiveToSix = '5-6';
    case SevenToEight = '7-8';
    case MoreThanNine = '9+';
}

enum ApplicationStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
}

class AdoptionRequest extends Model
{
    public int $id;
    public int $pet_id;
    public int $user_id;
    public string $address;
    public string $city;
    public string $state;
    public ?string $zip_code;
    public HousingType $housing_type;
    public HousingOwnership $own_or_rent;
    public ?LandlordPermission $landlord_permission = null;
    public bool $has_other_pets = false;
    public ?string $other_pets_details = null;
    public string $experience;
    public string $living_conditions;
    public HoursUnattended $hours_alone;
    public ApplicationStatus $status = ApplicationStatus::Pending;
    public string $message;
    public ?string $reviewed_at = null;
    public string $created_at;
    public string $updated_at;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (!property_exists($this, $key)) continue;

            // enum handling
            switch ($key) {
                case 'housing_type':
                    $this->housing_type = HousingType::from($value);
                    break;
                case 'own_or_rent':
                    $this->own_or_rent = HousingOwnership::from($value);
                    break;
                case 'landlord_permission':
                    $this->landlord_permission = $value !== null ? LandlordPermission::from($value) : null;
                    break;
                case 'hours_alone':
                    $this->hours_alone = HoursUnattended::from($value);
                    break;
                case 'status':
                    $this->status = ApplicationStatus::from($value);
                    break;
                case 'has_other_pets':
                    $this->has_other_pets = (bool) $value;
                    break;
                default:
                    $this->$key = $value;
            }
        }
    }

    public function save(): bool
    {
        $db = Database::getConnection();
        if (isset($this->id)) {
            // Update existing record
            $stmt = $db->prepare(
                "UPDATE adoption_applications SET 
                pet_id = ?, user_id = ?, address = ?, city = ?, state = ?, zip_code = ?, 
                housing_type = ?, own_or_rent = ?, landlord_permission = ?, has_other_pets = ?, 
                other_pets_details = ?, experience = ?, living_conditions = ?, 
                hours_alone= ?, status = ?, message = ? 
                WHERE id = ?"
            );
            return $stmt->execute([
                $this->pet_id,
                $this->user_id,
                $this->address,
                $this->city,
                $this->state,
                $this->zip_code,
                $this->housing_type->value,
                $this->own_or_rent->value,
                $this->landlord_permission?->value,
                $this->has_other_pets,
                $this->other_pets_details,
                $this->experience,
                $this->living_conditions,
                $this->hours_alone->value,
                $this->status->value,
                $this->message,
                $this->id
            ]);
        } else {
            // create
            $stmt = $db->prepare(
                "INSERT INTO adoption_applications (pet_id, user_id, address, city, state, zip_code, 
                housing_type, own_or_rent, landlord_permission, has_other_pets, other_pets_details, 
                experience, living_conditions, hours_alone, status, message) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $result = $stmt->execute([
                $this->pet_id,
                $this->user_id ?? $_SESSION['user_id'],
                $this->address,
                $this->city,
                $this->state,
                $this->zip_code,
                $this->housing_type->value,
                $this->own_or_rent->value,
                $this->landlord_permission?->value,
                $this->has_other_pets,
                $this->other_pets_details,
                $this->experience,
                $this->living_conditions,
                $this->hours_alone->value,
                $this->status->value,
                $this->message
            ]);
            if ($result) {
                $this->id = $db->lastInsertId();
            }

            return $result;
        }
        return false;
    }

    public static function create(array $data): ?self
    {
        $request = new self($data);
        if ($request->save()) {
            return $request;
        }
        return null;
    }

    public static function find(int $id): ?self
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM adoption_applications WHERE id = ?");
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
        $stmt = $db->query("SELECT * FROM adoption_applications");
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(fn($item) => new self($item), $data);
    }
}
