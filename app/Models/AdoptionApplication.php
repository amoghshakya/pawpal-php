<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'pet_id',
        'message',
        'has_other_pets',
        'other_pets_details',
        'living_conditions',
        'status',
        'reviewed_at',
    ];

    public function adopter()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function lister()
    {
        return $this->pet->lister();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
