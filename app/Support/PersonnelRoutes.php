<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;

class PersonnelRoutes
{
    public static function prefix(?int $userType = null): string
    {
        $userType ??= Auth::user()?->user_type;

        return match ((int) $userType) {
            2 => 'secretaire',
            4 => 'gerant',
            default => 'employe',
        };
    }

    public static function url(string $path = ''): string
    {
        $path = ltrim($path, '/');

        return url(static::prefix() . ($path !== '' ? '/' . $path : ''));
    }

    public static function routeName(string $name): string
    {
        return static::prefix() . '.' . $name;
    }
}
