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

    // cache variable
    private $user = null;

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
        if ($this->user === null) {
            $this->user = UtilisateurModel::find(self::getAttribute('id'));
        }
        return $this->user;
    }

    public function getState(): int
    {
        return PersonnelModel::firstWhere('id', self::getAttribute('id'))->statut;
    }
}
