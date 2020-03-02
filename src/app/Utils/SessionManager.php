<?php


namespace App\Utils;


use App\Enums\AuthEnum;
use Illuminate\Support\Facades\Session;

class SessionManager
{
    private static function sessionEquals(string $key, $value): bool
    {
        return Session::has($key) && Session::get($key) === $value;
    }

    public static function isLogged(): bool
    {
        return Session::exists('type');
    }

    public static function isSuperAdmin(): bool
    {
        return self::sessionEquals('superAdmin', true);
    }

    public static function isAdmin(): bool
    {
        return self::sessionEquals('type', AuthEnum::AUTH_ADMIN);
    }

    public static function isPersonnel(): bool
    {
        return self::sessionEquals('type', AuthEnum::AUTH_PERSONNEL);
    }

    public static function getFullTypeName(): string
    {
        if (!self::isLogged()) return '';
        if (self::isPersonnel()) return 'animateur';
        if (self::isSuperAdmin()) return 'super-administrateur';
        if (self::isAdmin()) return 'administrateur';
        return '';
    }
}
