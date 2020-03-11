<?php

namespace App\Models;

use App\Enums\UserStateEnum;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
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
    public static function addUser(Utilisateur $utilisateur): ?Personnel
    {
        $personnel = new Personnel;

        $personnel->id = $utilisateur->id;
        $personnel->statut = UserStateEnum::STATE_NEWLY_CREATED;
        //$personnel->id_ligue = null;
        //$personnel->rang = null;

        // TODO Found why workaround is needed here!
        $personnel_copy = clone $personnel; // stupid workaround

        if (!$personnel->save())
            return null;
        return $personnel_copy;
    }

    public function getUser(): Utilisateur
    {
        return Utilisateur::find($this->id);
        // return $this->belongsTo(UtilisateurModel::class, 'id')->getRelated();
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
