<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'species',
        'breed',
        'age',
        'gender',
        'status',
        'description',
    ];

    public function lister()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(PetImage::class, 'pet_id');
    }

    public function adoptionApplications()
    {
        return $this->hasMany(AdoptionApplication::class, 'pet_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'pet_id');
    }
}
