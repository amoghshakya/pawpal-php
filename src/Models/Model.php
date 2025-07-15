<?php

/**
 * Base Model Class for MVC architectur
 *
 * a constructor that initializes properties from an associative array,
 * a static method to create a new instance from an array,
 * and a static method to find an instance by ID
 *
 * inspired by laravel
 */

namespace App\Models;

abstract class Model
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Create a new record
    abstract public static function create(array $data): ?Model;

    // Find a record by id
    abstract public static function find(int $id): ?Model;

    // Return all records
    abstract public static function all(): array;
}
