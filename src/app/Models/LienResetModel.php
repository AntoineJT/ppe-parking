<?php

namespace App\Models;

use App\Utils\Generator;
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

    public static function create(int $user_id): LienResetModel
    {
        $lien_reset = new LienResetModel();

        $lien_reset->id = $user_id;
        $lien_reset->lien = Generator::generateResetLink();

        if (!$lien_reset->save())
            return null;
        return $lien_reset;
    }

    public static function deleteResetLink(string $reset_link): bool
    {
        try {
            return LienResetModel::find($reset_link)->delete();
        } catch (Exception $e) {
            return false;
        }
    }
}
