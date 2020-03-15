<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Ligue extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function createLeague(string $name): ?Ligue
    {
        $league = new Ligue;
        $league->nom = $name;
        if (!$league->save())
            return null;
        return $league;
    }

    public static function deleteLeague(int $league_id): bool
    {
        try {
            return Ligue::find($league_id)->delete();
        } catch (Exception $e) {
            return false;
        }
    }

    public static function exists(int $league_id): bool
    {
        return Ligue::find($league_id) !== null;
    }
}
