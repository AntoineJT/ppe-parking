<?php

namespace App\Models;

use App\Enums\UserStateEnum;
use App\Utils\AssertionManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Personnel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function addUser(Utilisateur $utilisateur, int $ligue_id): ?Personnel
    {
        $personnel = new Personnel;

        $personnel->id_utilisateur = $utilisateur->id;
        $personnel->statut = UserStateEnum::STATE_NEWLY_CREATED;
        $personnel->id_ligue = $ligue_id;
        //$personnel->rang = null;

        if (!$personnel->save())
            return null;
        return $personnel;
    }

    public function getUser(): Utilisateur
    {
        return Utilisateur::find($this->id_utilisateur);
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

    public function setLigue(int $ligue_id): bool
    {
        $this->id_ligue = $ligue_id;
        return $this->save();
    }

    public static function find_(int $user_id): ?Personnel
    {
        return Personnel::firstWhere('id_utilisateur', $user_id);
    }

    public function deleteUser(): bool
    {
        $user = Utilisateur::find($this->id_utilisateur);
        if ($user === null)
            return false;

        $succeed = false;
        AssertionManager::setAssertException(true); // make assert throws AssertException

        DB::transaction(function() use ($user, &$succeed) {
            foreach(LienReset::where('id_utilisateur', $user->id)->get() as $link)
                assert($link->delete());
            assert($this->delete());
            assert($user->delete());

            $succeed = true;
        });

        AssertionManager::rollbackAssertException(); // avoid side-effects
        return $succeed;
    }
}
