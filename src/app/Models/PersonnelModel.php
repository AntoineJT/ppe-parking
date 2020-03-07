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
        global $user;
        // cache avoiding to make some useless database requests
        if ($user === null) {
            $user = UtilisateurModel::find(self::getAttribute('id'));
        }
        return $user;
    }
}
