<?php


namespace App\Utils\Database;

use App\Enums\UserStateEnum;
use App\Models\UtilisateurModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountManager
{
    public static function getUserState(int $user_id): int
    {
        // if not personnel, must be admin
        if (!UtilisateurModel::find($user_id)->isPersonnel())
            return UserStateEnum::STATE_ENABLED;

        return DB::table('Personnel')
            ->select('statut')
            ->where('id', '=', $user_id)
            ->first()
            ->statut;
    }

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

    public static function changePassword(int $id_compte, string $password): bool
    {
        if (!self::isUserIdValid($id_compte))
            return false;

        $hashed_password = Hash::make($password);

        return DB::table('Utilisateur')
                ->where('id', '=', $id_compte)
                ->update([
                    'mdp' => $hashed_password
                ]) === 1;
    }

    public static function getUserIdFromResetLink(string $reset_link): int
    {
        $result = DB::table('Lien_reset')
            ->select('id')
            ->where('lien', '=', $reset_link)
            ->get();
        return ($result === null) ? -1 : $result->first()->id;
    }

    private static function getUserInfosFromEmail(string $email) {
        return DB::table('Utilisateur')
            ->select('id')
            ->where('mail', '=', $email);
    }

    public static function getUserIdFromEmail(string $email): int
    {
        $result = self::getUserInfosFromEmail($email);
        return $result->exists() ? intval($result->get()->first()->id) : -1;
    }

    public static function isMailLinkedWithAccount(string $email): bool
    {
        return self::getUserInfosFromEmail($email)->exists();
    }

    public static function setPersonnelState(int $user_id, int $user_state): bool
    {
        return DB::table('Personnel')
                ->where('id', '=', $user_id)
                ->update([
                    'statut' => $user_state
                ]) === 1;
    }
}
