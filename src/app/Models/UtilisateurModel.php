<?php

namespace App\Models;

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
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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
        return $this->toPersonnel() !== null;
    }

    public function toPersonnel(): ?PersonnelModel
    {
        return PersonnelModel::find($this->id);
    }

    public function toAdmin(): ?AdminModel
    {
        return AdminModel::find($this->id);
    }

    // TODO check if useful
    public function isAdmin(): bool
    {
        return $this->toAdmin() !== null;
    }

    public function getState(): int
    {
        $personnel = $this->toPersonnel();
        if ($personnel !== null)
            return $personnel->getState();

        $admin = $this->toAdmin();
        if ($admin !== null)
            return $admin->getState();

        return -1;
    }

    public function changePassword(string $password): bool
    {
        $this->mdp = Hash::make($password);
        return $this->save();
    }
}
