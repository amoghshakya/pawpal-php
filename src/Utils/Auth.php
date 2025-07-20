<?php

namespace App\Utils;

use App\Models\User;

class Auth
{
    public static function user(): ?User
    {
        if (self::isAuthenticated()) {
            return User::find($_SESSION['user_id']);
        }
        return null;
    }

    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }
}
