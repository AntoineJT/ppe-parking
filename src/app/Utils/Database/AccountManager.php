<?php


namespace App\Utils\Database;

use App\Enums\StateEnum;
use Illuminate\Support\Facades\DB;

class AccountManager
{
    public static function getUserState(int $user_id): int
    {
        // if not personnel, must be admin
        if (!self::isPersonnel($user_id))
            return StateEnum::STATE_ENABLED;
        $value = DB::table('Personnel')
            ->select('valide')
            ->where('id', '=', $user_id)
            ->first()
            ->valide;
        return [StateEnum::STATE_DISABLED, StateEnum::STATE_ENABLED][$value];
    }

    public static function isPersonnel(int $user_id): bool
    {
        return DB::table('Personnel')
            ->join('Utilisateur', 'Personnel.id', '=', 'Utilisateur.id')
            ->where('Utilisateur.id', '=', $user_id)
            ->exists();
    }
}
