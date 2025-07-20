<?php

namespace App\Utils;


class Utils
{
    public static function initials(string $name): string
    {
        $words = preg_split('/\s+/', trim($name));

        if (count($words) === 0) return '';
        if (count($words) === 1) return strtoupper($words[0][0]);

        return strtoupper($words[0][0] . end($words)[0]);
    }
}
