<?php

namespace App\Models;

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
//    public $incrementing = false;

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

    // TODO check if it's really useful (I don't think so)

/*    public static function exists(int $user_id): bool
    {

//        return DB::table('Personnel')
//            ->join('Utilisateur', 'Personnel.id', '=', 'Utilisateur.id')
//            ->where('Utilisateur.id', '=', $user_id)
//            ->exists();
//
        return PersonnelModel::query()
            ->where('id', '=', $user_id)
            ->exists();
    }*/
}
