<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
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

    public static function deleteSpace(int $space_id): bool
    {
        $space = Place::find($space_id);
        if ($space === null)
            return false;
        return $space->delete();
    }

    public static function createSpace(string $label): ?Place
    {
        $space = new Place;
        $space->numero = $label;
        $space->disponible = true;

        if (!$space->save())
            return null;
        return $space;
    }
}
