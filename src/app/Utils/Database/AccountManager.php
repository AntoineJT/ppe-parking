<?php


namespace App\Utils\Database;

use Illuminate\Support\Facades\DB;

class AccountManager
{
    public static function isUserIdValid(int $user_id): bool
    {
        $int_max_value = (2 ^ 31 - 1);
        return $user_id > 0 && $user_id <= $int_max_value;
    }

    public static function getNextUserId(): int
    {
        return self::getLastUserId() + 1;
    }

    public static function getLastUserId(): int
    {
        $value = DB::table('Utilisateur')->max('id');
        return $value !== null ? $value : 0;
    }

    public static function getUserIdFromEmail(string $email): int
    {
        $result = DB::table('Utilisateur')
            ->select('id')
            ->where('mail', '=', $email);
        return $result->exists() ? intval($result->get()->first()->id) : -1;
    }
}
