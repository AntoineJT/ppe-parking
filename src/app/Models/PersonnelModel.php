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

    // cache member variable
    private $m_user = null;

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
        // cache avoiding to make some useless database requests
        if ($this->m_user === null) {
            $this->m_user = UtilisateurModel::find($this->id);
        }
        return $this->m_user;
    }

    public function getState(): int
    {
        return PersonnelModel::firstWhere('id', $this->id)->statut;
    }

    public function setState(int $user_state): bool
    {
        $this->statut = $user_state;
        return $this->save();
    }
}
