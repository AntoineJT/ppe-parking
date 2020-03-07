<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatutModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'statut';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'type_statut';

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
}
