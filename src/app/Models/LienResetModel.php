<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class LienResetModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lien_reset';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'lien';

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

    // TODO Utiliser timestamps pour faire expirer les liens
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function saveResetLink(int $id_compte, string $reset_link): bool
    {
        $lien_reset = new LienResetModel();

        $lien_reset->id = $id_compte;
        $lien_reset->lien = $reset_link;

        return $lien_reset->save();
    }

    public static function deleteResetLink(string $reset_link): bool
    {
        try {
            return LienResetModel::query()->find($reset_link)->delete();
        } catch (Exception $e) {
            return false;
        }
    }
}
