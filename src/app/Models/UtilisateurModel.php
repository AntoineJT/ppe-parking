<?php

namespace App\Models;

use App\Enums\UserStateEnum;
use App\Utils\Database\AccountManager;
use App\Utils\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UtilisateurModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'utilisateur';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
//    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
//    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function create(string $last_name, string $first_name, string $mail): ?UtilisateurModel
    {
        // TODO Migrate that
        $user_id = AccountManager::getNextUserId();

        $utilisateur = new UtilisateurModel;

        $utilisateur->id = $user_id;
        $utilisateur->nom = $last_name;
        $utilisateur->prenom = $first_name;
        $utilisateur->mail = $mail;
        $utilisateur->mdp = Hash::make(Generator::generateGarbagePassword());

        if (!$utilisateur->save())
            return null;
        return $utilisateur;
    }

    // TODO check if useful
    public function isPersonnel(): bool
    {
        return self::toPersonnel() !== null;
    }

    public function toPersonnel(): ?PersonnelModel
    {
        return PersonnelModel::find(self::getAttribute('id'));
    }

    public function toAdmin(): ?AdminModel
    {
        return AdminModel::find(self::getAttribute('id'));
    }

    // TODO check if useful
    public function isAdmin(): bool
    {
        return self::toAdmin() !== null;
    }

    public function getState(): int
    {
        $personnel = self::toPersonnel();
        if ($personnel !== null)
            return $personnel->getState();

        $admin = self::toAdmin();
        if ($admin !== null)
            return $admin->getState();

        return -1;
    }
}
