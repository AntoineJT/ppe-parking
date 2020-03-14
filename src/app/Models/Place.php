<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Place extends Model
{
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
    protected $keyType = 'string';

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
        if (!$space->save())
            return null;
        return $space;
    }
}
