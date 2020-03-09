<?php

namespace App\Models;

use App\Enums\UserStateEnum;
use Illuminate\Database\Eloquent\Model;

class PersonnelModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personnel';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // TODO Make use of that
    public static function addUser(UtilisateurModel $utilisateur): ?PersonnelModel
    {
        $personnel = new PersonnelModel;

        $personnel->id = $utilisateur->id;
        $personnel->statut = UserStateEnum::STATE_NEWLY_CREATED;

        if (!$personnel->save())
            return null;
        return $personnel;
    }

    public function getUser(): UtilisateurModel
    {
        return UtilisateurModel::find($this->id);
    }

    public function getState(): int
    {
        return $this->statut;
    }

    public function setState(int $user_state): bool
    {
        $this->statut = $user_state;
        return $this->save();
    }
}
