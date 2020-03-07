<?php


namespace App\Utils\Database;

use App\Enums\UserStateEnum;
use Illuminate\Support\Facades\DB;

class AccountManager
{
    public static function getUserState(int $user_id): int
    {
        // if not personnel, must be admin
        if (!self::isPersonnel($user_id))
            return UserStateEnum::STATE_ENABLED;
        return DB::table('Personnel')
            ->select('valide')
            ->where('id', '=', $user_id)
            ->first()
            ->valide;
        // return UserStateEnum::getByValue($value);
    }

    public static function isPersonnel(int $user_id): bool
    {
        return DB::table('Personnel')
            ->join('Utilisateur', 'Personnel.id', '=', 'Utilisateur.id')
            ->where('Utilisateur.id', '=', $user_id)
            ->exists();
    }

    public static function isUserIdValid(int $user_id): bool
    {
        $int_max_value = (2 ^ 31 - 1);
        return $user_id > 0 && $user_id <= $int_max_value;
    }

    /*
    public static function addUserToAdmin(int $user_id): bool
    {
        return DB::table('Admin')->insert([
            'id' => $user_id
        ]);
    }
    */

    public static function addUserToPersonnel(int $user_id): bool
    {
        return DB::table('Personnel')->insert([
            'id' => $user_id,
            'valide' => UserStateEnum::STATE_NEWLY_CREATED
        ]);
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
}
