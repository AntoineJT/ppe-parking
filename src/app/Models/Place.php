<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'numero';

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


    public static function deleteSpace(int $league_id): bool
    {
        try {
            return Place::find($league_id)->delete();
        } catch (Exception $e) {
            return false;
        }
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
