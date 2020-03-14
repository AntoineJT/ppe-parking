<?php

namespace App\Models;

use App\Enums\UserStateEnum;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getState(): int
    {
        return UserStateEnum::STATE_ENABLED;
    }

    public static function addUser(Utilisateur $user): ?Admin
    {
        $admin = new Admin;
        $admin->id_utilisateur = $user->id;
        if (!$admin->save())
            return null;
        return $admin;
    }
}
